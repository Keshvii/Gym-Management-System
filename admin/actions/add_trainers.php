<?php
// Connect to database
include("../../partials/dbconnect.php");

// Prepare statement
$sql = $conn->prepare("INSERT INTO trainers (t_name, t_img, t_desc, t_shift) VALUES (?,?,?,?)");
$sql->bind_param("ssss", $t_name, $t_img, $t_desc, $t_shift);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get form data
   $t_name = $_POST["t_name"];
   $t_img = $_FILES["t_img"]["name"];
   if($_FILES["t_img"]["name"]=="")
   {
       $t_img = "No image";
   }
   $t_desc = $_POST["t_desc"];
   $t_shift = $_POST["t_shift"];
   
   // Execute statement
   // Upload image to server
   $target_dir = "../../img/trainers/";
   $target_file = $target_dir . basename($_FILES["t_img"]["name"]);
   move_uploaded_file($_FILES["t_img"]["tmp_name"], $target_file);
   if ($sql->execute()=== TRUE) {
      echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
      border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
      ---Trainer added successfully---</div>";
   } else {
      echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
      border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Error: " . $sql . "<br>" . $conn->error."</div>";
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
      <h3>Add Trainer</h3>
      <label for="t_name">Trainer Name</label>
      <input type="text" name="t_name" id="t_name" required>

      <label for="t_img">Trainer Image</label>
      <input type="file" name="t_img" id="t_img">

      <label for="t_desc">Trainer Description</label>
      <input type="text" name="t_desc" id="t_desc" required>

      <label for="t_shift">Select Trainer Shift</label>
      <select name="t_shift" style="text-align:center;" required>
            <option value="6AM-8AM">6AM-8AM</option>
            <option value="8AM-10AM">8AM-10AM</option>
            <option value="10AM-12PM">10AM-12PM</option>
            <option value="3PM-5PM">3PM-5PM</option>
            <option value="5PM-7PM">5PM-7PM</option>
            <option value="7PM-9PM">7PM-9PM</option>
        </select>

      <input type="submit" value="Add Trainer" class="form-btn"><br><br>
      <a href="../trainers.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
   </form>
</div>
</body>
</html>
