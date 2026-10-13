<?php
// register.php - Student Registration (Students only; Admin is single and system-managed)
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/db.php';

// Redirect if already logged in
if (is_admin()) {
    header("Location: admin/dashboard.php");
    exit();
} elseif (is_logged_in()) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

// Retain form inputs on validation error
$formFullName  = "";
$formUsername  = "";
$formEmail     = "";
$formStudentId = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullName        = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
    $username        = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email           = isset($_POST['email']) ? trim($_POST['email']) : '';
    $studentId       = isset($_POST['studentId']) ? trim($_POST['studentId']) : '';
    $password        = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    $formFullName  = $fullName;
    $formUsername  = $username;
    $formEmail     = $email;
    $formStudentId = $studentId;

    // Fixed role: web registration is strictly for students (only 1 admin exists)
    $role = 'student';

    // Validation
    if (empty($fullName) || empty($username) || empty($email) || empty($studentId) || empty($password) || empty($confirmPassword)) {
        $error = "Please fill in all required fields.";
    } elseif (mb_strlen($fullName) < 3) {
        $error = "Full Name must be at least 3 characters long.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $error = "Username must be 3-30 characters and contain only letters, numbers, and underscores.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!preg_match('/^\d{12}$/', $studentId)) {
        $error = "Student ID must be exactly 12 digits (numbers only).";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match. Please re-enter.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username '" . htmlspecialchars($username) . "' is already taken. Please choose another.";
            $stmt->close();
        } else {
            $stmt->close();

            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "An account with email '" . htmlspecialchars($email) . "' already exists.";
                $stmt->close();
            } else {
                $stmt->close();

                // Hash password securely with bcrypt
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert new student user
                $insertStmt = $conn->prepare("INSERT INTO users (full_name, username, email, student_id, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                if ($insertStmt) {
                    $insertStmt->bind_param("ssssss", $fullName, $username, $email, $studentId, $hashedPassword, $role);
                    if ($insertStmt->execute()) {
                        $insertStmt->close();
                        $conn->close();
                        header("Location: login.php?registered=1");
                        exit();
                    } else {
                        $error = "Registration failed due to a database error: " . $insertStmt->error;
                        $insertStmt->close();
                    }
                } else {
                    $error = "Database error: " . $conn->error;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<meta name="description" content="Academic Web Development Demo Project - Student Help Desk Registration">
<title>Student Help Desk - Registration (Demo Project)</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body {
    margin: 0;
    padding: 20px 10px;
    font-family: Arial, sans-serif;
    background: #1e3a5f;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
}

.auth-box {
    background: white;
    padding: 35px 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    text-align: left;
    box-sizing: border-box;
}

.auth-box h2 {
    margin-top: 0;
    margin-bottom: 6px;
    color: #1e3a5f;
    text-align: center;
}

.auth-box p.subtitle {
    color: #666;
    font-size: 14px;
    margin-bottom: 14px;
    text-align: center;
}

.demo-banner {
    background: #eef6fc;
    color: #1e3a5f;
    border: 1px solid #b8daff;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 12px;
    margin-bottom: 16px;
    text-align: center;
    line-height: 1.4;
}

.form-group {
    margin-bottom: 14px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    font-size: 13px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: 0.3s;
    font-family: inherit;
}

.form-group input:focus {
    outline: none;
    border-color: #1d6fa5;
    box-shadow: 0 0 5px rgba(29, 111, 165, 0.4);
}

.auth-box button[type="submit"] {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: #1d6fa5;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.auth-box button[type="submit"]:hover {
    background: #155d8b;
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #555;
    border-top: 1px solid #eee;
    padding-top: 15px;
}

.auth-footer a {
    color: #1d6fa5;
    text-decoration: none;
    font-weight: bold;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.error-alert {
    background: #ffe6e6;
    color: #d63031;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 16px;
    border: 1px solid #fab1a0;
}

.hint-text {
    font-size: 12px;
    color: #777;
    margin-top: 3px;
}
</style>
</head>
<body>

<div class="auth-box">
    <h2>Student Registration</h2>
    <p class="subtitle">Create an account to submit and track complaints</p>
    <div class="demo-banner">
        ℹ️ <strong>Academic Demo Project:</strong> Use a sample password for testing. Do not reuse real passwords.
    </div>

    <?php if(!empty($error)): ?>
        <div class="error-alert">⚠️ <?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" id="registerForm" onsubmit="return validateRegisterForm()">
        <div class="form-group">
            <label for="fullName">Full Name <span style="color:#d63031;">*</span></label>
            <input type="text" name="fullName" id="fullName" placeholder="e.g. John Doe"
                   value="<?= htmlspecialchars($formFullName); ?>" required autofocus>
            <div id="fullNameError" class="error"></div>
        </div>

        <div class="form-group">
            <label for="username">Username <span style="color:#d63031;">*</span></label>
            <input type="text" name="username" id="username" placeholder="Choose a unique username"
                   value="<?= htmlspecialchars($formUsername); ?>" required>
            <div class="hint-text">3-30 characters (letters, numbers, underscores)</div>
            <div id="usernameError" class="error"></div>
        </div>

        <div class="form-group">
            <label for="email">Email Address <span style="color:#d63031;">*</span></label>
            <input type="email" name="email" id="email" placeholder="name@example.com"
                   value="<?= htmlspecialchars($formEmail); ?>" required>
            <div id="emailError" class="error"></div>
        </div>

        <div class="form-group">
            <label for="studentId">Student ID (12 digits) <span style="color:#d63031;">*</span></label>
            <input type="text" name="studentId" id="studentId" placeholder="Enter 12-digit Student ID"
                   maxlength="12" value="<?= htmlspecialchars($formStudentId); ?>" required>
            <div class="hint-text">Must be exactly 12 numeric digits</div>
            <div id="studentIdError" class="error"></div>
        </div>

        <div class="form-group">
            <label for="password">Password <span style="color:#d63031;">*</span></label>
            <input type="password" name="password" id="password" placeholder="At least 6 characters" autocomplete="new-password" required>
            <div id="passwordError" class="error"></div>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm Password <span style="color:#d63031;">*</span></label>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Re-enter password" autocomplete="new-password" required>
            <div id="confirmPasswordError" class="error"></div>
        </div>

        <button type="submit">Register Account</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="login.php">Login here</a>
        <div style="margin-top: 10px;">
            <a href="index.php">&larr; Back to Home</a>
        </div>
    </div>
</div>

<script>
function validateRegisterForm() {
    var nameEl     = document.getElementById("fullName");
    var userEl     = document.getElementById("username");
    var emailEl    = document.getElementById("email");
    var idEl       = document.getElementById("studentId");
    var passEl     = document.getElementById("password");
    var confirmEl  = document.getElementById("confirmPassword");

    var name    = nameEl ? nameEl.value.trim() : "";
    var user    = userEl ? userEl.value.trim() : "";
    var email   = emailEl ? emailEl.value.trim() : "";
    var id      = idEl ? idEl.value.trim() : "";
    var pass    = passEl ? passEl.value : "";
    var confirm = confirmEl ? confirmEl.value : "";

    var errorFields = ["fullNameError", "usernameError", "emailError", "studentIdError", "passwordError", "confirmPasswordError"];
    errorFields.forEach(function(eid) {
        var el = document.getElementById(eid);
        if (el) el.textContent = "";
    });

    var valid = true;
    var firstBad = null;

    if (!name || name.length < 3) {
        document.getElementById("fullNameError").textContent = "Name must be at least 3 characters.";
        valid = false;
        if (!firstBad) firstBad = nameEl;
    }

    var userRegex = /^[a-zA-Z0-9_]{3,30}$/;
    if (!user || !userRegex.test(user)) {
        document.getElementById("usernameError").textContent = "Username must be 3-30 letters, numbers, or underscores.";
        valid = false;
        if (!firstBad) firstBad = userEl;
    }

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
        document.getElementById("emailError").textContent = "Please enter a valid email address.";
        valid = false;
        if (!firstBad) firstBad = emailEl;
    }

    if (!id || !/^\d{12}$/.test(id)) {
        document.getElementById("studentIdError").textContent = "Student ID must be exactly 12 digits.";
        valid = false;
        if (!firstBad) firstBad = idEl;
    }

    if (!pass || pass.length < 6) {
        document.getElementById("passwordError").textContent = "Password must be at least 6 characters.";
        valid = false;
        if (!firstBad) firstBad = passEl;
    }

    if (pass !== confirm) {
        document.getElementById("confirmPasswordError").textContent = "Passwords do not match.";
        valid = false;
        if (!firstBad) firstBad = confirmEl;
    }

    if (!valid && firstBad) {
        firstBad.focus();
    }

    return valid;
}
</script>

</body>
</html>
