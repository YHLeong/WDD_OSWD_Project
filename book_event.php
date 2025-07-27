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
// Check if event_id is provided
//************************************************
if (!isset($_POST["event_id"])) {
    header("Location: events.php?error=missing_event");
    exit();
}

$event_id = trim($_POST["event_id"]);
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
// Check if user already booked this event
//************************************************
$stmt = $mysqli->prepare("SELECT booking_id FROM bookings WHERE user_id = ? AND event_id = ? LIMIT 1");
$stmt->bind_param('si', $user_id, $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User already booked this event
    header("Location: events.php?error=already_booked");
    exit();
}

//************************************************
// Insert new booking
//************************************************
$stmt = $mysqli->prepare("INSERT INTO bookings (user_id, event_id) VALUES (?, ?)");
$stmt->bind_param('si', $user_id, $event_id);

if ($stmt->execute()) {
    // Booking successful
    header("Location: events.php?success=booking_confirmed");
} else {
    // Booking failed
    header("Location: events.php?error=booking_failed");
}

$stmt->close();
$mysqli->close();
?>
