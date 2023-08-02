<?php
// Connect to database
include("../../partials/dbconnect.php");

session_start();

if(isset($_GET['packID'])) {
    $packID = $_GET['packID'];

    // Delete record from database
    $stmt = $conn->prepare("DELETE FROM packages WHERE packID = ?");
    $stmt->bind_param("i", $packID);
    if ($stmt->execute() === TRUE) {
        $_SESSION['success_delete'] = "---Package deleted successfully---";
        header('location:'.SITEURL.'admin/packages.php');
    } else {
        $_SESSION['error_delete'] = "Failed! Error: " . $conn->error;
        header('location:'.SITEURL.'admin/packages.php');
    }
}
?>