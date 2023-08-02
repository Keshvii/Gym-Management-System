<?php

session_start();

define('SITEURL', 'http://localhost/Gym_Management_System/');
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

?>

<!--Navigation Bar-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMS</title>
    <link rel="website icon" type="png" href="../img/logo.png">
    <link rel="stylesheet" href="..\customer\home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="containter">
        <div class="navbar">
            <div class="logo">
                <img src="../img/logoslogan.png" alt="logo">
            </div>
            <ul>
                <li><a href="#top" ><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li><a href="#equipments">Equipments</a></li>
                <li><a href="#packages">Packages</a></li>
                <li><a href="#trainers">Trainers</a></li>
                <li><a href="../login/cust_registration.php">Register</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="../login/mem_login.php" id="loginbtn"><i class="fa fa-sign-in" aria-hidden="true"></i> Member Login</a></li>
            </ul>
            
    </div>