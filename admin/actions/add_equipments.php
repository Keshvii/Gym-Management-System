<?php
// Connect to database
include("../../partials/dbconnect.php");

// Prepare statement
$sql = $conn->prepare("INSERT INTO equipments (e_name, e_img) VALUES (?,?)");
$sql->bind_param("ss", $e_name, $e_img);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $e_name = $_POST["e_name"];
  $e_img = $_FILES["e_img"]["name"];
  if($_FILES["e_img"]["name"]=="")
  {
      $e_img = "No image";
  }
  
  // Execute statement
  // Upload image to server
  $target_dir = "../../img/equipments/";
  $target_file = $target_dir . basename($_FILES["e_img"]["name"]);
  move_uploaded_file($_FILES["e_img"]["tmp_name"], $target_file);
  if ($sql->execute()=== TRUE) {
    echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
        border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
        ---Equipment added successfully---</div>";
  } else {
    echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
        border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Failed! Error: " . $sql . "<br>" . $conn->error."</div>";
  }  
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="website icon" type="png" href="../../img/logo.png">
  <link rel="stylesheet" href="add.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="form-container">
  <form method="post" enctype="multipart/form-data">
    <h3>Add Equipment</h3>
    <label for="e_name">Equipment Name</label>
    <input type="text" name="e_name" id="e_name" required>

    <label for="e_img">Equipment Image</label>
    <input type="file" name="e_img" id="e_img" >

    <input type="submit" value="Add Equipment" class="form-btn"><br><br>
    <a href="../equipments.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>
