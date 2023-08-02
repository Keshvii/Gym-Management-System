<?php
// Connect to database
include("../../partials/dbconnect.php");

session_start();

if(isset($_GET['equipID'])) {
    $equipID = $_GET['equipID'];

    // Select image file name from database
    $stmt = $conn->prepare("SELECT e_img FROM equipments WHERE equipID = ?");
    $stmt->bind_param("i", $equipID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $e_img = $row['e_img'];

    // Delete record from database
    $stmt = $conn->prepare("DELETE FROM equipments WHERE equipID = ?");
    $stmt->bind_param("i", $equipID);
    if ($stmt->execute() === TRUE) {
        // Delete image file from server
        $file = "../../img/equipments/" . $e_img;
        if(file_exists($file)) {
            unlink($file);
        }
        $_SESSION['success_delete'] = "---Equipment deleted successfully---";
        header('location:'.SITEURL.'admin/equipments.php');
    } else {
        $_SESSION['error_delete'] = "Failed! Error: " . $conn->error;
        header('location:'.SITEURL.'admin/equipments.php');
    }
}
?>