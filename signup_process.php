<?php
session_start();
require_once("dbinfo.php");

if (!isset($_POST["userid"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["name"]) || !isset($_POST["phone"]) || !isset($_POST["privacy"])) {
    header('Location: signup.php?error=missing');
    exit();
}

$userid = trim($_POST["userid"]);
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$confirmPassword = trim($_POST["confirm-password"]);
$phone = trim($_POST["phone"]);
$privacyAgreed = isset($_POST["privacy"]) && $_POST["privacy"] === 'on';

$errors = [];

// Validate Privacy Policy agreement
if (!$privacyAgreed) {
    $errors[] = "You must agree to the Privacy Policy and Terms of Service";
}

// Validate User ID length
if (strlen($userid) < 3) {
    $errors[] = "User ID must be at least 3 characters long";
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate password length
if (strlen($password) < 8 || strlen($password) > 16) {
    $errors[] = "Password must be 8-16 characters long";
}

// Validate password match
if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match";
}

// Validate phone number (8 digits starting with 8 or 9)
if (!preg_match('/^[89]\d{7}$/', $phone)) {
    $errors[] = "Phone number must be 8 digits starting with 8 or 9";
}

$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$db = "project";

$mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: ".$mysqli->connect_error;
    exit();
}


$stmt = $mysqli->prepare("SELECT user_id FROM user WHERE user_id = ? LIMIT 1");
$stmt->bind_param('s', $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $errors[] = "User ID already exists. Please choose a different one.";
}
$stmt->close();

$stmt = $mysqli->prepare("SELECT user_id FROM user WHERE email = ? LIMIT 1");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $errors[] = "Email address already exists. Please use a different email.";
}
$stmt->close();

if (!empty($errors)) {
    $errorString = implode(", ", $errors);
    $mysqli->close();
    header('Location: signup.php?error=' . urlencode($errorString));
    exit();
}

$stmt = $mysqli->prepare("INSERT INTO user (user_id, name, email, password, phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $userid, $name, $email, $password, $phone);

if ($stmt->execute()) {
    // Success - set session and redirect
    $_SESSION['userid'] = $userid;
    $stmt->close();
    $mysqli->close();
    header('Location: index.php?success=account_created');
    exit();
} else {
    // Database error
    $stmt->close();
    $mysqli->close();
    header('Location: signup.php?error=database_error');
    exit();
}
?>
