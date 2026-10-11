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

-- Sample seed data for demonstration
INSERT INTO `complaints` (`complaint_id`, `full_name`, `email`, `student_id`, `category`, `issue`, `status`)
VALUES 
('COMP-20261011-0001', 'Hardik Chauhan', 'hardik@example.com', '123456789012', 'Technical Issue', 'Unable to access student portal dashboard during evening hours.', 'Pending'),
('COMP-20261011-0002', 'Rahul Sharma', 'rahul@example.com', '123456789013', 'Fee Issue', 'Payment receipt was not generated after net banking transaction.', 'In Progress');
