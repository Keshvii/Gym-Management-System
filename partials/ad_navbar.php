<?php
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
    <link rel="stylesheet" href="..\admin\admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <div class="navbar">
        <div class="logo">
            <img src="../img/adminlogoslogan.png" alt="logo">
        </div>
        <ul>
            <li><a href="../admin/ad_home.php" ><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
            <li><a href="../admin/reports.php" ><i class="fa fa-file-text-o" aria-hidden="true"></i> Reports</a></li>
            <li><a href="../admin/equipments.php">Equipments</a></li>
            <li><a href="../admin/packages.php">Packages</a></li>
            <li><a href="../admin/trainers.php">Trainers</a></li>
            <li><a href="../admin/register.php">Register</a></li>
            <li><a href="../admin/members.php">Members</a></li>
            <li><a href="../admin/contacts.php">Contact Us</a></li>
            <li><a href="../admin/ad_logout.php" id="loginbtn"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
        </ul>    
    </div>