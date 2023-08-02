<?php
// Connect to database
include("../../partials/dbconnect.php");

session_start();

if(isset($_GET['m_phone'])) {
    $old_m_phone = $_GET['m_phone'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the new phone number was provided
    if (!empty($_POST["new_m_phone"])) {
        // Prepare the SQL statement to update the m_phone field in the bookings table
        $stmt_bookings = $conn->prepare("UPDATE bookings SET m_phone = ? WHERE m_phone = ?");

        // Bind parameters to the prepared statement for the bookings table
        $stmt_bookings->bind_param("ss", $new_m_phone, $old_m_phone);

        // Prepare the SQL statement to update the m_phone field in the members table
        $stmt_members = $conn->prepare("UPDATE members SET m_phone = ? WHERE m_phone = ?");

        // Bind parameters to the prepared statement for the members table
        $stmt_members->bind_param("ss", $new_m_phone, $old_m_phone);

        // Prepare the SQL statement to update the m_phone field in the logininfo table
        $stmt_logininfo = $conn->prepare("UPDATE logininfo SET m_phone = ? WHERE m_phone = ?");

        // Bind parameters to the prepared statement for the logininfo table
        $stmt_logininfo->bind_param("ss", $new_m_phone, $old_m_phone);

        // Set the new and old m_phone values
        $new_m_phone = $_POST["new_m_phone"];

        // Execute the prepared statements for each table
        $stmt_bookings->execute();
        $stmt_members->execute();
        $stmt_logininfo->execute();

        // Close the prepared statements
        $stmt_bookings->close();
        $stmt_members->close();
        $stmt_logininfo->close();

        // Redirect to the member details page
        header("Location: member_details.php?m_phone=$new_m_phone");
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
    <h3>Update Phone Number</h3>
    <label for="new_m_phone">New Phone Number</label>
    <input type="text" required name="new_m_phone" value="<?php echo $old_m_phone;?>">

    <input type="submit" value="Update Phone Number" class="form-btn"><br><br>
    <a href="member_details.php?m_phone=<?php echo $old_m_phone;?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
  </form>
</div>
</body>
</html>