<?php
// Connect to database
include("../../partials/dbconnect.php");

session_start();

if(isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];

    // Delete record from database
    $stmt1 = $conn->prepare("DELETE FROM logininfo WHERE m_phone = ?");
    $stmt1->bind_param("s", $m_phone);
    $stmt2 = $conn->prepare("DELETE FROM bookings WHERE m_phone = ?");
    $stmt2->bind_param("s", $m_phone);
    $stmt3 = $conn->prepare("DELETE FROM members WHERE m_phone = ?");
    $stmt3->bind_param("s", $m_phone);
    if (($stmt1->execute() === TRUE)&&($stmt2->execute() === TRUE)&&($stmt3->execute() === TRUE)) {
        $_SESSION['success_delete'] = "---Member deleted successfully---";
        header('location:'.SITEURL.'admin/members.php');
    } else {
        $_SESSION['error_delete'] = "Failed! Error: " . $conn->error;
        header('location:'.SITEURL.'admin/members.php');
    }
}
?>