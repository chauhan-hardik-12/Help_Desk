<?php
// includes/navbar.php - Navigation Bar
if (!isset($currentPage)) $currentPage = "";
if (!isset($basePath)) $basePath = "";
?>
<nav>
    <a href="<?= $basePath; ?>index.php" class="<?= $currentPage === 'home' ? 'active' : ''; ?>">Home</a>
    <a href="<?= $basePath; ?>about.php" class="<?= $currentPage === 'about' ? 'active' : ''; ?>">About</a>
    <a href="<?= $basePath; ?>complaint.php" class="<?= $currentPage === 'complaint' ? 'active' : ''; ?>">Complaint</a>
    <a href="<?= $basePath; ?>status.php" class="<?= $currentPage === 'status' ? 'active' : ''; ?>">Status</a>
    <a href="<?= $basePath; ?>contact.php" class="<?= $currentPage === 'contact' ? 'active' : ''; ?>">Contact</a>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
        <a href="<?= $basePath; ?>admin/dashboard.php" class="admin-nav-link <?= $currentPage === 'admin' ? 'active' : ''; ?>">Admin Panel</a>
    <?php endif; ?>
    <button onclick="logout('<?= $basePath; ?>logout.php')" class="log">Logout</button>
</nav>
