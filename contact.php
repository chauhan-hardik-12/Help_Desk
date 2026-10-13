<?php
require_once __DIR__ . '/includes/auth.php';

$pageTitle = "Contact Support - Student Help Desk";
$currentPage = "contact";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2>Contact Support</h2>
    <p>If you need direct assistance or have urgent inquiries, reach out through our official support channels:</p>
    
    <div class="info-box">
        <p><strong>📧 Support Email:</strong> <a href="mailto:support@studenthelpdesk.com" style="color:#1d6fa5;">support@studenthelpdesk.com</a></p>
        <p><strong>📞 Helplines:</strong> +91-9876543210 / 011-23456789</p>
        <p><strong>🏢 Physical Office:</strong> Student Redressal &amp; Welfare Center, Ground Floor, Admin Block</p>
        <p><strong>🕒 Office Hours:</strong> Monday to Saturday, 9:00 AM – 5:00 PM</p>
    </div>

    <div class="announcement" style="margin-top: 25px;">
        <h3>Emergency Campus Contact</h3>
        <p>For urgent technical issues during online examination windows or fee submission deadlines, call the direct hotline at <strong>+91-9876500000</strong>.</p>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>