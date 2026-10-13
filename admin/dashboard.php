<?php
// admin/dashboard.php
require_once __DIR__ . '/../includes/auth.php';
require_admin('../login.php');
require_once __DIR__ . '/../config/db.php';

// Fetch all complaints
$result = $conn->query("SELECT * FROM complaints ORDER BY id DESC");

// Fetch counts for summary cards
$counts = ['total' => 0, 'pending' => 0, 'progress' => 0, 'resolved' => 0];
$countResult = $conn->query("SELECT status, COUNT(*) as cnt FROM complaints GROUP BY status");
if ($countResult) {
    while ($c = $countResult->fetch_assoc()) {
        $counts['total'] += $c['cnt'];
        if ($c['status'] === 'Pending') $counts['pending'] = $c['cnt'];
        if ($c['status'] === 'In Progress') $counts['progress'] = $c['cnt'];
        if ($c['status'] === 'Resolved') $counts['resolved'] = $c['cnt'];
    }
}

// Fetch registered users count
$totalUsers = 0;
$userCountResult = $conn->query("SELECT COUNT(*) as user_cnt FROM users");
if ($userCountResult) {
    $totalUsers = (int)$userCountResult->fetch_assoc()['user_cnt'];
}

$pageTitle = "Admin Dashboard - Student Help Desk";
$basePath = "../";
$currentPage = "admin";
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<style>
.admin-stats {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}
.stat-card {
    flex: 1;
    min-width: 140px;
    background: white;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    border-left: 5px solid #1e3a5f;
}
.stat-card.stat-pending { border-left-color: #f39c12; }
.stat-card.stat-progress { border-left-color: #3498db; }
.stat-card.stat-resolved { border-left-color: #2ecc71; }
.stat-number {
    font-size: 26px;
    font-weight: bold;
    color: #1e3a5f;
    margin-top: 5px;
}
.stat-label {
    font-size: 13px;
    color: #777;
    text-transform: uppercase;
    font-weight: 600;
}
</style>

<div class="container" style="max-width: 1200px;">
    <h2>Complaint Management Dashboard</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">✅ Complaint status updated successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">❌ Error: <?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <!-- Summary Stats -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-label">Total Complaints</div>
            <div class="stat-number"><?= $counts['total']; ?></div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-label">Pending</div>
            <div class="stat-number"><?= $counts['pending']; ?></div>
        </div>
        <div class="stat-card stat-progress">
            <div class="stat-label">In Progress</div>
            <div class="stat-number"><?= $counts['progress']; ?></div>
        </div>
        <div class="stat-card stat-resolved">
            <div class="stat-label">Resolved</div>
            <div class="stat-number"><?= $counts['resolved']; ?></div>
        </div>
        <div class="stat-card" style="border-left-color: #9b59b6;">
            <div class="stat-label">Registered Users</div>
            <div class="stat-number"><?= $totalUsers; ?></div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Student Info</th>
                    <th>Category</th>
                    <th>Issue Description</th>
                    <th>Current Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                            $statusBadge = 'badge-pending';
                            if ($row['status'] === 'In Progress') $statusBadge = 'badge-progress';
                            if ($row['status'] === 'Resolved') $statusBadge = 'badge-resolved';
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['complaint_id']); ?></strong></td>
                            <td style="white-space:nowrap; font-size:12px; color:#666;">
                                <?= date('d M Y', strtotime($row['created_at'])); ?><br>
                                <?= date('h:i A', strtotime($row['created_at'])); ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['full_name']); ?></strong><br>
                                <small style="color:#555;">ID: <?= htmlspecialchars($row['student_id']); ?></small><br>
                                <small><a href="mailto:<?= htmlspecialchars($row['email']); ?>" style="color:#1d6fa5; text-decoration:none;"><?= htmlspecialchars($row['email']); ?></a></small>
                            </td>
                            <td><?= htmlspecialchars($row['category']); ?></td>
                            <td style="max-width: 280px; word-wrap: break-word;">
                                <?= nl2br(htmlspecialchars($row['issue'])); ?>
                            </td>
                            <td>
                                <span class="badge <?= $statusBadge ?>"><?= htmlspecialchars($row['status']); ?></span>
                            </td>
                            <td>
                                <form action="update_status.php" method="POST" style="display:flex; align-items:center; margin:0;">
                                    <input type="hidden" name="id" value="<?= (int)$row['id']; ?>">
                                    <select name="status">
                                        <option value="Pending" <?= ($row['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="In Progress" <?= ($row['status'] === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="Resolved" <?= ($row['status'] === 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                                    </select>
                                    <button type="submit">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 25px; color:#777;">
                            No complaints submitted yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$conn->close();
include __DIR__ . '/../includes/footer.php';
?>
