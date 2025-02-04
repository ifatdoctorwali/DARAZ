<?php
session_start();
require 'db.php'; // Make sure this file contains your PDO connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            // After signup, redirect to login page
            header("Location: login.php");
            exit();
        } else {
            $error = "There was a problem signing up. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
        form input[type="text"],
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
            background: #28a745;
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
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <?php if(isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="signup.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Signup">
        </form>
        <div class="link">
            Already have an account? <a href="login.php">Login here</a>.
        </div>
    </div>
</body>
</html>
