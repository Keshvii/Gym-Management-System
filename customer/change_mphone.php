<?php
// Connect to database
include("../partials/dbconnect.php");
session_start();
if(isset($_GET['m_phone'])) {
    $old_m_phone = $_GET['m_phone'];
    $stmt1 = $conn->prepare("SELECT * FROM logininfo WHERE m_phone = ?");
    $stmt1->bind_param("s", $old_m_phone);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();
    $current_m_phone = $row['m_phone'];
    $current_passwords = $row['passwords'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["new_m_phone"])&&!empty($_POST["new_passwords"])) {
        $stmt_bookings = $conn->prepare("UPDATE bookings SET m_phone = ? WHERE m_phone = ?");
        $stmt_bookings->bind_param("ss", $new_m_phone, $old_m_phone);
        $stmt_members = $conn->prepare("UPDATE members SET m_phone = ? WHERE m_phone = ?");
        $stmt_members->bind_param("ss", $new_m_phone, $old_m_phone);

        // Prepare the SQL statement to update the m_phone field in the logininfo table
        $stmt_logininfo = $conn->prepare("UPDATE logininfo SET m_phone = ?, passwords=? WHERE m_phone = ?");

        // Bind parameters to the prepared statement for the logininfo table
        $stmt_logininfo->bind_param("sss", $new_m_phone, $new_passwords, $old_m_phone);
       
        // Set the new and old m_phone values
        $new_m_phone = $_POST["new_m_phone"];
        $new_passwords= $_POST["new_passwords"];

        // Execute the prepared statements for each table
        $stmt_bookings->execute();
        $stmt_members->execute();
        $stmt_logininfo->execute();

        // Close the prepared statements
        $stmt_bookings->close();
        $stmt_members->close();
        $stmt_logininfo->close();

        // Redirect to the member details page
        header("Location: member_profile.php?m_phone=$new_m_phone");
        exit();
    } else {
        // Handle the case where the new phone number was not provided
        echo "New phone number is required.";
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
  <link rel="website icon" type="png" href="../img/logo.png">
  <link rel="stylesheet" href="../login/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="form-container">
  <form method="post" enctype="multipart/form-data">
    <h3>Member Login Credentials</h3>
    <label for="new_m_phone">Mobile Number</label>
    <input type="text" name="new_m_phone" value="<?php echo $current_m_phone;?>">

    <label for="new_passwords">Password</label>
    <input type="text" name="new_passwords" value="<?php echo $current_passwords;?>">

    <input type="submit" value="Update Login Credentials" class="form-btn"><br><br>
    <a href="member_profile.php?m_phone=<?php echo $old_m_phone;?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>