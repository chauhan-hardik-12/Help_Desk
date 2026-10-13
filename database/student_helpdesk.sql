-- Student Help Desk Database Schema
-- Database: student_helpdesk

CREATE DATABASE IF NOT EXISTS `student_helpdesk` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_helpdesk`;

-- Table structure for table `complaints`
CREATE TABLE IF NOT EXISTS `complaints` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `student_id` VARCHAR(50) NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('student', 'admin') NOT NULL DEFAULT 'student',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample seed data for demonstration
INSERT INTO `complaints` (`complaint_id`, `full_name`, `email`, `student_id`, `category`, `issue`, `status`)
VALUES 
('COMP-20261011-0001', 'Hardik Chauhan', 'hardik@example.com', '123456789012', 'Technical Issue', 'Unable to access student portal dashboard during evening hours.', 'Pending'),
('COMP-20261011-0002', 'Rahul Sharma', 'rahul@example.com', '123456789013', 'Fee Issue', 'Payment receipt was not generated after net banking transaction.', 'In Progress');

-- Default Single Admin User (Password is '1234' hashed with bcrypt)
INSERT INTO `users` (`full_name`, `username`, `email`, `student_id`, `password`, `role`)
VALUES
('Administrator', 'admin', 'admin@helpdesk.com', 'ADMIN-001', '$2y$10$wT5gWcO8u0h2oB1M8K58QOBs14m8x9N43n37rX6wWf7yXJd0x9vY.', 'admin');

