<?php
session_start();
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '../partials/dbconnect.php';
    $m_phone = $_POST["m_phone"];
    $password = $_POST["password"];
    // Check if the phone number exists
    $stmt = $conn->prepare("SELECT * FROM logininfo WHERE m_phone = ? AND user_type = 'member'");
    $stmt->bind_param("s", $m_phone);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        if($password== $row['passwords']){
            $_SESSION['mem_login'] = "---LogIn Successful---";
            header("location:".SITEURL."customer/member_profile.php?m_phone=$m_phone");
        } else {
            $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
            border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Error! Invalid Credentials! </div>";
        }
    } else {
      $showError = "<div style='text-align:center;background-color: #f2dede;color: #a94442;
      border-bottom:1px solid #a94442;font-size:20px; padding:5px;'>Error! Invalid Credentials! </div>";
    }
}
if($showError!=false){
   echo $showError;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <link rel="website icon" type="png" href="../img/logo.png">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="form-container">
   <form method="post" enctype="multipart/form-data">
      <h3>Member Login</h3>
      <span style="color:crimson;margin-bottom:10%;">***Login to book package***</span><br><br>
      <label for="m_phone">Mobile Number</label>
      <input type="text" name="m_phone" required placeholder="*Enter your mobile no..." pattern="[0-9]{10}">
      <label for="password">Password</label>
      <input type="password" required placeholder="*Enter your password.." name="password" id="password">
      <button type="button" id="show-password-btn" onclick="togglePasswordVisibility()"><i class="fa fa-eye" aria-hidden="true"></i></button>
      <button type="reset" class="resetbtn">Reset</button><br><br>
      
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="cust_registration.php">register now</a></p><br>
      <a href="../customer/home.php"><i class="fa fa-home"></i> Return to Home</a>
      <a style="padding-left:30px" href="ad_login.php"><i class="fa fa-user"></i> Admin Login</a>
   </form>
</div>
<script>
    function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var showPasswordButton = document.getElementById("show-password-btn");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        showPasswordButton.innerHTML = "<i class='fa fa-eye-slash' aria-hidden='true'></i>";
    } else {
        passwordField.type = "password";
        showPasswordButton.innerHTML = "<i class='fa fa-eye' aria-hidden='true'></i>";
    }
}
</script>
</body>
</html>