<?php
include("../../partials/dbconnect.php");
  $user="admin";
  $stmt1 = $conn->prepare("SELECT * FROM logininfo WHERE user_type = ?");
  $stmt1->bind_param("s", $user);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $row = $result->fetch_assoc();
  $current_m_phone = $row['m_phone'];
  $current_passwords = $row['passwords'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_m_phone = $_POST['new_m_phone'];
    $new_passwords = $_POST['new_passwords'];
    
    $stmt2 = $conn->prepare("UPDATE logininfo SET m_phone=?, passwords=? WHERE user_type =?");
    $stmt2->bind_param("sss", $new_m_phone, $new_passwords, $user);

    if ($stmt2->execute() === TRUE) {
      echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
        ---Updated successfully---</div>";
    } else {
      echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
          border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>Failed! Error: " . "<br>" . $conn->error."</div>";
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
    <h3>Admin Login Credentials</h3>
    <label for="new_m_phone">Admin Mobile Number</label>
    <input type="text" name="new_m_phone" value="<?php echo $current_m_phone;?>">

    <label for="new_passwords">Password</label>
    <input type="text" name="new_passwords" value="<?php echo $current_passwords;?>">

    <input type="submit" value="Update Login Credentials" class="form-btn"><br><br>
    <a href="../ad_home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>