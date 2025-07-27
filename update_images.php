<?php
//************************************************
// Update image paths in events table
//************************************************
require_once("dbinfo.php");
$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$db = "project";

$mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: ".$mysqli->connect_error;
    exit();
}

// Update each event with correct image path
$updates = [
    1 => "image/Digital Marketing Bootcamp.avif",
    2 => "image/Python Programming.avif", 
    3 => "image/Leadership & Communication Skills.avif",
    4 => "image/Creative Design Workshop.avif",
    5 => "image/Project Management Essentials.avif",
    6 => "image/Public Speaking Mastery.avif"
];

foreach($updates as $event_id => $image_path) {
    $stmt = $mysqli->prepare("UPDATE events SET image_path = ? WHERE event_id = ?");
    $stmt->bind_param('si', $image_path, $event_id);
    if($stmt->execute()) {
        echo "Updated event $event_id with image: $image_path<br>";
    } else {
        echo "Failed to update event $event_id<br>";
    }
    $stmt->close();
}

$mysqli->close();
echo "<br>All image paths updated! You can now go back to events.php to see the images.";
?>
