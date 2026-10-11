<?php
require_once __DIR__ . '/includes/auth.php';
require_login('login.php');

$pageTitle = "Student Help Desk - Home";
$currentPage = "home";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<section class="hero">
    <h2>Your One-Stop Student Support System</h2>
    <p>Get instant assistance with admissions, exams, fees, scholarships, portal access, and general academic support.</p>
    <div class="btn-group">
        <a class="btn" href="complaint.php">Submit Complaint</a>
        <a class="btn" href="status.php">Track Request</a>
        <a class="btn" href="contact.php">Contact Support</a>
    </div>
</section>

<section class="section">
    <h2>Welcome to Student Help Desk</h2>
    <p>We are dedicated to supporting students with quick, reliable help for academic, administrative, and technical queries. Our goal is to make campus services accessible, straightforward, and efficient.</p>
</section>

<section class="section">
    <h2>Our Support Categories</h2>
    <div class="cards">
        <div class="card">
            <h3>Admission Support</h3>
            <p>Help with admission procedures, eligibility, merit lists, and document verification.</p>
        </div>
        <div class="card">
            <h3>Exam Queries</h3>
            <p>Support for exam scheduling, hall tickets, grades, and marksheet discrepancies.</p>
        </div>
        <div class="card">
            <h3>Fee Assistance</h3>
            <p>Resolve payment gateway failures, fee receipts, deadlines, and refund requests.</p>
        </div>
        <div class="card">
            <h3>Scholarship Help</h3>
            <p>Information on government and institutional scholarship criteria and application verification.</p>
        </div>
        <div class="card">
            <h3>Technical Support</h3>
            <p>Resolve student portal login errors, password resets, and LMS access issues.</p>
        </div>
        <div class="card">
            <h3>Hostel / Transport</h3>
            <p>Assistance with campus accommodation, mess facilities, and bus transit schedules.</p>
        </div>
    </div>
</section>

<section class="section">
    <h2>How It Works</h2>
    <div class="steps">
        <ol>
            <li><strong>Submit your complaint:</strong> Fill out the simple online complaint form with your student details.</li>
            <li><strong>Receive your Tracking ID:</strong> A unique Complaint ID is automatically generated for tracking.</li>
            <li><strong>Staff Review:</strong> The administration investigates your query and updates its status.</li>
            <li><strong>Resolution:</strong> Track live updates through the status tracker until the issue is resolved.</li>
        </ol>
    </div>
</section>

<section class="section">
    <h2>Notice Board &amp; Announcements</h2>
    <div class="announcement">
        <ul>
            <li>📢 Semester examination registration closes on 25 March 2026.</li>
            <li>📢 National Scholarship Portal verification window open until 22 March 2026.</li>
            <li>📢 Scheduled portal server maintenance this Sunday from 10:00 PM to 12:00 AM.</li>
        </ul>
    </div>
</section>

<section class="section">
    <h2>Frequently Asked Questions</h2>
    <div class="faq">
        <p><strong>Q: How do I track my submitted complaint?</strong><br>A: Go to the "Status" page and enter your Complaint ID or your 12-digit Student ID.</p>
        <p><strong>Q: How long does it take for a complaint to be resolved?</strong><br>A: Most student requests are addressed within 24 to 48 working hours.</p>
        <p><strong>Q: Can I submit multiple complaints?</strong><br>A: Yes, each complaint receives an individual tracking number for separate investigation.</p>
    </div>
</section>

<?php
include __DIR__ . '/includes/footer.php';
?>