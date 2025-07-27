<?php
//************************************************
// Contact form processing
//************************************************
session_start();
require_once("dbinfo.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if POST data exists
    if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"])) {
        header("Location: contact.php?error=missing_fields");
        exit();
    }

    // Extract form data
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Connect to database
    $hostname = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $db = "project";
    
    $mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
    if($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: ".$mysqli->connect_error;
        exit();
    }

    // Insert contact submission
    $stmt = $mysqli->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if ($stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        header("Location: contact.php?success=1");
        exit();
    } else {
        $stmt->close();
        $mysqli->close();
        header("Location: contact.php?error=submit_failed");
        exit();
    }
} else {
    header("Location: contact.php");
    exit();
}
?>
