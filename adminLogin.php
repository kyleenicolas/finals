<?php
require 'db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['admin_id'];
        header("Location: adminPage.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Cool Gradient Background */
    body {
      height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      font-family: Arial, sans-serif;
    }

    /* Card Styling */
    .login-card {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      padding: 20px;
      transition: transform 0.2s ease-in-out;
      width: 100%;
      max-width: 400px;
    }

    /* Card Hover Animation */
    .login-card:hover {
      transform: translateY(-5px);
    }

    /* Login Form Header */
    .login-card h3 {
      text-align: center;
      margin-bottom: 15px;
      color: #333;
    }

    /* Input Fields */
    input[type="text"],
    input[type="password"] {
      border: 1px solid #6a11cb;
      border-radius: 8px;
      transition: border-color 0.2s ease-in-out;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #2575fc;
      outline: none;
    }

    /* Button with cool hover effects */
    .btn-primary {
      background: linear-gradient(90deg, #6a11cb, #2575fc);
      border: none;
      color: white;
      font-size: 16px;
      padding: 10px 0;
      transition: transform 0.2s ease, background 0.3s ease;
      border-radius: 8px;
    }

    .btn-primary:hover {
      transform: scale(1.1);
      background: linear-gradient(90deg, #2575fc, #6a11cb);
    }

    /* Error Message */
    .alert {
      font-size: 14px;
      color: #d9534f;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .login-card {
        max-width: 90%;
      }
    }
  </style>
</head>

<body>
  <div class="login-card">
    <!-- Form Title -->
    <h3>Welcome Admin 👋</h3>
    <p class="text-muted text-center">Login to your control panel</p>

    <!-- Error Message -->
    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <!-- Register Prompt -->
    <div class="text-center mt-3">
      <small>Not yet registered? <a href="adminReg.php" style="color: #2575fc;">Register here</a></small>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
