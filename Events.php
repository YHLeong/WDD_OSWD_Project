<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="CSS/events.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>  
    <div class="events-title">Book your slot now</div>
    
    <?php
    //************************************************
    // Display success/error messages
    //************************************************
    if (isset($_GET['success']) && $_GET['success'] == 'booking_confirmed'): ?>
        <div class="alert alert-success">
            Event booked successfully! Check your bookings in the Manage Bookings section.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php 
            if ($_GET['error'] == 'already_booked') {
                echo "You have already booked this event.";
            } elseif ($_GET['error'] == 'booking_failed') {
                echo "Booking failed. Please try again.";
            } elseif ($_GET['error'] == 'missing_event') {
                echo "Invalid event selection.";
            }
            ?>
        </div>
    <?php endif; ?>
    
    <div class="events-grid">
        <?php
        //************************************************
        // Fetch events from database
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
        
        $sqlstatement = "SELECT * FROM events ORDER BY event_date ASC";
        $result = $mysqli->query($sqlstatement);
        
        if ($result && $result->num_rows > 0) {
            // Hardcoded image array
            $eventImages = [
                1 => "image/Digital Marketing Bootcamp.avif",
                2 => "image/Python Programming.avif", 
                3 => "image/Leadership & Communication Skills.avif",
                4 => "image/Creative Design Workshop.avif",
                5 => "image/Project Management Essentials.avif",
                6 => "image/Public Speaking Mastery.avif"
            ];
            
            $cardIndex = 0; // Counter for staggered animations
            while($row = $result->fetch_assoc()) {
                // Use hardcoded image based on event_id, fallback to logo if not found
                $imagePath = isset($eventImages[$row['event_id']]) ? $eventImages[$row['event_id']] : "image/logo.png";
                
                // Format the event date and time for display
                $formatted_date = date('F j, Y', strtotime($row['event_date']));
                $formatted_time = date('g:i A', strtotime($row['event_time']));
                ?>
                <div class="event-card" style="--delay: <?php echo $cardIndex; ?>">
                    <img class="event-image-placeholder" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="--delay: <?php echo $cardIndex; ?>">
                    <div class="event-content" style="--delay: <?php echo $cardIndex; ?>">
                        <div style="font-weight:bold;font-size:1.1rem;margin-bottom:6px;color:#0074D9;"><?php echo htmlspecialchars($row['name']); ?></div>
                        <div style="font-size:0.98rem;color:#444;margin-bottom:10px;"><?php echo htmlspecialchars($row['description']); ?></div>
                        <div style="font-size:0.95rem;color:#666;margin-bottom:12px;font-weight:500;">
                            📅 <?php echo $formatted_date; ?> at <?php echo $formatted_time; ?>
                        </div>
                        <div class="event-footer" style="--delay: <?php echo $cardIndex; ?>">
                            <?php if (isset($_SESSION["userid"])): ?>
                                <form method="POST" action="book_event.php" style="display:inline;">
                                    <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                                    <button type="submit" class="event-button">Book Now</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php" class="event-button" style="text-decoration:none;display:inline-block;text-align:center;">Login to Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                $cardIndex++; // Increment for next card's staggered animation
            }
        } else {
            echo "<p>No events available at the moment.</p>";
        }
        $mysqli->close();
        ?>
    </div>
    
    <style>
        .alert {
            padding: 12px;
            margin: 20px auto;
            border-radius: 4px;
            max-width: 800px;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    
    <?php include 'footer.php'; ?>
</body>
</html>