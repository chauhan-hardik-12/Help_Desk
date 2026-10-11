<?php
// admin/update_status.php
require_once __DIR__ . '/../includes/auth.php';
require_admin('../login.php');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['status'])) {
    $id = (int)$_POST['id'];
    $status = trim($_POST['status']);

    $allowedStatuses = ['Pending', 'In Progress', 'Resolved'];
    if (!in_array($status, $allowedStatuses, true)) {
        header("Location: dashboard.php?error=invalid_status");
        exit();
    }

    $sql = "UPDATE complaints SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: dashboard.php?msg=updated");
            exit();
        } else {
            $error = $stmt->error;
            $stmt->close();
            $conn->close();
            header("Location: dashboard.php?error=" . urlencode($error));
            exit();
        }
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
