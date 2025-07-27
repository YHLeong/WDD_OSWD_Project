<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul id="menu" class="navbar">
        <li class="logo">
            <img src="image/logo.png" alt="QuickSlot Logo" style="height: 50px; margin-right: 20px;">
        </li>
        <li><a href="index.php">Home</a></li>
        <?php 
            if (isset($_SESSION["userid"])) {
            ?>
            <li><a href="account.php">Account</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php
            } else
            { ?>
            <li><a href="login.php">Login</a></li>
                <?php
                }
        ?>
        <li>
            <a href="#">Menu</a>
            <ul class="dropdown">
                <li><a href="events.php">Events</a></li>
                <?php 
                    if (isset($_SESSION["userid"])) {
                    ?>
                    <li><a href="manage.php">Manage bookings</a></li>
                    <?php
                    } else {
                    ?>
                    <li><a href="signup.php">Sign Up</a></li>
                    <?php
                    }
                ?>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </li>
    </ul>
</nav>

<style>
    .navbar {
        background: #0074D9;
        display: flex;
        align-items: center;
        padding: 0 24px;
        justify-content: flex-end;
        box-shadow: 0 2px 12px rgba(0, 116, 217, 0.08);
        height: 65px;
        min-height: 65px;
        z-index: 10;
        margin: 0;
        list-style: none;
    }

    .navbar .logo {
        margin-right: auto; 
    }

    .navbar li {
        list-style: none;
        position: relative;
    }

    .navbar ul {
        margin: 0;
        padding: 0;
    }

    .navbar a {
        font-size: 1.25rem;
        color: white;
        text-align: center;
        padding: 16px 22px;
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 700;
        letter-spacing: 0.7px;
        transition: font-size 0.2s, padding 0.2s;
        display: block;
    }

    .navbar a:hover {
        background: #00c3ff;
        color: #fff;
    }

    .dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown li {
        padding: 0;
    }

    .dropdown li a {
        text-decoration: none;
        color: black;
        padding: 12px 16px;
        display: block;
    }

    .dropdown li a:hover {
        background-color: #ddd;
    }

    li:hover .dropdown {
        display: block;
    }
</style>
