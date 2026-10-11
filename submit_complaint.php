<?php
// submit_complaint.php - Complaint Submission Handler
require_once __DIR__ . '/includes/auth.php';
require_login('login.php');
require_once __DIR__ . '/config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form data safely
    $fullName  = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
    $email     = isset($_POST['email']) ? trim($_POST['email']) : '';
    $studentId = isset($_POST['studentId']) ? trim($_POST['studentId']) : '';
    $category  = isset($_POST['category']) ? trim($_POST['category']) : '';
    $issue     = isset($_POST['issue']) ? trim($_POST['issue']) : '';

    // Validate inputs
    if (empty($fullName) || empty($email) || empty($studentId) || empty($category) || empty($issue)) {
        header("Location: complaint.php?error=" . urlencode("Please fill in all required fields."));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: complaint.php?error=" . urlencode("Please enter a valid email address."));
        exit();
    }

    if (!preg_match('/^\d{12}$/', $studentId)) {
        header("Location: complaint.php?error=" . urlencode("Student ID must be exactly 12 digits."));
        exit();
    }

    // Generate Complaint ID (e.g., COMP-20261011-0001)
    $datePart = date("Ymd");
    $prefix = "COMP-$datePart-";

    $stmt = $conn->prepare("SELECT complaint_id FROM complaints WHERE complaint_id LIKE CONCAT(?, '%') ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $prefix);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $lastNum = (int)substr($row['complaint_id'], -4);
        $newNum = str_pad($lastNum + 1, 4, "0", STR_PAD_LEFT);
    } else {
        $newNum = "0001";
    }
    $stmt->close();

    $complaintId = $prefix . $newNum;

    // Insert into database with status 'Pending'
    $sql = "INSERT INTO complaints (complaint_id, full_name, email, student_id, category, issue, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database error: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssss", $complaintId, $fullName, $email, $studentId, $category, $issue);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: status.php?id=" . urlencode($complaintId) . "&success=1");
        exit();
    } else {
        $errorMsg = $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: complaint.php?error=" . urlencode("Failed to submit complaint: " . $errorMsg));
        exit();
    }

} else {
    header("Location: complaint.php");
    exit();
}
?>