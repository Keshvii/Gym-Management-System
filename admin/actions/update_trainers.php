<?php
include("../../partials/dbconnect.php");

if(isset($_GET['trainerID'])) {
  $trainerID = $_GET['trainerID'];
  // Select image file name from database
  $stmt1 = $conn->prepare("SELECT * FROM trainers WHERE trainerID = ?");
  $stmt1->bind_param("i", $trainerID);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $row = $result->fetch_assoc();
  $current_t_name = $row['t_name'];
  $current_t_img = $row['t_img'];
  $current_t_desc = $row['t_desc'];
  $current_t_shift = $row['t_shift'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_t_name = $_POST['new_t_name'];
    $new_t_desc = $_POST['new_t_desc'];
    $new_t_shift = $_POST['new_t_shift'];
    //Updating New Image if selected
    //Check whether the image is selected or not
    $new_t_img = $_FILES["new_t_img"]["name"];
    if($_FILES["new_t_img"]["name"]=="")
    {
        $new_t_img = "No image";
    }
    // Upload image to server
    $target_dir = "../../img/trainers/";
    $target_file = $target_dir . basename($_FILES["new_t_img"]["name"]);
    move_uploaded_file($_FILES["new_t_img"]["tmp_name"], $target_file);
    
    $stmt2 = $conn->prepare("UPDATE trainers SET t_name=?, t_img=?, t_desc=?, t_shift=? WHERE trainerID=?");
    $stmt2->bind_param("ssssi", $new_t_name, $new_t_img, $new_t_desc, $new_t_shift, $trainerID);

    if ($stmt2->execute() === TRUE) {
      echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
        ---Trainer updated successfully---</div>";
    } else {
      echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Failed! Error: " . $sql . "<br>" . $conn->error."</div>";
    }
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
<style>
.form-container form .form-btn{
  background-color: #0A9396;
}
.form-container form .form-btn:hover{
  background-color: #005F73;
}
i{
  color:#0A9396;
}
i:hover{
  color: #005F73;
}
a{
  color:#0A9396;
}
a:hover{
  color: #005F73;
}
</style>
</head>

<body>
<div class="form-container">
  <form method="post" enctype="multipart/form-data">
    <h3>Update Trainer</h3>
    <label for="new_t_name">Trainer Name</label>
    <input type="text" name="new_t_name" value="<?php echo $current_t_name;?>">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // hide current_image div
      echo "<style>#current_image{display:none;}</style>";
    }
    ?>
    <div id="current_image">
    <?php 
      if($current_t_img != "No image"){
      //Display the Image
      ?>
      <img src="<?php echo SITEURL; ?>img/trainers/<?php echo $current_t_img; ?>" width="150px">
      <?php
      }
      else
      {
      //Display Message
        echo "<div style='color:red;'>Currently no image is added.</div>";
      }
    ?>
    </div>

    <label for="new_t_img">Choose New Image File</label>
    <input type="file" name="new_t_img" >

    <label for="new_t_desc">Trainer Description</label>
    <input type="text" name="new_t_desc" value="<?php echo $current_t_desc;?>">

    <label for="new_t_shift">Select Trainer Shift</label>
    <select name="new_t_shift" style="text-align:center;">
        <option value="6AM-8AM" <?php if ($current_t_shift == "6AM-8AM") { echo " selected"; } ?>>6AM-8AM</option>
        <option value="8AM-10AM" <?php if ($current_t_shift == "8AM-10AM") { echo " selected"; } ?>>8AM-10AM</option>
        <option value="10AM-12PM" <?php if ($current_t_shift == "10AM-12PM") { echo " selected"; } ?>>10AM-12PM</option>
        <option value="3PM-5PM" <?php if ($current_t_shift == "3PM-5PM") { echo " selected"; } ?>>3PM-5PM</option>
        <option value="5PM-7PM" <?php if ($current_t_shift == "5PM-7PM") { echo " selected"; } ?>>5PM-7PM</option>
        <option value="7PM-9PM" <?php if ($current_t_shift == "7PM-9PM") { echo " selected"; } ?>>7PM-9PM</option>
    </select>

    <input type="submit" value="Update Trainer" class="form-btn"><br><br>
    <a href="../trainers.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>