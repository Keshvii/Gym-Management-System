<?php
// Connect to database
include("../../partials/dbconnect.php");

// Prepare statement
$sql = $conn->prepare("INSERT INTO packages (p_name, price, p_desc) VALUES (?,?,?)");
$sql->bind_param("sds", $p_name, $price, $p_desc);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $p_name = $_POST["p_name"];
    $price = $_POST["price"];  
    $p_desc = $_POST["p_desc"];
   
    // Execute statement;
    if ($sql->execute()=== TRUE) {
        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border-bottom:1px solid #3c763d;font-size:20px; padding:5px;'>
            ---Package added successfully---</div>";
    }  else {
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
        <h3>Add Package</h3>
        <label for="p_name">Package Name</label>
        <input type="text" name="p_name" id="p_name" required>

        <label for="price">Package Price (in Rs)</label>
        <input type="text" name="price" id="price" required>

        <label for="p_desc">Package Description</label>
        <input type="text" name="p_desc" id="p_desc" required>

        <input type="submit" value="Add Package" class="form-btn"><br><br>
      <a href="../packages.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
    </form>
</div>
</body>
</html>