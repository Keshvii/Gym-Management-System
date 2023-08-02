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