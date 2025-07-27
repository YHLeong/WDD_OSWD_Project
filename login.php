<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>  

    <div class="login-container">
        <div class="login-form-section">
            <div class="login-title">Login</div>
            <form class="login-form" action="login_process.php" method="post">
                <div class="form-group">
                    <label for="userid">UserID</label>
                    <input type="text" id="userid" name="userid" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="passwd" class="form-input" required>
                </div>

                <button class="login-btn" type="submit">Login</button>

                <?php
                if (isset($_GET["error"]) && $_GET["error"] == "11208") {
                    echo '<p style="color:red;margin-top:10px;">Invalid UserID or Password.</p>';
                }
                ?>
            </form>
        </div>

        <div class="login-image-section">
            <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80"
                alt="Login" class="login-image-placeholder"
                style="width:90%;height:90%;object-fit:cover;border-radius:12px;border:2px solid #b3e0fc;">
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
