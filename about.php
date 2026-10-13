<?php
require_once __DIR__ . '/includes/auth.php';

$pageTitle = "About - Student Help Desk";
$currentPage = "about";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2>About Us</h2>
    <p>Student Help Desk is a centralized digital support platform designed to assist students with academic, administrative, and technical issues. Our mission is to provide quick, simple, and reliable services for every student.</p>
    <p>Through this portal, students can submit complaints, track request status in real-time, find contact information, and resolve common problems related to admission, examinations, fees, scholarships, and student portal access.</p>
    
    <div class="info-box">
        <h3>Our Mission</h3>
        <p>To establish a smooth, responsive, and student-friendly grievance redressal system that saves time, promotes transparent communication, and resolves campus issues efficiently.</p>
    </div>

    <div class="info-box" style="margin-top:20px; border-left-color: #2ecc71; background: #f2faf4;">
        <h3>Core Principles</h3>
        <p><strong>Transparency:</strong> Every inquiry is assigned a unique ID for end-to-end status tracking.<br>
        <strong>Speed:</strong> Issues are routed directly to authorized administrators for rapid turnaround.<br>
        <strong>Accessibility:</strong> Simple 24/7 online submission from any device.</p>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>