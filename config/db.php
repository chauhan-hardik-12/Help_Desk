<?php
// config/db.php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "student_helpdesk";

try {
    // On localhost (XAMPP), connect and auto-create the database if needed.
    // On shared hosts like InfinityFree, connect directly to $dbname since CREATE DATABASE is restricted.
    if ($servername === "localhost" || $servername === "127.0.0.1") {
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error);
        }
        $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $conn->select_db($dbname);
    } else {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error);
        }
    }

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

    // Auto-create users table if it doesn't exist
    $createUsersTableSql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `full_name` VARCHAR(150) NOT NULL,
        `username` VARCHAR(100) NOT NULL UNIQUE,
        `email` VARCHAR(150) NOT NULL UNIQUE,
        `student_id` VARCHAR(50) NULL,
        `password` VARCHAR(255) NOT NULL,
        `role` ENUM('student', 'admin') NOT NULL DEFAULT 'student',
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $conn->query($createUsersTableSql);

    // Seed single admin account if users table is empty
    $checkUsers = $conn->query("SELECT COUNT(*) AS total FROM `users`");
    if ($checkUsers) {
        $userCount = (int)$checkUsers->fetch_assoc()['total'];
        if ($userCount === 0) {
            $defaultPasswordHash = password_hash("1234", PASSWORD_DEFAULT);
            $seedStmt = $conn->prepare("INSERT INTO `users` (`full_name`, `username`, `email`, `student_id`, `password`, `role`) VALUES (?, ?, ?, ?, ?, ?)");
            if ($seedStmt) {
                // Single Admin Account
                $adminName = "Administrator";
                $adminUser = "admin";
                $adminEmail = "admin@helpdesk.com";
                $adminId = "ADMIN-001";
                $adminRole = "admin";
                $seedStmt->bind_param("ssssss", $adminName, $adminUser, $adminEmail, $adminId, $defaultPasswordHash, $adminRole);
                $seedStmt->execute();
                $seedStmt->close();
            }
        }
    }

    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("<div style='font-family: Arial, sans-serif; padding: 25px; background: #fff2f2; border: 1px solid #ffcccc; border-radius: 8px; max-width: 650px; margin: 40px auto; color: #a94442;'>
            <h3 style='margin-top:0;'>⚠️ Database Connection / Setup Error</h3>
            <p>Could not connect to or initialize the database. Please ensure MySQL is running in your XAMPP Control Panel.</p>
            <p style='background:#fff; padding:10px; border-radius:4px; font-family: monospace; font-size:13px; color:#333;'>" . htmlspecialchars($e->getMessage()) . "</p>
         </div>");
}
?>
