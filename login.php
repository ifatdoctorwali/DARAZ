<?php
session_start();
require 'db.php'; // Ensure this file sets up your PDO connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        // Fetch the user from the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variable and redirect to dashboard
            $_SESSION['user'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #e2e2e2;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 350px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        form label {
            display: block;
            margin-top: 10px;
        }
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if(isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Login">
        </form>
        <div class="link">
            Don't have an account? <a href="signup.php">Signup here</a>.
        </div>
    </div>
</body>
</html>
