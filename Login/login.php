<?php
require '../db.php'; 
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['loginUsername']);
    $password = trim($_POST['loginPassword']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../index.php");
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
    <title>Login - FindHire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fullscreen Animated Background */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Dynamic animated background */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fad0c4, #ffdde1);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            z-index: -1;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Centered login container */
        .login-card {
            max-width: 420px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;
        }

        /* Logo Styling */
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        /* Styled input fields */
        input[type="text"],
        input[type="password"] {
            border-radius: 25px;
            transition: transform 0.2s ease;
        }

        input[type="text"]:hover,
        input[type="password"]:hover {
            transform: scale(1.03);
        }

        /* Styled Button */
        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.1);
            background: linear-gradient(90deg, #2575fc, #6a11cb);
        }

        /* Additional Footer Text */
        footer {
            text-align: center;
            font-size: 14px;
            color: #555;
            padding-top: 10px;
        }

        /* Error message */
        .alert {
            margin-bottom: 20px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .login-card {
                padding: 20px;
            }

            .logo {
                width: 60px;
            }
        }
    </style>
</head>
<body>
  <!-- Animated Background -->
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="login-card">
        <div class="text-center">
            <!-- Logo Placeholder -->
            <img src="https://via.placeholder.com/100" alt="logo" class="logo">
            <h4 class="text-dark">Welcome to FindHire</h4>
            <p class="text-muted">Sign in to find exciting opportunities</p>
        </div>

        <!-- Error message -->
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="loginUsername" class="form-control text-center" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="loginPassword" class="form-control text-center" placeholder="Password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p class="mb-0">Don't have an account? <a href="register.php">Sign Up</a></p>
            <p><a href="forgot_password.php">Forgot your password?</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
