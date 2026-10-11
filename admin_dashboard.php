<?php
// Root admin_dashboard.php - redirects to admin/dashboard.php for backward compatibility
header("Location: admin/dashboard.php" . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit();
?>