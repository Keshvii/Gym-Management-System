<?php
include("../partials/dbconnect.php");

if(isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];
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
        <ul>
            <li><a href="<?php echo SITEURL;?>/customer/change_mphone.php?m_phone=<?php echo $m_phone ?>" class="btn3">Change Login Credentials</a></li>
            <li><a href="member_profile.php?m_phone=<?php echo $m_phone?>" id="loginbtn"><i class="fa fa-chevron-left" aria-hidden="true"></i></i> Back</a></li>
        </ul>    
    </div>
<?php
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_m_name = $_POST['new_m_name'];
        $new_m_age = $_POST['new_m_age'];
        $new_m_gender = $_POST['new_m_gender'];
        $new_m_address = $_POST['new_m_address'];
        $new_m_medical = $_POST['new_m_medical'];
        $new_m_email = $_POST['new_m_email'];
        $new_m_shift = $_POST['new_m_shift'];

        $stmt2 = $conn->prepare("UPDATE members SET m_name=?, m_age=?, m_gender=?, m_address=?, m_medical=?, m_email=?, m_shift=? WHERE m_phone=?");
        $stmt2->bind_param("sissssss", $new_m_name, $new_m_age, $new_m_gender, $new_m_address, $new_m_medical, $new_m_email, $new_m_shift, $m_phone);

        if(($stmt2->execute() === TRUE)) {
        echo "<div class='session' style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
            ---Details updated successfully---</div>";
        } else {
        echo "<div class='session' style='text-align:center;background-color: #f2dede;color: #a94442;
            border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Failed! Error: " . $stmt2 . "<br>". $conn->error."</div>";
        }
    }
}
?>
</div>
<div id="profile">
    <div class="wel_msg">
        <p><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Details</p>
    </div>
    <div class="booking">
        <table style="width:100%;table-layout:fixed;">
        <form method="post" enctype="multipart/form-data">
        <tr>
            <td>
                <label for="new_m_name">Name</label>
                <input type="text" name="new_m_name" value="<?php echo $current_m_name;?>">
            </td>
            <td>
                <label for="new_m_age">Age</label>
                <input type="text" name="new_m_age" value="<?php echo $current_m_age;?>" pattern="[0-9]{2}">
            </td>
        </tr>
        <tr>
            <td>
                <label for="new_m_gender">Select gender</label>
                <select name="new_m_gender">
                    <option value="male" <?php if ($current_m_gender == "male") { echo " selected"; } ?>>Male</option>
                    <option value="female" <?php if ($current_m_gender == "female") { echo " selected"; } ?>>Female</option>
                    <option value="other" <?php if ($current_m_gender == "other") { echo " selected"; } ?>>Other</option>
                </select>
            </td>
            <td>
                <label for="new_m_address">Address</label>
                <input type="text" name="new_m_address" value="<?php echo $current_m_address;?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="new_m_email">Email</label>
                <input type="text" name="new_m_email" value="<?php echo $current_m_email;?>">
            </td>
            <td>
                <label for="new_m_shift">Select Shift:</label>
                <select name="new_m_shift" style="text-align:center;">
                    <option value="6AM-8AM" <?php if ($current_m_shift == "6AM-8AM") { echo " selected"; } ?>>6AM-8AM :(Men+Women)</option>
                    <option value="8AM-10AM" <?php if ($current_m_shift == "8AM-10AM") { echo " selected"; } ?>>8AM-10AM :(Men+Women)</option>
                    <option value="10AM-12PM" <?php if ($current_m_shift == "10AM-12PM") { echo " selected"; } ?>>10AM-12PM :(Women)</option>
                    <option value="3PM-5PM" <?php if ($current_m_shift == "3PM-5PM") { echo " selected"; } ?>>3PM-5PM :(Women)</option>
                    <option value="5PM-7PM" <?php if ($current_m_shift == "5PM-7PM") { echo " selected"; } ?>>5PM-7PM :(Men+Women)</option>
                    <option value="7PM-9PM" <?php if ($current_m_shift == "7PM-9PM") { echo " selected"; } ?>>7PM-9PM :(Men)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
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
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">
            <input type="submit" value=" Update Details " class="form-btn">
            </td>
        </tr>
        </form>
        </table>
    </div>
</div>
</body>
</html>
