<?php
require_once __DIR__ . '/includes/auth.php';
require_login('login.php');
require_once __DIR__ . '/config/db.php';

$currentUser = current_user();
$searchQuery = '';
if (!empty($_POST['complaintId'])) {
    $searchQuery = trim($_POST['complaintId']);
} elseif (!empty($_GET['id'])) {
    $searchQuery = trim($_GET['id']);
} elseif (!empty($currentUser['student_id'])) {
    $searchQuery = trim($currentUser['student_id']);
}

$pageTitle = "Track Status - Student Help Desk";
$currentPage = "status";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2>Track Complaint Status</h2>
    <p>Enter your Complaint ID (e.g., <code>COMP-20261011-0001</code>) or your 12-digit Student ID to view current status.</p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <strong>✅ Complaint Submitted Successfully!</strong><br>
            Your tracking ID is <strong><?= htmlspecialchars($searchQuery); ?></strong>. Please keep this ID handy for future inquiries.
        </div>
    <?php endif; ?>

    <form method="POST" action="status.php">
        <input type="text" name="complaintId"
               value="<?= htmlspecialchars($searchQuery); ?>"
               placeholder="Enter Complaint ID or Student ID" required>
        <button type="submit">Check Status</button>
    </form>

    <?php
    if (!empty($searchQuery)) {
        $sql = "SELECT * FROM complaints WHERE complaint_id = ? OR student_id = ? ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $searchQuery, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h3 style='margin-top:25px; color:#1e3a5f;'>Found (" . $result->num_rows . ") Record(s):</h3>";
            while ($row = $result->fetch_assoc()) {
                $statusClass = 'badge-pending';
                if ($row['status'] === 'In Progress') {
                    $statusClass = 'badge-progress';
                } elseif ($row['status'] === 'Resolved') {
                    $statusClass = 'badge-resolved';
                }
                ?>
                <div class="status-box">
                    <p><strong>Complaint ID:</strong> <?= htmlspecialchars($row['complaint_id']); ?></p>
                    <p><strong>Student Name:</strong> <?= htmlspecialchars($row['full_name']); ?></p>
                    <p><strong>Student ID:</strong> <?= htmlspecialchars($row['student_id']); ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($row['category']); ?></p>
                    <p><strong>Issue Details:</strong> <?= nl2br(htmlspecialchars($row['issue'])); ?></p>
                    <p><strong>Current Status:</strong> <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($row['status']); ?></span></p>
                    <p><strong>Submitted At:</strong> <?= date('d M Y, h:i A', strtotime($row['created_at'])); ?></p>
                    <p><strong>Last Updated:</strong> 
                        <?= !empty($row['updated_at']) ? date('d M Y, h:i A', strtotime($row['updated_at'])) : 'Not updated yet'; ?>
                    </p>
                </div>
                <?php
            }
        } else {
            echo "<div class='alert alert-danger' style='margin-top:20px;'>❌ No complaint found matching '<strong>" . htmlspecialchars($searchQuery) . "</strong>'. Please check your ID and try again.</div>";
        }

        $stmt->close();
    }
    $conn->close();
    ?>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>