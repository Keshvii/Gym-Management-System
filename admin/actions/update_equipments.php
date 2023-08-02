<?php
session_start();

include("../../partials/dbconnect.php");

if(isset($_GET['equipID'])) {
  $equipID = $_GET['equipID'];
  // Select image file name from database
  $stmt1 = $conn->prepare("SELECT * FROM equipments WHERE equipID = ?");
  $stmt1->bind_param("i", $equipID);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $row = $result->fetch_assoc();
  $current_e_name = $row['e_name'];
  $current_e_img = $row['e_img'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_e_name = $_POST['new_e_name'];
    //Updating New Image if selected
    //Check whether the image is selected or not
    $new_e_img = $_FILES["new_e_img"]["name"];
    if($_FILES["new_e_img"]["name"]=="")
    {
        $new_e_img = "No image";
    }
    // Upload image to server
    $target_dir = "../../img/equipments/";
    $target_file = $target_dir . basename($_FILES["new_e_img"]["name"]);
    move_uploaded_file($_FILES["new_e_img"]["tmp_name"], $target_file);
    
    $stmt2 = $conn->prepare("UPDATE equipments SET e_name=?, e_img=? WHERE equipID=?");
    $stmt2->bind_param("ssi", $new_e_name, $new_e_img, $equipID);

    if ($stmt2->execute() === TRUE) {
      echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
        ---Equipment updated successfully---</div>";
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
    <h3>Update Equipment</h3>
    <label for="new_e_name">Equipment Name</label>
    <input type="text" name="new_e_name" value="<?php echo $current_e_name;?>">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // hide current_image div
      echo "<style>#current_image{display:none;}</style>";
    }
    ?>
    <div id="current_image">
    <?php 
      if($current_e_img != "No image"){
      //Display the Image
      ?>
      <img src="<?php echo SITEURL; ?>img/equipments/<?php echo $current_e_img; ?>" width="150px">
      <?php
      }
      else
      {
      //Display Message
        echo "<div style='color:red;'>Currently no image is added.</div>";
      }
    ?>
    </div>

    <label for="new_e_img">Choose New Image File</label>
    <input type="file" name="new_e_img" >

    <input type="submit" value="Update Equipment" class="form-btn"><br><br>
    <a href="../equipments.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>