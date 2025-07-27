<?php
session_start();
require_once("dbinfo.php");

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$db = "project";
$mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_userid = trim($_POST['new_userid']);
    $new_name = trim($_POST['new_name']);
    $new_password = trim($_POST['new_password']);
    $user_id = $_SESSION['userid'];

    // Update user info
    $stmt = $mysqli->prepare('UPDATE user SET user_id = ?, name = ?, password = ? WHERE user_id = ?');
    $stmt->bind_param('ssss', $new_userid, $new_name, $new_password, $user_id);
    if ($stmt->execute()) {
        $_SESSION['userid'] = $new_userid;
        header('Location: index.php');
        exit();
    } else {
        $message = "Error updating account.";
    }
    $stmt->close();
}

// Fetch current user info
$stmt = $mysqli->prepare('SELECT user_id, name, password FROM user WHERE user_id = ? LIMIT 1');
$stmt->bind_param('s', $_SESSION['userid']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="CSS/Account.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="account-container">
        <div class="account-title">Account Information</div>
        <?php if (isset($message)) echo '<div class="account-message">' . $message . '</div>'; ?>
        <form class="account-form" method="post" action="Account.php">
            <label for="new_userid">UserID:</label>
            <input type="text" id="new_userid" name="new_userid" value="<?php echo htmlspecialchars($user['user_id']); ?>" required>
            <label for="new_name">Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="new_password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
            <button type="submit">Update Account</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>