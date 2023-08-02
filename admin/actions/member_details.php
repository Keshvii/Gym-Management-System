<?php
session_start();
include("../../partials/dbconnect.php");

if (isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];

    // Prepare a statement to select the member data from the database
    $stmt1 = $conn->prepare("SELECT * FROM members WHERE m_phone = ?");
    $stmt1->bind_param("i", $m_phone);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row = $result1->fetch_assoc();
    $m_name = $row['m_name'];
    $m_age = $row['m_age'];
    $m_gender = $row['m_gender'];
    $m_address = $row['m_address'];
    $m_medical = $row['m_medical'];
    $m_email = $row['m_email'];
    $m_shift = $row['m_shift'];
    $stmt7 = $conn->prepare("SELECT * FROM bookings WHERE m_phone=?");
    $stmt7->bind_param("s", $m_phone);
    $stmt7->execute();
    $result7 = $stmt7->get_result();
    if ($result7->num_rows > 0) {
        $row7 = $result7->fetch_assoc();
        $booking_date = $row7['booking_date'];
        $expiry_date = $row7['expiry_date'];
        $month = $row7['month'];
        $packID = $row7['packID'];
        $m_price = $row7['m_price'];
        $price = $m_price/$month;
    } else {
        $booking_date = 'None';
        $expiry_date = 'None';
        $month = 'None';
        $packID = 0;
        $m_price = 0;
        $price = 0;
    }
        $stmt6 = $conn->prepare("SELECT p_name FROM packages WHERE packID = ?");
        $stmt6->bind_param("i", $packID);
        $stmt6->execute();
        $result6 = $stmt6->get_result();
        if ($result6->num_rows > 0) {
            $row6 = $result6->fetch_assoc();
            $p_name = $row6['p_name'];
        } else {
            $p_name = '<span style="color:red;">Package Not Booked Yet</span>';
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
    <link rel="stylesheet" href="../../customer/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
table tr td{
    text-align:left;
}
.navbar {
    background-color: #132a13;
}
#loginbtn:hover {
    background-color: #fcd162;
    color: #03071e;
}
.mem_details{
    border: 3px solid #132a13;
}

</style>
</head>
<body>
<div class="container">
    <!--Navigation Bar-->
    <div class="navbar">
        <div class="logo">
            <img src="../../img/adminlogoslogan.png" alt="logo">
        </div>
        <ul>
            <li><a href="<?php echo SITEURL;?>/admin/actions/change_mphone.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn3">Change Phone</a></li>
            <li><a href="#bh">Booking History</a></li>
            <li><a href="<?php echo SITEURL;?>/admin/actions/delete_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn3">Delete</a></li>
            <li><a href="<?php echo SITEURL; ?>/admin/actions/update_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn2">Update</a></li>
            <li><a href="tel:+91<?php echo $m_phone?>"><i class="fa fa-phone" aria-hidden="true"></i> Call</a></li>
            <li><a href="mailto:<?php echo $m_email?>"><i class="fa fa-envelope" aria-hidden="true"></i> Email</a></li>
            <li><a href="../members.php" id="loginbtn"><i class="fa fa-chevron-left" aria-hidden="true"></i></i> Back</a></li>
        </ul>    
    </div>
</div>
<div id="profile">
    <div class="wel_msg">
        <p><span style="color:#132a13;"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $m_name; ?></span>  Details</p>
    </div>
    <div class="mem_details">
    <table  style="width:100%;table-layout:fixed;">
        <tr>
            <td>
            Age: <b><?php echo $m_age; ?></b>
            </td>
            <td>
            Gender: <b><?php echo $m_gender; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Address: <b><?php echo $m_address; ?></b>
            </td>
            <td>
            Medical: <b><?php echo $m_medical; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Phone: <b><?php echo $m_phone; ?></b>
            </td>
            <td>
            Email: <b><?php echo $m_email; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Shift: <b><?php echo $m_shift; ?></b>
            </td>
            <td>
            Trainer: <b>
            <?php
                $stmt2 = $conn->prepare("SELECT t_name FROM trainers WHERE t_shift = ?");
                $stmt2->bind_param("i", $m_shift);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $t_name = $row['t_name'];
                        echo $t_name." , ";
                    }
                }
            ?></b>
            </td>
        </tr>
        <tr>
            <td>
            Package: <b><b><?php echo $p_name; ?></b></b>
            </td>
            <td>
            Price per Month: Rs <b><?php echo $price; ?></b>
            </td>
        </tr>
        <tr>
            <td>
            No. of Months: <b><b><?php echo $month; ?></b></b>
            </td>
            <td>
            Total Fee Paid: Rs <b><b><?php echo $m_price; ?></b></b>
            </td>
        </tr>
        <tr>
            <td>
            Booking Date: <b><b><?php echo $booking_date; ?></b></b>
            </td>
            <td>
            Expiry Date: <b><b><?php echo $expiry_date; ?></b></b>
            </td>
        </tr>
    </table>
    </div>
    <p id="bh"></p>
    <div class="wel_msg">
        <p><span style="color:#132a13;"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $m_name; ?></span>  Booking History</p>
    </div>
    <div class="mem_details">
    <table style="width:100%;table-layout:fixed;">
        <?php
        $stmt = $conn->prepare("SELECT packages.p_name, bookings.booking_date, bookings.expiry_date, bookings.m_price FROM bookings INNER JOIN packages ON bookings.packID = packages.packID WHERE bookings.m_phone = ?;");
        $stmt->bind_param("s", $m_phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        echo "<table style='width:100%;table-layout:fixed;'>";
        echo "<tr><th style='width:50px;'>#</th><th>Package Name</th><th>Booking Date</th><th>Expiry Date</th><th>Price</th></tr>";
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$sno."</td><td>".$row['p_name']."</td><td>".$row['booking_date']."</td><td>".$row['expiry_date']."</td><td>".$row['m_price']."</td></tr>";
            $sno++;
        }
        echo "</table>";
        } else {
        echo "No bookings found for this member.";
        }
        $stmt->close();
        ?>
    </div>
</div>
</body>
</html>
