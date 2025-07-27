<?php session_start(); 

//************************************************
// Check if user is logged in
//************************************************
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booking</title>
    <link rel="stylesheet" href="CSS/Manage_bookings.css">
</head>
<body>
    <?php include 'Navbar.php';?>
    
    <?php
    //************************************************
    // Display success/error messages
    //************************************************
    if (isset($_GET['success']) && $_GET['success'] == 'booking_cancelled'): ?>
        <div class="alert alert-success">
            Booking cancelled successfully!
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php 
            if ($_GET['error'] == 'cancel_failed') {
                echo "Failed to cancel booking. Please try again.";
            } elseif ($_GET['error'] == 'too_late') {
                echo "Cannot cancel booking within 2 hours of event start time.";
            } elseif ($_GET['error'] == 'invalid_booking') {
                echo "Invalid booking selected.";
            }
            ?>
        </div>
    <?php endif; ?>
    
    <div class="appointments-container">
        <div class="appointments-sidebar">
            <div class="appointments-title">My Bookings</div>
            
            <?php
            //************************************************
            // Fetch user's bookings from database
            //************************************************
            require_once("dbinfo.php");
            $mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);
            if($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: ".$mysqli->connect_error;
                exit();
            }
            
            $user_id = $_SESSION["userid"];
            
            // Get current datetime
            $current_datetime = date('Y-m-d H:i:s');
            
            // Fetch upcoming bookings (events that haven't happened yet)
            $stmt = $mysqli->prepare("SELECT b.booking_id, b.booking_date, b.status, e.event_id, e.name, e.event_date, e.event_time, e.description 
                                     FROM bookings b 
                                     JOIN events e ON b.event_id = e.event_id 
                                     WHERE b.user_id = ? AND CONCAT(e.event_date, ' ', e.event_time) > ? 
                                     ORDER BY e.event_date ASC, e.event_time ASC");
            $stmt->bind_param('ss', $user_id, $current_datetime);
            $stmt->execute();
            $upcoming_result = $stmt->get_result();
            $upcoming_bookings = $upcoming_result->fetch_all(MYSQLI_ASSOC);
            
            // Fetch past bookings
            $stmt = $mysqli->prepare("SELECT b.booking_id, b.booking_date, b.status, e.event_id, e.name, e.event_date, e.event_time, e.description 
                                     FROM bookings b 
                                     JOIN events e ON b.event_id = e.event_id 
                                     WHERE b.user_id = ? AND CONCAT(e.event_date, ' ', e.event_time) <= ? 
                                     ORDER BY e.event_date DESC, e.event_time DESC");
            $stmt->bind_param('ss', $user_id, $current_datetime);
            $stmt->execute();
            $past_result = $stmt->get_result();
            $past_bookings = $past_result->fetch_all(MYSQLI_ASSOC);
            
            // Hardcoded image array (same as events.php)
            $eventImages = [
                1 => "image/Digital Marketing Bootcamp.avif",
                2 => "image/Python Programming.avif", 
                3 => "image/Leadership & Communication Skills.avif",
                4 => "image/Creative Design Workshop.avif",
                5 => "image/Project Management Essentials.avif",
                6 => "image/Public Speaking Mastery.avif"
            ];
            ?>
            
            <div class="section-title">
                Upcoming
                <span class="badge"><?php echo count($upcoming_bookings); ?></span>
            </div>
            <div class="booking-list">
                <?php if (empty($upcoming_bookings)): ?>
                    <p style="color: #666; font-style: italic; padding: 20px 0;">No upcoming bookings</p>
                <?php else: ?>
                    <?php foreach ($upcoming_bookings as $booking): 
                        $imagePath = isset($eventImages[$booking['event_id']]) ? $eventImages[$booking['event_id']] : "image/logo.png";
                        $formatted_date = date('F j, Y', strtotime($booking['event_date']));
                        $formatted_time = date('g:i A', strtotime($booking['event_time']));
                    ?>
                        <div class="booking-card upcoming" data-booking-id="<?php echo $booking['booking_id']; ?>" 
                             data-event-id="<?php echo $booking['event_id']; ?>" 
                             data-event-name="<?php echo htmlspecialchars($booking['name']); ?>"
                             data-event-date="<?php echo $booking['event_date']; ?>"
                             data-event-time="<?php echo $booking['event_time']; ?>">
                            <img class="booking-img" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($booking['name']); ?>" />
                            <div class="booking-info">
                                <div class="booking-title"><?php echo htmlspecialchars($booking['name']); ?></div>
                                <div class="booking-meta">
                                    <span><?php echo $formatted_date; ?></span>
                                    <span><?php echo $formatted_time; ?></span>
                                </div>
                                <div class="book-again" onclick="selectBooking(this)">View Details</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="section-title" style="margin-top:32px;">
                Past
                <span class="badge"><?php echo count($past_bookings); ?></span>
            </div>
            <div class="booking-list">
                <?php if (empty($past_bookings)): ?>
                    <p style="color: #666; font-style: italic; padding: 20px 0;">No past bookings</p>
                <?php else: ?>
                    <?php foreach ($past_bookings as $booking): 
                        $imagePath = isset($eventImages[$booking['event_id']]) ? $eventImages[$booking['event_id']] : "image/logo.png";
                        $formatted_date = date('F j, Y', strtotime($booking['event_date']));
                        $formatted_time = date('g:i A', strtotime($booking['event_time']));
                    ?>
                        <div class="booking-card past" data-booking-id="<?php echo $booking['booking_id']; ?>" 
                             data-event-id="<?php echo $booking['event_id']; ?>" 
                             data-event-name="<?php echo htmlspecialchars($booking['name']); ?>"
                             data-event-date="<?php echo $booking['event_date']; ?>"
                             data-event-time="<?php echo $booking['event_time']; ?>">
                            <img class="booking-img" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($booking['name']); ?>" />
                            <div class="booking-info">
                                <div class="booking-title"><?php echo htmlspecialchars($booking['name']); ?></div>
                                <div class="booking-meta">
                                    <span><?php echo $formatted_date; ?></span>
                                    <span><?php echo $formatted_time; ?></span>
                                </div>
                                <div class="book-again" onclick="selectBooking(this)">View Details</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="appointments-main">
            <div class="main-card" id="main-card">
                <?php if (!empty($upcoming_bookings)): 
                    $first_booking = $upcoming_bookings[0];
                    $imagePath = isset($eventImages[$first_booking['event_id']]) ? $eventImages[$first_booking['event_id']] : "image/logo.png";
                ?>
                    <div class="main-img" style="background-image: url('<?php echo $imagePath; ?>');">
                        <div class="main-img-title" id="main-title"><?php echo htmlspecialchars($first_booking['name']); ?></div>
                    </div>
                    <div class="main-content">
                        <div class="status-badge" id="status-badge">Upcoming</div>
                        <div class="main-date" id="main-date"><?php echo date('F j, Y', strtotime($first_booking['event_date'])); ?></div>
                        <div class="main-duration" id="main-duration"><?php echo date('g:i A', strtotime($first_booking['event_time'])); ?></div>
                        <div class="main-links">
                            <a class="main-link" href="https://maps.google.com" target="_blank" rel="noopener noreferrer">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/geo-alt-fill.svg" alt="Map Pin" class="main-link-icon" /> Getting there
                            </a>
                            <button class="main-link main-link-btn" type="button" id="cancelBtn">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/gear-fill.svg" alt="Manage Booking" class="main-link-icon" /> Cancel
                            </button>
                        </div>
                        <div class="main-booking-id">Booking ref: <b>BK<?php echo str_pad($first_booking['booking_id'], 6, '0', STR_PAD_LEFT); ?></b></div>
                    </div>
                <?php else: ?>
                    <div class="main-content" style="text-align: center; padding: 50px;">
                        <h3>No bookings to display</h3>
                        <p>You don't have any bookings yet. <a href="events.php">Browse events</a> to make your first booking!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
        </div>
    </div>
    
    <!-- Cancel Booking Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h3>Cancel Booking?</h3>
            <p>Are you sure you want to cancel this booking?</p>
            <div class="modal-actions">
                <button class="modal-btn confirm" id="confirmCancel">Yes, Cancel</button>
                <button class="modal-btn cancel" id="cancelCancel">No</button>
            </div>
        </div>
    </div>
    
    <style>
        .alert {
            padding: 12px;
            margin: 20px auto;
            border-radius: 4px;
            max-width: 1200px;
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
    
    <footer class="footer">
        &copy; 2024 Event Booking. All rights reserved.
    </footer>
    
    <script>
        let currentBookingId = null;
        let currentEventDate = null;
        let currentEventTime = null;
        
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelModal = document.getElementById('cancelModal');
        const cancelCancel = document.getElementById('cancelCancel');
        const confirmCancel = document.getElementById('confirmCancel');
        
        function selectBooking(element) {
            const bookingCard = element.closest('.booking-card');
            const bookingId = bookingCard.getAttribute('data-booking-id');
            const eventId = bookingCard.getAttribute('data-event-id');
            const eventName = bookingCard.getAttribute('data-event-name');
            const eventDate = bookingCard.getAttribute('data-event-date');
            const eventTime = bookingCard.getAttribute('data-event-time');
            
            // Update current booking info
            currentBookingId = bookingId;
            currentEventDate = eventDate;
            currentEventTime = eventTime;
            
            // Event images mapping (same as PHP)
            const eventImages = {
                1: "image/Digital Marketing Bootcamp.avif",
                2: "image/Python Programming.avif", 
                3: "image/Leadership & Communication Skills.avif",
                4: "image/Creative Design Workshop.avif",
                5: "image/Project Management Essentials.avif",
                6: "image/Public Speaking Mastery.avif"
            };
            
            // Get the correct image path
            const imagePath = eventImages[eventId] || "image/logo.png";
            
            // Update main panel
            const mainImg = document.querySelector('.main-img');
            const mainTitle = document.getElementById('main-title');
            const mainDate = document.getElementById('main-date');
            const mainDuration = document.getElementById('main-duration');
            const statusBadge = document.getElementById('status-badge');
            
            // Update the background image
            if (mainImg) {
                mainImg.style.backgroundImage = `url('${imagePath}')`;
            }
            
            if (mainTitle) mainTitle.textContent = eventName;
            if (mainDate) mainDate.textContent = new Date(eventDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            if (mainDuration) mainDuration.textContent = new Date('1970-01-01T' + eventTime + 'Z').toLocaleTimeString('en-US', { timeZone: 'UTC', hour: 'numeric', minute: '2-digit', hour12: true });
            
            // Update status badge
            const isUpcoming = bookingCard.classList.contains('upcoming');
            if (statusBadge) {
                statusBadge.textContent = isUpcoming ? 'Upcoming' : 'Past';
                statusBadge.className = isUpcoming ? 'status-badge' : 'status-badge past';
            }
            
            // Show/hide cancel button based on booking type
            if (cancelBtn) {
                cancelBtn.style.display = isUpcoming ? 'flex' : 'none';
            }
            
            // Update booking reference
            const bookingRef = document.querySelector('.main-booking-id b');
            if (bookingRef) {
                bookingRef.textContent = 'BK' + bookingId.padStart(6, '0');
            }
        }
        
        function canCancelBooking(eventDate, eventTime) {
            const eventDateTime = new Date(eventDate + 'T' + eventTime);
            const currentTime = new Date();
            const timeDifference = eventDateTime - currentTime;
            const twoHoursInMs = 2 * 60 * 60 * 1000; // 2 hours in milliseconds
            
            return timeDifference > twoHoursInMs;
        }
        
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                if (!currentBookingId) {
                    alert('Please select a booking first');
                    return;
                }
                
                if (!canCancelBooking(currentEventDate, currentEventTime)) {
                    alert('Cannot cancel booking within 2 hours of event start time.');
                    return;
                }
                
                cancelModal.classList.add('show');
            });
        }
        
        if (cancelCancel) {
            cancelCancel.addEventListener('click', () => {
                cancelModal.classList.remove('show');
            });
        }
        
        if (confirmCancel) {
            confirmCancel.addEventListener('click', () => {
                if (currentBookingId) {
                    // Create form and submit to cancel booking
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'cancel_booking.php';
                    
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'booking_id';
                    input.value = currentBookingId;
                    
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        
        window.onclick = function(event) {
            if (event.target === cancelModal) {
                cancelModal.classList.remove('show');
            }
        };
        
        // Auto-select first upcoming booking if available
        document.addEventListener('DOMContentLoaded', function() {
            const firstUpcoming = document.querySelector('.booking-card.upcoming .book-again');
            if (firstUpcoming) {
                selectBooking(firstUpcoming);
            }
        });
    </script>
</body>
</html>


