<?php
include("../../partials/dbconnect.php");

if(isset($_GET['packID'])) {
  $packID = $_GET['packID'];
  // Select image file name from database
  $stmt1 = $conn->prepare("SELECT * FROM packages WHERE packID = ?");
  $stmt1->bind_param("i", $packID);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $row = $result->fetch_assoc();
  $current_p_name = $row['p_name'];
  $current_price = $row['price'];
  $current_p_desc = $row['p_desc'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_p_name = $_POST['new_p_name'];
    $new_price = $_POST['new_price'];
    $new_p_desc = $_POST['new_p_desc'];
    
    $stmt2 = $conn->prepare("UPDATE packages SET p_name=?, price=?, p_desc=? WHERE packID=?");
    $stmt2->bind_param("sssi", $new_p_name, $new_price, $new_p_desc, $packID);

    if ($stmt2->execute() === TRUE) {
      echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
        ---Package updated successfully---</div>";
    } else {
      echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Failed! Error: " . "<br>" . $conn->error."</div>";
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
    <h3>Update Package</h3>
    <label for="new_p_name">Package Name</label>
    <input type="text" name="new_p_name" value="<?php echo $current_p_name;?>">

    <label for="new_price">Package Price (in Rs)</label>
    <input type="text" name="new_price" value="<?php echo $current_price;?>">

    <label for="new_p_desc">Package Description</label>
    <input type="text" name="new_p_desc" value="<?php echo $current_p_desc;?>">

    <input type="submit" value="Update Package" class="form-btn"><br><br>
    <a href="../packages.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>