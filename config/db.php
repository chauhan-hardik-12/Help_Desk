<?php
// config/db.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "student_helpdesk";

try {
    // Connect to MySQL server
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    // Auto-create database if it doesn't exist
    $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db($dbname);

    // Auto-create complaints table if it doesn't exist
    $createTableSql = "CREATE TABLE IF NOT EXISTS `complaints` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `complaint_id` VARCHAR(50) NOT NULL UNIQUE,
        `full_name` VARCHAR(150) NOT NULL,
        `email` VARCHAR(150) NOT NULL,
        `student_id` VARCHAR(50) NOT NULL,
        `category` VARCHAR(100) NOT NULL,
        `issue` TEXT NOT NULL,
        `status` ENUM('Pending', 'In Progress', 'Resolved') NOT NULL DEFAULT 'Pending',
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $conn->query($createTableSql);
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("<div style='font-family: Arial, sans-serif; padding: 25px; background: #fff2f2; border: 1px solid #ffcccc; border-radius: 8px; max-width: 650px; margin: 40px auto; color: #a94442;'>
            <h3 style='margin-top:0;'>⚠️ Database Connection / Setup Error</h3>
            <p>Could not connect to or initialize the database. Please ensure MySQL is running in your XAMPP Control Panel.</p>
            <p style='background:#fff; padding:10px; border-radius:4px; font-family: monospace; font-size:13px; color:#333;'>" . htmlspecialchars($e->getMessage()) . "</p>
         </div>");
}
?>
