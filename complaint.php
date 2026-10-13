<?php
require_once __DIR__ . '/includes/auth.php';
require_login('login.php');

$pageTitle = "Submit Complaint - Student Help Desk";
$currentPage = "complaint";
$currentUser = current_user();
$defaultFullName  = $currentUser['full_name'] ?? '';
$defaultEmail     = $currentUser['email'] ?? '';
$defaultStudentId = $currentUser['student_id'] ?? '';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2>Submit a Complaint / Query</h2>
    <p>Please provide detailed information regarding your problem so we can assist you quickly.</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form id="complaintForm" action="submit_complaint.php" method="POST" onsubmit="return complaintsubmit()">

        <label for="fullName"><strong>Full Name</strong></label>
        <input type="text" name="fullName" id="fullName" placeholder="Enter Full Name" value="<?= htmlspecialchars($defaultFullName); ?>" required>
        <span id="nameError" class="error"></span>

        <label for="email"><strong>Email Address</strong></label>
        <input type="email" name="email" id="email" placeholder="Enter Email Address" value="<?= htmlspecialchars($defaultEmail); ?>" required>
        <span id="emailError" class="error"></span>

        <label for="studentId"><strong>Student ID (12 digits)</strong></label>
        <input type="text" name="studentId" id="studentId" placeholder="Enter 12-digit Student ID" maxlength="12" value="<?= htmlspecialchars($defaultStudentId); ?>" required>
        <span id="idError" class="error"></span>

        <label for="category"><strong>Category</strong></label>
        <select name="category" id="category" required>
            <option value="">-- Select Complaint Category --</option>
            <option value="Admission Issue">Admission Issue</option>
            <option value="Exam Issue">Exam Issue</option>
            <option value="Fee Issue">Fee Issue</option>
            <option value="Scholarship Issue">Scholarship Issue</option>
            <option value="Technical Issue">Technical Issue</option>
            <option value="Hostel / Transport Issue">Hostel / Transport Issue</option>
        </select>
        <span id="catError" class="error"></span>

        <label for="issue"><strong>Issue Description</strong></label>
        <textarea name="issue" id="issue" placeholder="Describe your issue in detail..." required></textarea>
        <span id="issueError" class="error"></span>

        <button type="submit" class="btn-submit">Submit Complaint</button>
    </form>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>