<?php
require_once __DIR__ . '/includes/auth.php';

// Redirect if already logged in
if (is_admin()) {
    header("Location: admin/dashboard.php");
    exit();
} elseif (is_logged_in()) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // 🔐 ADMIN LOGIN
    if ($username === "admin" && $password === "1234") {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = 'admin';
        header("Location: admin/dashboard.php");
        exit();
    }

    // 👨‍🎓 USER LOGIN
    elseif ($username === "user" && $password === "1234") {
        session_regenerate_id(true);
        $_SESSION['user'] = true;
        $_SESSION['role'] = 'user';
        $_SESSION['username'] = 'user';
        header("Location: index.php");
        exit();
    }

    else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Help Desk - Login</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background: #1e3a5f;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-box {
  background: white;
  padding: 35px 30px;
  border-radius: 12px;
  width: 100%;
  max-width: 360px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
  text-align: center;
  box-sizing: border-box;
}

.login-box h2 {
  margin-top: 0;
  margin-bottom: 8px;
  color: #1e3a5f;
}

.login-box p.subtitle {
  color: #666;
  font-size: 14px;
  margin-bottom: 20px;
}

.login-box input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  box-sizing: border-box;
  transition: 0.3s;
}

.login-box input:focus {
  outline: none;
  border-color: #1d6fa5;
  box-shadow: 0 0 5px rgba(29, 111, 165, 0.4);
}

.login-box button {
  width: 100%;
  padding: 12px;
  margin-top: 15px;
  background: #1d6fa5;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.login-box button:hover {
  background: #155d8b;
}

.error {
  background: #ffe6e6;
  color: #d63031;
  padding: 10px;
  border-radius: 6px;
  font-size: 14px;
  margin-bottom: 15px;
  border: 1px solid #fab1a0;
}
</style>
</head>
<body>

<div class="login-box">
  <h2>Student Help Desk</h2>
  <p class="subtitle">Please login to continue</p>

  <?php if(!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required autofocus>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>