<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];

    // Prepare a statement to select the member data from the database
    $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
    $stmt1->bind_param("s", $m_phone);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row = $result1->fetch_assoc();
    $m_name = $row['m_name'];
    $m_age = $row['m_age'];
    $m_gender = $row['m_gender'];
    $m_address = $row['m_address'];
    $m_medical = $row['m_medical'];
    $m_email = $row['m_email'];
    $m_shift = $row['m_shift'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMS</title>
    <link rel="website icon" type="png" href="../img/logo.png">
    <link rel="stylesheet" href="profile.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
#record tr td{
    text-align:left;
    padding-left:40px;
    padding-right:40px;
}
</style>
</head>
<body>
<div class="container">
    <!--Navigation Bar-->
    <div class="navbar">
        <div class="logo">
            <img src="../img/memberlogoslogan.png" alt="logo">
        </div>
        <?php
          $stmt1 = $conn->prepare("SELECT * FROM contacts");
          $stmt1->execute();
          $result = $stmt1->get_result();
          $row = $result->fetch_assoc();
          $mobile = $row['mobile'];
          $email = $row['email'];
        ?>
        <ul>
            <li><a href="update_memdetails.php?m_phone=<?php echo $m_phone?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Details</a></li>
            <li><a href="#booking"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Book Package</a></li>
            <li><a href="#rec"><i class="fa fa-file-text" aria-hidden="true"></i> Receipt</a></li>
            <li><a href="#ecard"><i class="fa fa-id-card-o" aria-hidden="true"></i> Entry Card</a></li>
            <li><a href="tel:+<?php echo $mobile?>"><i class="fa fa-phone" aria-hidden="true"></i> Call Us</a></li>
            <li><a href="mailto:<?php echo $email?>"><i class="fa fa-envelope" aria-hidden="true"></i> Email Us</a></li>
            <li><a href="../customer/mem_logout.php" id="loginbtn"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
        </ul>    
    </div>
    <?php
    if(isset($_SESSION['mem_login'])) {
        echo "<div class='session' style='text-align:center;background-color:#dff0d8;color:#3c763d;
        border:1px solid #3c763d;font-size:20px; padding:5px;'>{$_SESSION['mem_login']}</div>";
        unset($_SESSION['mem_login']);
    }
    ?>
</div>
<div id="profile">
    <div class="wel_msg">
        <p>Welcome!! <i class="fa fa-user" aria-hidden="true"></i><span style="color: rgb(210, 24, 62);"> <?php echo $m_name;?></span>...</p>
    </div>
    <div class="mem_details">
    <table  style="width:100%;table-layout:fixed;">
        <tr>
            <td>
            Age: <br><b><?php echo $m_age; ?></b>
            </td>
            <td>
            Gender: <br><b><?php echo $m_gender; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Address: <br><b><?php echo $m_address; ?></b>
            </td>
            <td>
            Medical: <br><b><?php echo $m_medical; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Phone: <br><b><?php echo $m_phone; ?></b>
            </td>
            <td>
            Email: <br><b><b><?php echo $m_email; ?></b></b>
            </td>
        </tr>
        <tr>
            <td>
            Shift: <br><b><b><?php echo $m_shift; ?></b></b>
            </td>
            <td>
            Trainer: <br><b><b>
            <?php
                $stmt2 = $conn->prepare("SELECT t_name FROM trainers WHERE t_shift = ?");
                $stmt2->bind_param("i", $m_shift);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $t_name = $row['t_name'];
                        echo $t_name."<br>";
                    }
                }
            ?></b></b>
            </td>
        </tr>
    </table>
    <p id="booking"></p>
    </div>

    <center><img src="../img/book_package.png" alt="BOOK PACKAGE" width="45%"></center>
    <div class="booking">

    <script>
    function updateDate() {
    // Get the selected number of months
    var months = document.getElementById("months").value;

    // Calculate expiry date based on selected months
    var expiryDate = new Date();
    expiryDate.setMonth(expiryDate.getMonth() + parseInt(months));
    document.getElementById("expiryDate").innerHTML = expiryDate.getFullYear() + "-" + (expiryDate.getMonth() + 1) + "-" + expiryDate.getDate();

    // Calculate booking date
    var bookingDate = new Date();
    document.getElementById("bookingDate").innerHTML = bookingDate.getFullYear() + "-" + (bookingDate.getMonth() + 1) + "-" + bookingDate.getDate();
    }
    </script>
    <?php
        if (isset($_GET['m_phone'])) {
            $m_phone = $_GET['m_phone'];

        // Check if the user has a previous booking record or if the last record has expired
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
                // Show message that booking cannot be made as the last record has not yet expired
                echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                border:1px solid #a94442;font-size:20px; padding:5px;'>New Booking cannot be done as the last record has not yet expired.</div>";
            }
        }
    }
    ?>
    <div>
    <?php
    if(isset($_SESSION['book'])) {
        echo "<div class='session' style='text-align:center;background-color:#dff0d8;color:#3c763d;
        border:1px solid #3c763d;font-size:20px; padding:5px;'>{$_SESSION['book']}</div>";
        unset($_SESSION['book']);
    }
    ?>
    </div>
    <br><br>
    <table style="width:100%;table-layout:fixed;">
    <form method="post" enctype="multipart/form-data" action="booking_details.php?m_phone=<?php echo $m_phone?>">
        <tr>
            <td>
            Select Package Name: 
            <select name="p_name" id="p_name" style="text-align:center;" required onchange="updatePrice()" required>
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
                    echo "<option value='". $packID ."'>" . $p_name ."<span style='font-weight:bold;'> Rs ".$price."/month"."</span></option>";
                }
            ?>
            </select>
            </td>
            <td>
            Month (Enter value from 1 to 12):
            <input type="number" name="month" id="months" required min="1" max="12" onchange="updateDate()" required>
        </td>
    </tr>
    <tr>
        <td>
            <p>Booking Date: <span id="bookingDate"></span></p>
        </td>
        <td>
            <p>Expiry Date: <span id="expiryDate"></span></p>
        </td>
            </tr>

        <tr>
            <td colspan=2 style="text-align:center;">
            <input type="submit" value="Proceed to pay" class="form-btn">
            </td>
        </tr>
    </form> 
    </table>
    <p id="rec"></p>
    </div>
   
    <div class="wel_msg">
        <p><i class="fa fa-file-text" aria-hidden="true"></i> Receipt</p>
    </div>
    <div class="mem_details">
    <section id="print-section">
    <table id="record" style="width:100%;table-layout:fixed;">
    <?php
        if (isset($_GET['m_phone'])) {
        $m_phone = $_GET['m_phone'];

        // Prepare a statement to select the member data from the database
        $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
        $stmt1->bind_param("i", $m_phone);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row = $result1->fetch_assoc();
        $m_name = $row['m_name'];
        $m_age = $row['m_age'];
        $m_gender = $row['m_gender'];
        $m_address = $row['m_address'];
        $m_medical = $row['m_medical'];
        $m_email = $row['m_email'];
        $m_shift = $row['m_shift'];
        $stmt7 = $conn->prepare("SELECT * FROM bookings WHERE m_phone=?");
        $stmt7->bind_param("s", $m_phone);
        $stmt7->execute();
        $result7 = $stmt7->get_result();
        if ($result7->num_rows > 0) {
            $row7 = $result7->fetch_assoc();
            $booking_date = $row7['booking_date'];
            $expiry_date = $row7['expiry_date'];
            $month = $row7['month'];
            $packID = $row7['packID'];
            $m_price = $row7['m_price'];
            $price = $m_price/$month;
        } else {
            $booking_date = 'None';
            $expiry_date = 'None';
            $month = 'None';
            $packID = 0;
            $m_price = 0;
            $price = 0;
        }
            $stmt6 = $conn->prepare("SELECT p_name FROM packages WHERE packID = ?");
            $stmt6->bind_param("i", $packID);
            $stmt6->execute();
            $result6 = $stmt6->get_result();
            if ($result6->num_rows > 0) {
                $row6 = $result6->fetch_assoc();
                $p_name = $row6['p_name'];
            } else {
                $p_name = '<span style="color:red;">Package Not Booked Yet</span>';
            }
        }
        ?>
        <tr>
            <td colspan=2 style="text-align:center;">
                <h2 style="text-align:left;padding-top: 20px;">FITNESS CLUB: Receipt (Package Booking Details)</h2><br>
            </td>
        </tr>
        <tr>
            <td>
            Name: <b><b><?php echo $m_name; ?>, <?php echo $m_age; ?> / <?php echo $m_gender;?></b></b>
            </td>
            <td>
            Shift: <b><?php echo $m_shift; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Phone No.: <b><b><?php echo $m_phone; ?></b></b>
            </td>
            <td>
            Email: <b><b><?php echo $m_email; ?></b></b>
            </td>
        </tr>
        <tr>
            <td>
            Package: <b><b><?php echo $p_name; ?></b></b>
            </td>
            <td>
            Price per Month: Rs <b><?php echo $price; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            No. of Months: <b><b><?php echo $month; ?></b></b>
            </td>
            <td>
            Total Fee Paid: Rs <b><b><?php echo $m_price; ?></b></b>
            </td>
        </tr>
        <tr>
            <td>
            Booking Date: <b><b><?php echo $booking_date; ?></b></b>
            </td>
            <td>
            Expiry Date: <b><b><?php echo $expiry_date; ?></b></b>
            </td>
        </tr>
    </table><br>
    </section>
    <center><button style="padding:3px 10px;border-radius:4px;background-color:rgb(175, 174, 174);" onclick="printSection('print-section')"><i class="fa fa-print" aria-hidden="true"></i> Print</button></center>
    <script>
        function printSection(sectionId) {
            var printContents = document.getElementById(print).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    
    </div>

    <div class="wel_msg">
        <p><i class="fa fa-history" aria-hidden="true"></i> Booking History</p>
    </div>
    <div class="mem_details">
    <section id="print-section">
    <table id="record" style="width:100%;table-layout:fixed;">
    <?php
        $stmt = $conn->prepare("SELECT  packages.p_name, bookings.booking_date, bookings.expiry_date, bookings.m_price FROM bookings INNER JOIN packages ON bookings.packID = packages.packID WHERE bookings.m_phone = ? ;");
        $stmt->bind_param("s", $m_phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        echo "<table style='width:100%;table-layout:fixed;'>";
        echo "<tr><th style='width:50px;'>#</th><th>Package Name</th><th>Booking Date</th><th>Expiry Date</th><th>Price</th></tr>";
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$sno."</td><td>".$row['p_name']."</td><td>".$row['booking_date']."</td><td>".$row['expiry_date']."</td><td>".$row['m_price']."</td></tr>";
            $sno++;
        }
        echo "</table>";
        } else {
        echo "No bookings found for this member.";
        }
        $stmt->close();
    ?>
    <p id="ecard"></p>
    </div>

    <div class="wel_msg">
        <p><i class="fa fa-id-card-o" aria-hidden="true"></i> Entry Card</p>
    </div>
    <center><span style="color:crimson;font-size:18px;font-weight:light;margin-top:0px;padding-top:0px;text-align:center;">*Print or Download Entry Card for entry in gym*</span></center>
    <div class="mem_details">
    <section id="entrycard">
    <table id="record" style="width:100%;table-layout:fixed;">
    <?php
        if (isset($_GET['m_phone'])) {
        $m_phone = $_GET['m_phone'];

        // Prepare a statement to select the member data from the database
        $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
        $stmt1->bind_param("i", $m_phone);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row = $result1->fetch_assoc();
        $m_name = $row['m_name'];
        $m_age = $row['m_age'];
        $m_gender = $row['m_gender'];
        $m_address = $row['m_address'];
        $m_medical = $row['m_medical'];
        $m_email = $row['m_email'];
        $m_shift = $row['m_shift'];
        $stmt7 = $conn->prepare("SELECT * FROM bookings WHERE m_phone=?");
        $stmt7->bind_param("s", $m_phone);
        $stmt7->execute();
        $result7 = $stmt7->get_result();
        if ($result7->num_rows > 0) {
            $row7 = $result7->fetch_assoc();
            $booking_date = $row7['booking_date'];
            $expiry = $row7['expiry_date'];
            $expiry_date = date('Y-m-d', strtotime($expiry));
            $month = $row7['month'];
            $packID = $row7['packID'];
            $m_price = $row7['m_price'];
            $price = $m_price/$month;
        } else {
            $booking_date = 'None';
            $expiry_date = 'None';
            $month = 'None';
            $packID = 0;
            $m_price = 0;
            $price = 0;
        }
            $stmt6 = $conn->prepare("SELECT p_name FROM packages WHERE packID = ?");
            $stmt6->bind_param("i", $packID);
            $stmt6->execute();
            $result6 = $stmt6->get_result();
            if ($result6->num_rows > 0) {
                $row6 = $result6->fetch_assoc();
                $p_name = $row6['p_name'];
            } else {
                $p_name = '<span style="color:red;">Package Not Booked Yet</span>';
            }
        }
        ?>
        <tr>
            <td colspan=2 style="text-align:center;">
                <h2 style="text-align:left;padding-top: 20px;">FITNESS CLUB (Entry Card)</h2><br>
            </td>
        </tr>
        <tr>
            <td>
            Name: <br><b><?php echo $m_name; ?>, <?php echo $m_age; ?> / <?php echo $m_gender;?></b>
            </td>
            <td>
            Shift: <br><b><?php echo $m_shift; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Phone No.: <br><b><?php echo $m_phone; ?></b>
            </td>
            <td>
            Email: <br><b><?php echo $m_email; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Package: <br><b><?php echo $p_name; ?></b>
            </td>
            <td>
            Expiry Date: <br><b><?php echo $expiry_date; ?></b>
            </td>
        </tr>
    </table><br>
    </section>
    <center><button type="button"style="padding:3px 10px;border-radius:4px;background-color:rgb(175, 174, 174);" onclick="printSection('entrycard')"><i class="fa fa-print" aria-hidden="true"></i> Print</button></center>
    <script>
        function printSection(sectionId) {
            var printContents = document.getElementById(sectionId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    </div>
</div>
</body>
</html>