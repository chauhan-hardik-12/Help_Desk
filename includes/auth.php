<?php
// includes/auth.php - Session and Authentication Helpers

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if current user is logged in (either student or admin)
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) || isset($_SESSION['user']) || isset($_SESSION['admin']);
}

/**
 * Check if current user is an admin
 */
function is_admin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ||
           (isset($_SESSION['admin']) && $_SESSION['admin'] === true);
}

/**
 * Get currently authenticated user data
 */
function current_user() {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id'         => $_SESSION['user_id'] ?? null,
        'username'   => $_SESSION['username'] ?? '',
        'full_name'  => $_SESSION['full_name'] ?? ($_SESSION['username'] ?? 'User'),
        'email'      => $_SESSION['email'] ?? '',
        'student_id' => $_SESSION['student_id'] ?? '',
        'role'       => $_SESSION['role'] ?? (is_admin() ? 'admin' : 'student')
    ];
}

/**
 * Enforce login, redirect to login page if unauthenticated
 */
function require_login($redirectTo = 'login.php') {
    if (!is_logged_in()) {
        header("Location: " . $redirectTo);
        exit();
    }
}

/**
 * Enforce admin privileges, redirect to login if not admin
 */
function require_admin($redirectTo = '../login.php') {
    if (!is_admin()) {
        header("Location: " . $redirectTo);
        exit();
    }
}
?>
