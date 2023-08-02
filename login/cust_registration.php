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
    $m_medical = $_POST["m_medical"];
    $m_shift = $_POST["m_shift"];
    $m_email = $_POST["m_email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $user_type = "member";
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
            $result1 = $stmt->execute();

            if ($result1) {
                // prepare a statement to insert login details into logininfo table
                $stmt = $conn->prepare("INSERT INTO logininfo (m_phone, passwords, user_type) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $m_phone, $password, $user_type);
                $result2 = $stmt->execute();

                if ($result2) {
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
}
if (isset($showAlert)) {
    echo $showAlert;
}
if (isset($showError)) {
    echo $showError;
}

?>

<!-- HTML registration form goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registration form</title>
   <link rel="website icon" type="png" href="../img/logo.png">
   <link rel="stylesheet" href="login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="form-container">
<form method="post" enctype="multipart/form-data">
    <h3>register now</h3>
    <div>
        <input type="email" name="m_email" required placeholder="*Enter your email...">
        <input type="text" name="m_phone" required placeholder="*Enter your mobile no..." pattern="[0-9]{10}">
        <input type="password" name="password" required placeholder="*Enter your password...">
        <input type="password" name="cpassword" required placeholder="*Confirm your password...">
        <input type="text" name="m_name" required placeholder="*Enter your name...">
        <input type="text" name="m_age" required placeholder="*Enter your age..." pattern="[0-9]{2}">
        <label for="m_gender">Select gender</label>
        <select name="m_gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
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
        <!-- Navigation buttons -->
        <button type="reset" class="resetbtn">Reset</button>
        <input type="submit" name="submit" value="Register Now" class="form-btn">
        <p>already have an account? <a href="mem_login.php">login now</a></p><br>
        <a id="rtnhome" href="../customer/home.php"><i class="fa fa-home"></i> Return to Home</a>
    </div>
</form>
</div>
</body>
</html>