<?php

include("../partials/dbconnect.php");

if (isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];

    $stmt = $conn->prepare("SELECT  expiry_date FROM bookings WHERE m_phone = ? ORDER BY booking_date DESC LIMIT 1");
    $stmt->bind_param("s", $m_phone);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($exp);
        $stmt->fetch();
        date_default_timezone_set('Asia/Kolkata');
        $today_timestamp = strtotime('today');
        $expiry_timestamp = strtotime($exp);
        if ($expiry_timestamp > $today_timestamp) {
            header("location: member_profile.php?m_phone=$m_phone");
        }
    }

    // Prepare a statement to select the member data from the database
    $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
    $stmt1->bind_param("s", $m_phone);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row = $result1->fetch_assoc();
    $m_name = $row['m_name'];
    $m_email = $row['m_email'];
    $month = $_POST['month'];
    $packID = $_POST['p_name'];
    
}
$stmt6 = $conn->prepare("SELECT price,p_name FROM packages WHERE packID = ?");
$stmt6->bind_param("i", $packID);
$stmt6->execute();
$result6 = $stmt6->get_result();
$row6 = $result6->fetch_assoc();
$price = $row6['price'];
$p_name = $row6['p_name'];
$m_price = $month * $price;

?>
<html>
<head>
    <link rel="website icon" type="png" href="../img/logo.png">
    <link rel="stylesheet" href="..\profile.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<form action="">
<div style="margin:16% 40%;">
    <div>
        <b>Phone: </b><?php echo $m_phone?><br><br>
        <b>Email: </b><?php echo $m_email?><br><br>
        <b>Package Name: </b><?php echo $p_name?><br><br>
        <b>Package Price/Month: </b><?php echo $price?><br><br>
    </div>
    <div>
      <label for="name"><b>Payee Name:</b> </label>
      <input type="text" id="payee_name" value="<?php echo $m_name?>" name="payee_name"><br>
    </div><br>
    <div>
      <label for="pwd"><b>Total Amount:</b> </label>
      <input type="text" id="amount" value="<?php echo $m_price?>" name="amount"><br>
    </div>
    <br><br>
    <center>
    <button id=rzp-button1 class="form-btn" type="button" onclick="pay_now();">Pay</button>
    </center>
</div>
</form> 
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
    function pay_now(){
          //get the input from the form
          var name = $("#payee_name").val();
          var amount = $("#amount").val();
          var actual_amount = amount*100;
          //var actual_amount = amount;
          var options = {
            "key": "rzp_test_KlEgTChWzKiY2v", // Enter the Key ID generated from the Dashboard
            "amount": actual_amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Fitness Club",
            "description": "Fitness Club Membership Fee",
            "image": "../img/logo.png",
            "handler": function (response){
                console.log(response);
                $.ajax({
 
                    url: 'process_payment.php?m_phone=<?php echo $m_phone?>&packID=<?php echo $packID;?>&month=<?php echo $month?>',
                    'type': 'POST',
                    'data': {'payment_id':response.razorpay_payment_id,'amount':actual_amount,'name':name},
                    success:function(data){
                        console.log(data);
                      window.location.href = 'member_profile.php?m_phone=<?php echo $m_phone?>';
                    }
 
                });
            },
             
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response){
                alert(response.error.code);
                alert(response.error.description);
                alert(response.error.source);
                alert(response.error.step);
                alert(response.error.reason);
                alert(response.error.metadata.order_id);
                alert(response.error.metadata.payment_id);
        });
        document.getElementById('rzp-button1').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }
    }
</script> 
</body>
</html>

