<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="navbar">
        <img src="image/logo.png" alt="Logo" class="navbar-img">
        <div class="navbar-right">
            <a href="Home_page.html">Home</a>
            <a href="#login">Account</a>
            <div class="dropdown">
                <button class="dropbtn">Menu &#9662;</button>
                <div class="dropdown-content">
                    <a href="Manage_bookings.html">Manage Booking</a>
                    <a href="Events.html">Events</a>
                    <a href="Contact_us.html">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-container">
        <div class="contact-form-container">
            <div class="contact-form-title">Contact Us</div>
            <form class="contact-form">
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
