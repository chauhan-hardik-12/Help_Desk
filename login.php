<?php
// login.php - User and Admin Authentication
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

// Check for registration success flash message
if (isset($_GET['registered']) && $_GET['registered'] === '1') {
    $success = "Registration successful! You can now log in with your credentials.";
}

$loginIdentifier = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $loginIdentifier = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password        = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($loginIdentifier) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {
        // Query user by either username or email
        $stmt = $conn->prepare("SELECT id, full_name, username, email, student_id, password, role FROM users WHERE username = ? OR email = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("ss", $loginIdentifier, $loginIdentifier);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                // Verify bcrypt password hash
                $isPasswordValid = password_verify($password, $user['password']) || ($password === $user['password']);

                if ($isPasswordValid) {
                    session_regenerate_id(true);

                    $_SESSION['user_id']    = (int)$user['id'];
                    $_SESSION['username']   = $user['username'];
                    $_SESSION['full_name']  = $user['full_name'];
                    $_SESSION['email']      = $user['email'];
                    $_SESSION['student_id'] = $user['student_id'];
                    $_SESSION['role']       = $user['role'];

                    if ($user['role'] === 'admin') {
                        $_SESSION['admin'] = true;
                        header("Location: admin/dashboard.php");
                        exit();
                    } else {
                        $_SESSION['user'] = true;
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $error = "Invalid username/email or password.";
                }
            } else {
                $error = "Invalid username/email or password.";
            }
            $stmt->close();
        } else {
            $error = "Database query error: " . $conn->error;
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
<meta name="description" content="Academic Web Development Demo Project - Student Help Desk Sign In">
<title>Student Help Desk - Login (Demo Project)</title>
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

.login-box {
    background: white;
    padding: 35px 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    text-align: left;
    box-sizing: border-box;
}

.login-box h2 {
    margin-top: 0;
    margin-bottom: 6px;
    color: #1e3a5f;
    text-align: center;
}

.login-box p.subtitle {
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
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    font-size: 13px;
    color: #333;
}

.login-box input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: 0.3s;
    font-family: inherit;
}

.login-box input:focus {
    outline: none;
    border-color: #1d6fa5;
    box-shadow: 0 0 5px rgba(29, 111, 165, 0.4);
}

.login-box button[type="submit"] {
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

.login-box button[type="submit"]:hover {
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

.alert-box {
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 16px;
}

.error-alert {
    background: #ffe6e6;
    color: #d63031;
    border: 1px solid #fab1a0;
}

.success-alert {
    background: #e6ffed;
    color: #27ae60;
    border: 1px solid #a3e9b8;
}
</style>
</head>
<body>

<div class="login-box">
    <h2>Student Help Desk</h2>
    <p class="subtitle">Please sign in to continue</p>
    <div class="demo-banner">
        ℹ️ <strong>Academic Demo Project:</strong> For educational demonstration only. Do not enter real institutional passwords.
    </div>

    <?php if(!empty($success)): ?>
        <div class="alert-box success-alert">✅ <?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if(!empty($error)): ?>
        <div class="alert-box error-alert">⚠️ <?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="username">Username or Email</label>
            <input type="text" name="username" id="username" placeholder="Username or email address"
                   value="<?= htmlspecialchars($loginIdentifier); ?>" autocomplete="username" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter demo password" autocomplete="current-password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="register.php">Register here</a>
        <div style="margin-top: 10px;">
            <a href="index.php">&larr; Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>