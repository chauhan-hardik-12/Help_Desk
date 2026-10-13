<?php
// includes/navbar.php - Navigation Bar
require_once __DIR__ . '/auth.php';

if (!isset($currentPage)) $currentPage = "";
if (!isset($basePath)) $basePath = "";
$user = current_user();
?>
<nav>
    <a href="<?= $basePath; ?>index.php" class="<?= $currentPage === 'home' ? 'active' : ''; ?>">Home</a>
    <a href="<?= $basePath; ?>about.php" class="<?= $currentPage === 'about' ? 'active' : ''; ?>">About</a>
    <a href="<?= $basePath; ?>complaint.php" class="<?= $currentPage === 'complaint' ? 'active' : ''; ?>">Complaint</a>
    <a href="<?= $basePath; ?>status.php" class="<?= $currentPage === 'status' ? 'active' : ''; ?>">Status</a>
    <a href="<?= $basePath; ?>contact.php" class="<?= $currentPage === 'contact' ? 'active' : ''; ?>">Contact</a>
    <?php if (is_admin()): ?>
        <a href="<?= $basePath; ?>admin/dashboard.php" class="admin-nav-link <?= $currentPage === 'admin' ? 'active' : ''; ?>">Admin Panel</a>
    <?php endif; ?>

    <?php if (is_logged_in()): ?>
        <span class="user-pill">
            👤 <?= htmlspecialchars($user['full_name'] ?? $user['username'] ?? 'User'); ?>
            <span class="role-badge"><?= ucfirst(htmlspecialchars($user['role'] ?? 'user')); ?></span>
        </span>
        <button onclick="logout('<?= $basePath; ?>logout.php')" class="log">Logout</button>
    <?php else: ?>
        <a href="<?= $basePath; ?>login.php" class="<?= $currentPage === 'login' ? 'active' : ''; ?>">Login</a>
        <a href="<?= $basePath; ?>register.php" class="<?= $currentPage === 'register' ? 'active' : ''; ?>">Register</a>
    <?php endif; ?>
</nav>
