<?php
// Connect to database
include("../../partials/dbconnect.php");

session_start();

if(isset($_GET['trainerID'])) {
    $trainerID = $_GET['trainerID'];

    // Select image file name from database
    $stmt = $conn->prepare("SELECT t_img FROM trainers WHERE trainerID = ?");
    $stmt->bind_param("i", $trainerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $t_img = $row['t_img'];

    // Delete record from database
    $stmt = $conn->prepare("DELETE FROM trainers WHERE trainerID = ?");
    $stmt->bind_param("i", $trainerID);
    if ($stmt->execute() === TRUE) {
        // Delete image file from server
        $file = "../../img/trainers/" . $t_img;
        if(file_exists($file)) {
            unlink($file);
        }
        $_SESSION['success_delete'] = "---Trainer deleted successfully---";
        header('location:'.SITEURL.'admin/trainers.php');
    } else {
        $_SESSION['error_delete'] = "Failed! Error: " . $conn->error;
        header('location:'.SITEURL.'admin/trainers.php');
    }
}
?>