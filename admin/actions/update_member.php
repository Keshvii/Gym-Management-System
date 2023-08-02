<?php
include("../../partials/dbconnect.php");

if(isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];
    // Prepare a statement to select the member data from the database
    $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
    $stmt1->bind_param("s", $m_phone);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row = $result1->fetch_assoc();
    $current_m_name = $row['m_name'];
    $current_m_age = $row['m_age'];
    $current_m_gender = $row['m_gender'];
    $current_m_address = $row['m_address'];
    $current_m_medical = $row['m_medical'];
    $current_m_email = $row['m_email'];
    $current_m_shift = $row['m_shift'];

    $stmt7 = $conn->prepare("SELECT * FROM bookings WHERE m_phone=?");
    $stmt7->bind_param("s", $m_phone);
    $stmt7->execute();
    $result7 = $stmt7->get_result();
    if ($result7->num_rows > 0) {
        $row7 = $result7->fetch_assoc();
        $current_month = $row7['month'];
        $current_packID = $row7['packID'];
    } else {
        $current_month = 'None';
        $current_packID = 0;
    }

    $stmt8 = $conn->prepare("SELECT p_name FROM packages WHERE packID=?");
    $stmt8->bind_param("i", $current_packID);
    $stmt8->execute();   
    $result8 = $stmt8->get_result(); 
    if ($result8->num_rows > 0) {
        $row8 = $result8->fetch_assoc();
        $current_p_name = $row8['p_name'];
    } else {
        $current_p_name = "None";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_m_name = $_POST['new_m_name'];
        $new_m_age = $_POST['new_m_age'];
        $new_m_gender = $_POST['new_m_gender'];
        $new_m_address = $_POST['new_m_address'];
        $new_m_medical = $_POST['new_m_medical'];
        $new_m_email = $_POST['new_m_email'];
        $new_m_shift = $_POST['new_m_shift'];

        $new_packID = $_POST['new_p_name'];
        $new_month = $_POST['new_month'];
        $new_booking_date = date('Y-m-d H:i:s');
        $new_expiry_date = date('Y-m-d H:i:s', strtotime('+' . $new_month . ' months', strtotime($new_booking_date)));
        
        $stmt6 = $conn->prepare("SELECT price FROM packages WHERE packID = ?");
        $stmt6->bind_param("i", $new_packID);
        $stmt6->execute();
        $result6 = $stmt6->get_result();
        $row6 = $result6->fetch_assoc();
        $new_price = $row6['price'];

        $new_m_price = $new_month * $new_price;
                

        $stmt2 = $conn->prepare("UPDATE members SET m_name=?, m_age=?, m_gender=?, m_address=?, m_medical=?, m_email=?, m_shift=? WHERE m_phone=?");
        $stmt2->bind_param("sissssss", $new_m_name, $new_m_age, $new_m_gender, $new_m_address, $new_m_medical, $new_m_email, $new_m_shift, $m_phone);


        $stmt10 = $conn->prepare("SELECT * FROM bookings WHERE m_phone=?");
        $stmt10->bind_param("s", $m_phone);
        $stmt10->execute();
        $result10 = $stmt10->get_result();
        if ($result10->num_rows > 0) {
            $stmt3 = $conn->prepare("UPDATE bookings SET booking_date=?, expiry_date=?, packID=?, month=?, m_price=? WHERE m_phone=?");
            $stmt3->bind_param("ssiids", $new_booking_date, $new_expiry_date, $new_packID, $new_month, $new_m_price,$m_phone);    
        }else{    
            $stmt3 = $conn->prepare("INSERT INTO bookings (booking_date, expiry_date,m_phone, packID, month,m_price) VALUES (?,?,?,?,?,?)");
            $stmt3->bind_param("sssiid", $new_booking_date, $new_expiry_date, $m_phone, $new_packID, $new_month, $new_m_price);
        
        }

        if(($stmt2->execute() === TRUE)&&($stmt3->execute() === TRUE)) {
        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
            ---Member details updated successfully---</div>";
        } else {
        echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
            border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Failed! Error: " . $stmt2 . "<br>" .$stmt3."<br>". $conn->error."</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="website icon" type="png" href="../../img/logo.png">
  <link rel="stylesheet" href="add.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.form-container form .form-btn{
  background-color: #0A9396;
}
.form-container form .form-btn:hover{
  background-color: #005F73;
}
i{
  color:#0A9396;
}
i:hover{
  color: #005F73;
}
a{
  color:#0A9396;
}
a:hover{
  color: #005F73;
}
</style>
</head>

<body>
<div class="form-container">
  <form method="post" enctype="multipart/form-data">
        <h3>Update Member Details</h3>
        <label for="new_m_name">Name</label>
        <input type="text" name="new_m_name" value="<?php echo $current_m_name;?>">
        <label for="new_m_age">Age</label>
        <input type="text" name="new_m_age" value="<?php echo $current_m_age;?>" pattern="[0-9]{2}">
        
        <label for="new_m_gender">Select gender</label>
        <select name="new_m_gender">
            <option value="male" <?php if ($current_m_gender == "male") { echo " selected"; } ?>>Male</option>
            <option value="female" <?php if ($current_m_gender == "female") { echo " selected"; } ?>>Female</option>
            <option value="other" <?php if ($current_m_gender == "other") { echo " selected"; } ?>>Other</option>
        </select>
        
        <label for="new_m_address">Address</label>
        <input type="text" name="new_m_address" value="<?php echo $current_m_address;?>">
        
        <label for="new_m_email">Email</label>
        <input type="text" name="new_m_email" value="<?php echo $current_m_email;?>">
        
        <label for="new_m_medical">Pre-medical condition</label>
        <select name="new_m_medical">
            <option value="none" <?php if ($current_m_medical == "none") { echo " selected"; } ?>>None</option>
            <option value="diabetes" <?php if ($current_m_medical == "diabetes") { echo " selected"; } ?>>Diabetes</option>
            <option value="recent_childbirth" <?php if ($current_m_medical == "recent_childbirth") { echo " selected"; } ?>>Recent Childbirth</option>
            <option value="heart_disease" <?php if ($current_m_medical == "heart_disease") { echo " selected"; } ?>>Heart Disease</option>
            <option value="asthma" <?php if ($current_m_medical == "asthma") { echo " selected"; } ?>>Asthma</option>
            <option value="low_blood_pressure" <?php if ($current_m_medical == "low_blood_pressure") { echo " selected"; } ?>>Low Blood Pressure</option>
            <option value="high_blood_pressure" <?php if ($current_m_medical == "high_blood_pressure") { echo " selected"; } ?>>High Blood Pressure</option>
            <option value="thyroid" <?php if ($current_m_medical == "thyroid") { echo " selected"; } ?>>Thyroid</option>
            <option value="other" <?php if ($current_m_medical == "other") { echo " selected"; } ?>>Other</option>
        </select>
        <label for="new_m_shift">Select Shift:</label>
        <select name="new_m_shift" style="text-align:center;">
            <option value="6AM-8AM" <?php if ($current_m_shift == "6AM-8AM") { echo " selected"; } ?>>6AM-8AM :(Men+Women)</option>
            <option value="8AM-10AM" <?php if ($current_m_shift == "8AM-10AM") { echo " selected"; } ?>>8AM-10AM :(Men+Women)</option>
            <option value="10AM-12PM" <?php if ($current_m_shift == "10AM-12PM") { echo " selected"; } ?>>10AM-12PM :(Women)</option>
            <option value="3PM-5PM" <?php if ($current_m_shift == "3PM-5PM") { echo " selected"; } ?>>3PM-5PM :(Women)</option>
            <option value="5PM-7PM" <?php if ($current_m_shift == "5PM-7PM") { echo " selected"; } ?>>5PM-7PM :(Men+Women)</option>
            <option value="7PM-9PM" <?php if ($current_m_shift == "7PM-9PM") { echo " selected"; } ?>>7PM-9PM :(Men)</option>
        </select>
        <h3>Update Member Package Details</h3>
        <label for="new_p_name">Select Package:</label>
        <select name="new_p_name" id="p_name" style="text-align:center;">
            <?php
            // Prepare a SQL statement to select data from the "packages" table
                $sql = "SELECT packID, p_name, price FROM packages";
                $stmt3 = $conn->prepare($sql);

                // Execute the prepared statement
                $stmt3->execute();

                // Bind the result variables
                $stmt3->bind_result($packID, $p_name, $price);

                // Loop through the results and display each option
                while ($stmt3->fetch()) {
                    $selected = "";
                    if ($current_p_name == $p_name) {
                        $selected = " selected";
                    }
                    echo "<option" . $selected . " value='" . $packID . "'>" . $p_name . "<span style='font-weight:bold;'> Rs " . $price . "/month" . "</span></option>";
                }                
                $stmt3->close();
            ?>
            </select>
            <label for="new_month">Month (Enter value from 1 to 12):</label>
            <input type="number" name="new_month" required min="1" max="12" value="<?php echo $current_month;?>">

    <input type="submit" value="Update Member Details" class="form-btn"><br><br>
    <a href="../members.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>