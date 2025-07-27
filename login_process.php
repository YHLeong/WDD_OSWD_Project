<?php
    session_start();
    require_once("dbinfo.php"); 

    if (!isset($_POST["userid"]) || !isset($_POST["passwd"])) {
        header('Location: login.php?error=missing');
        exit();
    }

    $userid = trim($_POST["userid"]);
    $passwd = trim($_POST["passwd"]);

    // Connect to database
    $hostname = "localhost"; //$hostname = "localhost:3306";
    $dbUser = "root";
    $dbPassword = "";
    $db = "project";
    $mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare('SELECT * FROM user WHERE user_id = ? LIMIT 1');
    $stmt->bind_param('s', $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['password'] === $passwd) {
            $_SESSION['userid'] = $row['user_id']; // Use correct column name
            $stmt->close();
            $mysqli->close();
            header('Location: index.php');
            exit();
        } else {
            $stmt->close();
            $mysqli->close();
            header('Location: login.php?error=11208');
            exit();
        }
    } else {
        $stmt->close();
        $mysqli->close();
        header('Location: login.php?error=11208');
        exit();
    }
?>