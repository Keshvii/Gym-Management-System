<?php
include("../partials/dbconnect.php");

  $stmt1 = $conn->prepare("SELECT * FROM contacts");
  $stmt1->execute();
  $result = $stmt1->get_result();
  $row = $result->fetch_assoc();
  $current_mobile = $row['mobile'];
  $current_phone = $row['phone'];
  $current_email = $row['email'];
  $current_insta = $row['insta'];
  $current_facebook = $row['facebook'];
  $current_twitter = $row['twitter'];
  $current_whatsapp = $row['whatsapp'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_mobile = $_POST['new_mobile'];
    $new_phone = $_POST['new_phone'];
    $new_email = $_POST['new_email'];
    $new_insta = $_POST['new_insta'];
    $new_facebook = $_POST['new_facebook'];
    $new_twitter = $_POST['new_twitter'];
    $new_whatsapp = $_POST['new_whatsapp'];
    
    $stmt2 = $conn->prepare("UPDATE contacts SET mobile=?, phone=?, email=?, insta=?, facebook=?, twitter=?, whatsapp=?");
    $stmt2->bind_param("sssssss", $new_mobile, $new_phone, $new_email, $new_insta, $new_facebook, $new_twitter, $new_whatsapp);

    if ($stmt2->execute() === TRUE) {
        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
            ---Home Page Details updated successfully---</div>";
    } else {
        echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
            border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Failed to update! Error: " . $conn->error."</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="website icon" type="png" href="../img/logo.png">
  <link rel="stylesheet" href="actions/add.css">
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
    <h3>Update Home Page Contact Details</h3>

    <label for="new_mobile">Mobile</label>
    <input type="text" name="new_mobile" value="<?php echo $current_mobile;?>" pattern="[0-9]{10}">
    
    <label for="new_phone">Telephone (Enter number in given format)</label>
    <input type="text" name="new_phone" value="<?php echo $current_phone;?>">
    
    <label for="new_email">Email</label>
    <input type="email" name="new_email" value="<?php echo $current_email;?>">

    <label for="new_insta">Instagram</label>
    <input type="text" name="new_insta" value="<?php echo $current_insta;?>">

    <label for="new_facebook">Facebook</label>
    <input type="text" name="new_facebook" value="<?php echo $current_facebook;?>">

    <label for="new_twitter">Twitter</label>
    <input type="text" name="new_twitter" value="<?php echo $current_twitter;?>">

    <label for="new_whatsapp">Whatsapp Number</label>
    <input type="text" name="new_whatsapp" value="<?php echo $current_whatsapp;?>" pattern="[0-9]{10}">

    <input type="submit" value="Update Details" class="form-btn"><br><br>
    <a href="ad_home.php"><i class="fa fa-home" aria-hidden="true"></i> Return Back</a>
  </form>
</div>
</body>
</html>