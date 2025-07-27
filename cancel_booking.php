<?php
session_start();

//************************************************
// Check if user is logged in
//************************************************
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

//************************************************
// Check if booking_id is provided
//************************************************
if (!isset($_POST["booking_id"])) {
    header("Location: manage.php?error=invalid_booking");
    exit();
}

$booking_id = trim($_POST["booking_id"]);
$user_id = $_SESSION["userid"];

//************************************************
// Connect to database
//************************************************
require_once("dbinfo.php");
$mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: ".$mysqli->connect_error;
    exit();
}

//************************************************
// Verify booking belongs to user and get event details
//************************************************
$stmt = $mysqli->prepare("SELECT b.booking_id, e.event_date, e.event_time 
                         FROM bookings b 
                         JOIN events e ON b.event_id = e.event_id 
                         WHERE b.booking_id = ? AND b.user_id = ? LIMIT 1");
$stmt->bind_param('is', $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Booking not found or doesn't belong to user
    header("Location: manage.php?error=invalid_booking");
    exit();
}

$booking = $result->fetch_assoc();

//************************************************
// Check if cancellation is allowed (2 hours before event)
//************************************************
$event_datetime = $booking['event_date'] . ' ' . $booking['event_time'];
$event_timestamp = strtotime($event_datetime);
$current_timestamp = time();
$two_hours_in_seconds = 2 * 60 * 60; // 2 hours in seconds

if (($event_timestamp - $current_timestamp) <= $two_hours_in_seconds) {
    // Too late to cancel
    header("Location: manage.php?error=too_late");
    exit();
}

//************************************************
// Delete the booking (cancel it)
//************************************************
$stmt = $mysqli->prepare("DELETE FROM bookings WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param('is', $booking_id, $user_id);

if ($stmt->execute()) {
    // Cancellation successful
    header("Location: manage.php?success=booking_cancelled");
} else {
    // Cancellation failed
    header("Location: manage.php?error=cancel_failed");
}

$stmt->close();
$mysqli->close();
?>
