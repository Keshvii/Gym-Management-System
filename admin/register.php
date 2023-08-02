<?php

$showAlert = false;
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../partials/dbconnect.php'; // your database connection code goes here

    $m_phone = $_POST["m_phone"];
    $m_name = $_POST["m_name"];
    $m_age = $_POST["m_age"];
    $m_gender = $_POST["m_gender"];
    $m_address = $_POST["m_address"];
    $m_shift = $_POST["m_shift"];
    $m_medical = $_POST["m_medical"];
    $m_email = $_POST["m_email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $user_type = "member";
    $month = $_POST["month"];
    $p_name = $_POST["p_name"] ;

    // check if phone no. already exists
    // prepare a statement to check if the phone number already exists
    $stmt = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
    $stmt->bind_param("s", $m_phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // phone number already exists, show error message
        $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
            border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>---Phone number already exists---</div>";
    } else {
        // check if passwords match
        if ($password == $cpassword) {
            // prepare a statement to insert customer details into members table
            $stmt = $conn->prepare("INSERT INTO members (m_phone, m_name, m_age, m_gender, m_address, m_medical, m_email, m_shift) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisssss", $m_phone, $m_name, $m_age, $m_gender, $m_address, $m_medical, $m_email, $m_shift);
            $result2 = $stmt->execute();

            if ($result2) {
                // prepare a statement to insert login details into logininfo table
                $stmt2 = $conn->prepare("INSERT INTO logininfo (m_phone, passwords, user_type) VALUES (?, ?, ?)");
                $stmt2->bind_param("sss", $m_phone, $password, $user_type);
                $result3 = $stmt2->execute();

                if ($result3) {
                    $showAlert = "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
                        border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
                        ---Registration successful---</div>";
                } else {
                    $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                        border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Error! Failed to create login account</div>";
                }
            } else {
                $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                    border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Error! Failed to create customer account</div>";
            }
        } else {
            $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Error! Passwords do not match</div>";
        }
    }

    // Prepare statement
    $stmt4 = $conn->prepare("INSERT INTO bookings (booking_date, expiry_date, m_phone, packID, month, m_price) VALUES (?,?,?,?,?,?)");
    $stmt4->bind_param("sssiid", $booking_date, $expiry_date, $m_phone, $packID, $month, $m_price);

    // Check if the user has a previous booking record or if the last record has expired
    $stmt = $conn->prepare("SELECT  expiry_date FROM bookings WHERE m_phone = ? ORDER BY booking_date DESC LIMIT 1");
    $stmt->bind_param("s", $m_phone);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result( $exp);
        $stmt->fetch();
        date_default_timezone_set('Asia/Kolkata');
        $today_timestamp = strtotime('today');
        $expiry_timestamp = strtotime($exp);
        if ($expiry_timestamp > $today_timestamp) {
            // Show message that booking cannot be made as the last record has not yet expired
            echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
            border:1px solid #a94442;font-size:20px; padding:5px;'>Booking cannot be made as the last record has not yet expired.</div>";
        }else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get form data
                $packID = $_POST["p_name"];
                $month = $_POST["month"];  
                date_default_timezone_set('Asia/Kolkata');
                $booking_date = date('Y-m-d H:i:s');
                $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $month . ' months', strtotime($booking_date)));
                    // Get member shift
                    $stmt5 = $conn->prepare("SELECT m_shift FROM members WHERE m_phone = ?");
                    $stmt5->bind_param("s", $m_phone);
                    $stmt5->execute();
                    $result5 = $stmt5->get_result();
                    $row5 = $result5->fetch_assoc();
                    $m_shift = $row5['m_shift'];
                    //Get packID and price
                    $stmt6 = $conn->prepare("SELECT price FROM packages WHERE packID = ?");
                    $stmt6->bind_param("i", $packID);
                    $stmt6->execute();
                    $result6 = $stmt6->get_result();
                    $row6 = $result6->fetch_assoc();
                    $price = $row6['price'];
    
                    $m_price = $month * $price;
                    
                    // Execute statement;
                    if ($stmt4->execute()=== TRUE) {
                        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
                            border:1px solid #3c763d;font-size:20px; padding:5px;margin-bottom:20px;margin-left:3%;margin-right:3%;'>
                            ---Package booked successfully---</div>";
                        }else {
                            echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                                border:1px solid #3c763d;font-size:20px; padding:5px;'>Failed! Error: " . $conn->error."</div>";
                        }    
            }
        }
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $packID = $_POST["p_name"];
            $month = $_POST["month"];  
            date_default_timezone_set('Asia/Kolkata');
            $booking_date = date('Y-m-d H:i:s');
            $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $month . ' months', strtotime($booking_date)));
                // Get member shift
                $stmt5 = $conn->prepare("SELECT m_shift FROM members WHERE m_phone = ?");
                $stmt5->bind_param("s", $m_phone);
                $stmt5->execute();
                $result5 = $stmt5->get_result();
                $row5 = $result5->fetch_assoc();
                $m_shift = $row5['m_shift'];
                //Get packID and price
                $stmt6 = $conn->prepare("SELECT price FROM packages WHERE packID = ?");
                $stmt6->bind_param("i", $packID);
                $stmt6->execute();
                $result6 = $stmt6->get_result();
                $row6 = $result6->fetch_assoc();
                $price = $row6['price'];

                $m_price = $month * $price;
                
                // Execute statement;
                if ($stmt4->execute()=== TRUE) {
                    echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
                        border:1px solid #3c763d;font-size:20px;'>
                        ---Package booked successfully---</div>";
                    }else {
                        echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
                            border:1px solid #3c763d;font-size:20px; '>Failed! Error: " . $conn->error."</div>";
                    } 
                }
        }
    }

if (isset($showAlert)) {
    echo $showAlert;
}
if (isset($showError)) {
    echo $showError;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registration form</title>
   <link rel="website icon" type="png" href="../img/logo.png">
   <link rel="stylesheet" href="../login/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.form-container form .form-btn{
   background-color: #132a13;
   color: white;
}

.form-container form .form-btn:hover{
   background-color: #011201;
}
i{
   color: #132a13;
}
i:hover{
   color: #011201;
}
a{
   color: #132a13;
}
a:hover{
   color: #011201;
}

i{
   color: #297a29;
}
i:hover{
   color: #011201;
}
a{
   color: #297a29;
}
a:hover{
   color: #011201;
}
</style>
</head>
<body>


<div class="form-container">
<form method="post" enctype="multipart/form-data">
    <!--PAGE1-->
    <div>
    <h3>Register Member</h3>
        <label for="m_email">Email</label>
        <input type="email" name="m_email" placeholder="Enter your email...">
        <label for="m_phone">Mobile No.</label>
        <input type="text" name="m_phone" required placeholder="*Enter your mobile no...">
        <label for="password">Password</label>
        <input type="password" name="password" required placeholder="*Enter your password...">
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" required placeholder="*Confirm your password...">
    <br><br>
    <h3>Member Details</h3>
        <label for="m_name">Name</label>
        <input type="text" name="m_name" required placeholder="*Enter your name...">
        <label for="m_age">Age</label>
        <input type="text" name="m_age" required placeholder="*Enter your age...">
        <label for="m_gender">Select gender</label>
        <select name="m_gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <label for="m_address">Address</label>
        <input type="text" name="m_address" required placeholder="*Enter your address...">
        <label for="m_medical">Pre-medical condition, if any:</label>
        <select name="m_medical" required>
            <option value="none">None</option>
            <option value="diabetes">Diabetes</option>
            <option value="recent_childbirth">Recent Childbirth</option>
            <option value="heart_disease">Heart Disease</option>
            <option value="asthma">Asthma</option>
            <option value="low_blood_pressure">Low Blood Pressure</option>
            <option value="high_blood_pressure">High Blood Pressure</option>
            <option value="thyroid">Thyroid</option>
            <option value="other">Other</option>
        </select>
        <label for="m_shift">Select Shift:</label>
        <select name="m_shift" style="text-align:center;" required>
            <option value="6AM-8AM">6AM-8AM :(Men+Women)</option>
            <option value="8AM-10AM">8AM-10AM :(Men+Women)</option>
            <option value="10AM-12PM">10AM-12PM :(Women)</option>
            <option value="3PM-5PM">3PM-5PM :(Women)</option>
            <option value="5PM-7PM">5PM-7PM :(Men+Women)</option>
            <option value="7PM-9PM">7PM-9PM :(Men)</option>
        </select>
    <br><br>
    <h3>Package Details</h3>
        <label for="month">Month (Enter value from 1 to 12)</label>
        <input type="number" name="month" id="months" required min="1" max="12" required>
        <label for="p_name">Select Package</label>
        <select name="p_name" style="text-align:center;" >
        <?php
        include("../partials/dbconnect.php");
        // Prepare a SQL statement to select data from the "packages" table
        $sql = "SELECT packID, p_name, price FROM packages";
        $stmt3 = $conn->prepare($sql);

        // Execute the prepared statement
        $stmt3->execute();

        // Bind the result variables
        $stmt3->bind_result($packID, $p_name, $price);

        // Loop through the results and display each option
        while ($stmt3->fetch()) {
            ?>
            <option value='<?php echo $packID;?>'><?php echo $p_name;?> Rs <?php echo $price;?>/month</option>
            <?php
        }
        $stmt3->close();
        ?>
        </select><br><br>
        <!-- Navigation buttons -->
        <input type="submit" name="submit" value="Register Now" class="form-btn"><br>
        <a href="members.php"><i class="fa fa-address-book" aria-hidden="true"></i></i> Return</a>
    </div>
</form>
</div>
</body>
</html>

