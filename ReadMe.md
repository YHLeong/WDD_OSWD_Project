

# WDD_OSWD_Project

Comprehensive README for a small PHP/MySQL event booking application.

**Status:** Prototype (plain-PHP, no framework)

## Overview
WDD_OSWD_Project is an educational web application that demonstrates a simple event listing and booking workflow built with vanilla PHP and MySQL. The app supports user registration/login, event creation (admin), bookings, cancellations, image uploads for events, and a contact form.

The codebase is intentionally straightforward to make it suitable for learning server-side PHP concepts, simple CRUD operations, and basic session-based authentication.

## Features (detailed)
- Public event listing with basic metadata (title, date, venue, price, description).
- Event detail page with booking form.
- User authentication: signup, login, logout, and a basic `Account.php` page showing user bookings.
- Booking lifecycle: create booking (`book_event.php`) and cancel booking (`cancel_booking.php`).
- Admin/management page (`manage.php`) to add/update events and images via `update_images.php`.
- Contact form with simple processing (`contact.php`, `contact_process.php`).
- Database setup script: `setup_events_db.php` to create tables used by the app.

## Architecture & Flow
- Entry: `index.php` lists events; each event links to a detail page handled by `Events.php` helper logic.
- Authentication: `signup_process.php` and `login_process.php` handle POSTed credential data, set PHP sessions on success.
- Bookings: `book_event.php` records bookings with references to user ID and event ID. `cancel_booking.php` removes or flags bookings as cancelled.
- Admin: `manage.php` likely uses a session flag (or simple check) to restrict access — verify this before production use.

## Database (high level)
The DB schema is created by `setup_events_db.php`. Typical tables you should expect:
- `users` — stores user accounts (email, password hash, name, created_at)
- `events` — stores event metadata (title, description, venue, date/time, price, image path)
- `bookings` — links users to events with booking timestamps and status

Open `setup_events_db.php` to view the exact CREATE TABLE statements and adapt them if needed.

## Requirements
- PHP 7.4 or newer (ensure `pdo_mysql` or mysqli available)
- MySQL or MariaDB server
- Webserver (Apache via XAMPP/WAMP, or PHP built-in server for testing)

## Installation (step-by-step)
1. Place the project in your webserver document root. Example for XAMPP on Windows:

	- Copy `WDD_OSWD_Project` to `C:\xampp\htdocs\WDD_OSWD_Project`

2. Configure database connection in `dbinfo.php`:

	- Edit host, username, password, and database name to match your MySQL setup.

3. Create the database and tables:

	- Option A (browser): Start Apache + MySQL, then visit `http://localhost/WDD_OSWD_Project/setup_events_db.php`.
	- Option B (CLI): From project dir run:

```powershell
php setup_events_db.php
```

4. (Optional) Create an initial admin user by inserting directly into the `users` table or by signing up and then using `manage.php`.

5. Ensure permissions for uploads: If `update_images.php` writes to an `images/` or `uploads/` folder, make sure PHP can write there.

6. Open `http://localhost/WDD_OSWD_Project/` in your browser to view the site.

## Configuration suggestions
- For development, keep DB credentials in `dbinfo.php` (already used by the project). For production, migrate secrets to environment variables or a separate config file outside the webroot.
- Consider renaming `dbinfo.php` to `config.php` and load using `require_once` to centralize configuration.

## Running with PHP built-in server (dev)
From the project root you can test quickly with:

```powershell
php -S localhost:8000

# Then open http://localhost:8000/index.php
```

Note: Some routing may expect files at the webroot; using Apache/XAMPP gives the most consistent results.

## Testing & Demo Data
- If you want seed/demo data, I can add a small SQL file (`demo_data.sql`) that inserts sample events and a test user.

## Security and Hardening (important)
- Passwords: Ensure `signup_process.php` uses `password_hash()` and `password_verify()` (review code to confirm).
- Prepared statements: Use prepared statements (PDO or mysqli prepared) for all DB writes/reads to prevent SQL injection.
- Session management: Regenerate session IDs after login and set proper cookie flags (`HttpOnly`, `Secure` when using HTTPS).
- File uploads: Validate file types and sizes in `update_images.php` and store uploads outside the webroot or sanitize filenames.
- Access control: Verify `manage.php` has server-side checks; client-side checks alone are insufficient.

## Troubleshooting
- "Can't connect to DB": Confirm MySQL is running and `dbinfo.php` credentials match; ensure DB user has CREATE/INSERT/SELECT rights.
- "Uploads fail": Check folder permissions and `upload_max_filesize` / `post_max_size` in `php.ini`.
- "Sessions not persisting": Ensure PHP session folder is writable and cookies are enabled in your browser.

## Contribution Guide
1. Fork the repository.
2. Create a branch: `feature/<short-desc>`.
3. Add tests or provide a brief manual test plan for changes.
4. Open a pull request with a description and screenshots if relevant.

## Roadmap / Suggested Improvements
- Add a small router and split logic to controllers for better structure.
- Introduce Composer and PSR-4 autoloading.
- Replace direct DB calls with a lightweight DB layer (PDO wrapper).
- Add unit/integration tests and CI for automated checks.

## License
No license file is included. Add a `LICENSE` if you want to publish under an open-source license.

## Contact
If you want me to add demo data, a `.env` loader, or refactor to use PDO, tell me which and I'll implement it.

