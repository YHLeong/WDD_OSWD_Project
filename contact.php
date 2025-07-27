<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="CSS/contact.css">
</head>
<body>
    <?php include 'Navbar.php';?>
    <div class="contact-container">
        <div class="contact-form-container">
            <div class="contact-form-title">Contact Us</div>
            <?php
            // Display success or error messages
            if (isset($_GET["success"]) && $_GET["success"] == "1") {
                echo '<p style="color:green;margin-bottom:10px;">Thank you! Your message has been sent successfully.</p>';
            }
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "missing_fields") {
                    echo '<p style="color:red;margin-bottom:10px;">Please fill in all required fields.</p>';
                } else if ($_GET["error"] == "submit_failed") {
                    echo '<p style="color:red;margin-bottom:10px;">Sorry, there was an error sending your message. Please try again.</p>';
                }
            }
            ?>
            <form class="contact-form" action="contact_process.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
                <button class="contact-form-btn" type="submit">Send Message</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        &copy; 2024 Event Booking. All rights reserved.
    </footer>
</body>
</html>