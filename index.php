<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="CSS/Home_page.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="banner">
        <div class="banner-overlay" style="background:rgba(0,0,0,0.18);"></div>
        <div class="banner-content" style="position:relative;z-index:2;">
            <div class="banner-title">Book Your Next Event Effortlessly</div>
            <div class="banner-desc">Discover and book amazing events near you with just a few clicks.</div>
            <a href="Events.php" class="banner-btn" style="margin-top:32px;box-shadow:0 4px 16px rgba(0,116,217,0.18);font-size:1.25rem;display:inline-block;text-decoration:none;">Browse Events</a>
        </div>
    </div>
    <section aria-label="Upcoming events" id="events">
        <h3>Upcoming Events</h3>
        <div class="events-grid">
            <article aria-describedby="event1-desc event1-date" aria-labelledby="event1-title" class="event-card" tabindex="0">
                <img alt="Professional adults in a classroom setting, engaging in a digital marketing workshop" class="event-image" height="400" src="https://images.unsplash.com/photo-1513258496099-48168024aec0?auto=format&fit=crop&w=600&q=80" width="600"/>
                <div class="event-content">
                    <h4 class="event-title" id="event1-title">Digital Marketing Bootcamp</h4>
                    <p class="event-description" id="event1-desc">Master the essentials of digital marketing and boost your career prospects in just one weekend.</p>
                    <div class="event-footer">
                        <time class="event-date" datetime="2026-07-20" id="event1-date">July 20, 2026</time>
                        <button aria-label="Book Digital Marketing Bootcamp event" class="event-button" type="button">Book Now</button>
                    </div>
                </div>
            </article>
            <article aria-describedby="event2-desc event2-date" aria-labelledby="event2-title" class="event-card" tabindex="0">
                <img alt="Public speaking workshop" class="event-image" height="400" src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=600&q=80" width="600"/>
                <div class="event-content">
                    <h4 class="event-title" id="event2-title">Python Programming for Beginners</h4>
                    <p class="event-description" id="event2-desc">Kickstart your programming journey with hands-on Python lessons tailored for working professionals.</p>
                    <div class="event-footer">
                        <time class="event-date" datetime="2026-08-05" id="event2-date">August 5, 2026</time>
                        <button aria-label="Book Python Programming for Beginners event" class="event-button" type="button">Book Now</button>
                    </div>
                </div>
            </article>
            <article aria-describedby="event3-desc event3-date" aria-labelledby="event3-title" class="event-card" tabindex="0">
                <img alt="Adults collaborating on laptops during a coding workshop" class="event-image" height="400" src="https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=600&q=80" width="600"/>
                <div class="event-content">
                    <h4 class="event-title" id="event3-title">Leadership & Communication Skills</h4>
                    <p class="event-description" id="event3-desc">Enhance your leadership and communication skills to excel in your workplace and beyond.</p>
                    <div class="event-footer">
                        <time class="event-date" datetime="2026-09-12" id="event3-date">September 12, 2026</time>
                        <button aria-label="Book Leadership & Communication Skills event" class="event-button" type="button">Book Now</button>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
