<?php
session_start();
//connect the database
include '../partials/dbconnect.php';

$stmt4 = $conn->prepare("INSERT INTO bookings (booking_date, expiry_date, m_phone, packID, month, m_price) VALUES (?,?,?,?,?,?)");
$stmt4->bind_param("sssiid", $booking_date, $expiry_date, $m_phone, $packID, $month, $m_price);

if (isset($_GET['m_phone']) && isset($_GET['packID']) && isset($_GET['month'])) {
    $m_phone = $_GET['m_phone'];
    $packID = $_GET['packID'];
    $month = $_GET['month'];
}

date_default_timezone_set('Asia/Kolkata');
$booking_date = date('Y-m-d H:i:s');
$expiry_date = date('Y-m-d H:i:s', strtotime('+' . $month . ' months', strtotime($booking_date)));
                    

//get the payment details from payment page
 
if(isset($_POST['payment_id']) && isset($_POST['amount']) && isset($_POST['name']))
{
    $paymentId = $_POST['payment_id'];
    $price = $_POST['amount'];
    $m_price = $price/100;
    $m_name = $_POST['name'];
 
    if ($stmt4->execute()=== TRUE) {
        $_SESSION['book'] = "---Package booked successfully---";
    }
}
?>