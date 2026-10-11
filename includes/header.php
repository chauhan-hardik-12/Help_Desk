<?php
// includes/header.php - Site Header
if (!isset($pageTitle)) {
    $pageTitle = "Student Help Desk";
}
if (!isset($basePath)) {
    $basePath = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?= $basePath; ?>assets/css/style.css">
</head>
<body>
<header>
    <h1>Student Help Desk</h1>
</header>
