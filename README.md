# Student Help Desk

A PHP-based student support system for submitting complaints, tracking issue status, and managing requests from an admin dashboard.

## Overview

This project is designed for educational institutions to provide a simple online communication channel between students and support/admin staff. Students can:

- submit complaint requests
- choose a category such as admissions, exams, fees, scholarships, technical issues, or hostel/transport
- receive a unique complaint ID for tracking
- check the current status of their issue by complaint ID or student ID

Admins can:

- view all submitted complaints
- review details for each student issue
- update complaint status to Pending, In Progress, or Resolved
- monitor total and category-wise complaint counts

## Features

- Student-friendly complaint submission form
- Input validation for email, student ID, and required fields
- Complaint tracking by complaint ID or student ID
- Admin dashboard with summary statistics
- Status updates for each complaint
- Responsive front-end built with PHP, HTML, CSS, and JavaScript
- MySQL database integration

## Tech Stack

- PHP
- MySQL
- Apache (via XAMPP)
- HTML, CSS, JavaScript

## Project Structure

```text
Help_Desk/
├── admin/
│   ├── dashboard.php
│   └── update_status.php
├── assets/
│   ├── css/
│   └── js/
├── config/
│   └── db.php
├── database/
│   └── student_helpdesk.sql
├── includes/
│   ├── auth.php
│   ├── footer.php
│   ├── header.php
│   └── navbar.php
├── about.php
├── admin_dashboard.php
├── complaint.php
├── contact.php
├── dbconnect.php
├── index.php
├── login.php
├── logout.php
├── script.js
├── status.php
├── student_helpdesk.sql
├── submit_complaint.php
├── update_status.php
├── style.css
└── README.md
```

## Prerequisites

Before running the project, make sure you have the following installed:

- XAMPP or a similar local PHP + MySQL environment
- Apache web server
- MySQL database server
- A browser such as Chrome or Firefox

## Installation

1. Place the project in your XAMPP `htdocs` folder.

   Example:

   ```text
   C:\xampp\htdocs\Help_Desk
   ```

2. Start Apache and MySQL from the XAMPP Control Panel.

3. Import the database schema if needed:

   ```bash
   mysql -u root -p < database/student_helpdesk.sql
   ```

   Alternatively, the application can auto-create the `student_helpdesk` database and `complaints` table when first connected.

4. Open the app in your browser:

   ```text
   http://localhost/Help_Desk/
   ```

## Default Login Credentials

The application includes demo login accounts:

- Admin: `admin` / `1234`
- User: `user` / `1234`

Admin dashboard URL:

```text
http://localhost/Help_Desk/admin/dashboard.php
```

## Database Configuration

The database configuration is defined in `config/db.php`:

```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "student_helpdesk";
```

If your XAMPP setup uses a different MySQL password, update the credentials in this file before running the project.

## Usage

1. Open the home page.
2. Log in with a user account.
3. Click "Submit Complaint".
4. Fill out the complaint form.
5. Submit the form and note the generated complaint ID.
6. Use the status page to track progress using the complaint ID or student ID.
7. Log in as admin to update complaint statuses and monitor the dashboard.

## Notes

- This project is intended for local development and demo purposes.
- The authentication is simple and hardcoded for demo usage.
- The database schema includes sample complaint records for testing.

## License

This project is distributed for educational and demonstration purposes.
