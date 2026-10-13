# Student Help Desk

A PHP-based student support system for submitting complaints, tracking issue status, user registration & authentication, and managing requests from an admin dashboard.

## Overview

This project is designed for educational institutions to provide a simple online communication channel between students and support/admin staff. Students can:

- Register a new account and securely log in
- Submit complaint requests with pre-filled profile information
- Choose a category such as admissions, exams, fees, scholarships, technical issues, or hostel/transport
- Receive a unique complaint ID for tracking
- Check the current status of their issue by complaint ID or student ID

Admins can:

- Log in securely to access the administrative panel
- View all submitted complaints and total registered users
- Review details for each student issue
- Update complaint status to Pending, In Progress, or Resolved
- Monitor total and category-wise complaint counts

## Features

- **User Registration & Login**: Database-driven authentication with secure Bcrypt password hashing (`password_hash` & `password_verify`).
- **Role-Based Access Control**: Differentiates between `student` and `admin` roles.
- **Login via Username or Email**: Flexible login identifier support.
- **Input Validation**: Both client-side JavaScript and server-side PHP validation for all forms.
- **Auto-Fill Profile**: Pre-fills student full name, email, and student ID in complaint forms.
- **Complaint Tracking**: Real-time status lookup by complaint ID or 12-digit student ID.
- **Admin Dashboard**: Comprehensive overview with summary statistics, user count, and status update controls.
- **Responsive UI**: Clean, mobile-friendly interface built with PHP, HTML5, CSS3, and JavaScript.
- **MySQL Integration**: Automatic table creation and demo seeding upon first load.

## Tech Stack

- **PHP** (>= 7.4 / 8.x)
- **MySQL** / MariaDB
- **Apache** (via XAMPP)
- **HTML5, CSS3, JavaScript**

## Project Structure

```text
Help_Desk/
├── admin/
│   ├── dashboard.php          # Admin complaint management and statistics
│   └── update_status.php      # Complaint status update handler
├── assets/
│   ├── css/
│   │   └── style.css          # Main stylesheet
│   └── js/
│       └── script.js          # Client-side validation and utilities
├── config/
│   └── db.php                 # Database connection, table auto-creation & seeding
├── database/
│   └── student_helpdesk.sql   # SQL database schema and seed data
├── includes/
│   ├── auth.php               # Session and authentication helpers
│   ├── footer.php             # Shared HTML footer and script includes
│   ├── header.php             # Shared HTML header and stylesheet links
│   └── navbar.php             # Dynamic navigation bar with user badge
├── about.php                  # About information page
├── complaint.php              # Complaint submission form (auto-fills student info)
├── contact.php                # Support contacts and campus helplines
├── index.php                  # Home page
├── login.php                  # User and Admin login page (supports username/email)
├── logout.php                 # Session destroy and logout handler
├── register.php               # Account registration page
├── status.php                 # Complaint tracking page
├── submit_complaint.php       # Complaint submission processor
└── README.md                  # Project documentation
```

## Prerequisites

Before running the project, make sure you have the following installed:

- XAMPP or a similar local PHP + MySQL environment
- Apache web server
- MySQL database server
- Modern web browser (Chrome, Firefox, Edge, etc.)

## Installation & Setup

1. Place the project folder in your XAMPP `htdocs` directory:

   ```text
   C:\xampp\htdocs\Help_Desk
   ```

2. Start **Apache** and **MySQL** from your XAMPP Control Panel.

3. Open your browser and navigate to:

   ```text
   http://localhost/Help_Desk/
   ```

   *Note: On first run, `config/db.php` will automatically create the `student_helpdesk` database, the `complaints` table, and the `users` table, pre-seeding default demo accounts!*

4. Alternatively, you can manually import the database schema:

   ```bash
   mysql -u root -p < database/student_helpdesk.sql
   ```

## User Access & Registration

Students can create an account directly via the [Student Registration Page](http://localhost/Help_Desk/register.php) and log in using their username or email. Admin access to the administrative dashboard is strictly system-managed.

## Registration Details (Students Only)

- **Full Name**: Minimum 3 characters
- **Username**: 3-30 characters (alphanumeric and underscores)
- **Email**: Valid email format (must be unique)
- **Student ID**: Exactly 12 numeric digits
- **Password**: Minimum 6 characters (stored as secure bcrypt hash)
- **Role**: Automatically assigned as `student`

## Database Configuration

The database connection is configured in `config/db.php`:

```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "student_helpdesk";
```

If your MySQL service uses a root password, update `config/db.php` accordingly.

## License

This project is distributed for educational and demonstration purposes.
