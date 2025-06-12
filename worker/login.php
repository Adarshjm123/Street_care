<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Please fill in both fields.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = 'worker'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'worker';
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No worker found with that email.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://media.istockphoto.com/id/916291672/photo/indian-women-cleaning-road-in-the-street.jpg?s=612x612&w=0&k=20&c=qWEwLDOVEjpQsZz5m3R6jviuJz6Z8FB7QXR3av2K9vc=') no-repeat center center/cover;
            background-size: cover;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .header {
            font-size: 50px;
            font-weight: bold;
            color: #FFD700;
            opacity: 0;
            transform: translateX(-100%);
            animation: fadeInLeft 1.5s forwards;
        }

        .sub-header {
            font-size: 25px;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .nav {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 2;
        }

        .nav a {
            text-decoration: none;
            font-size: 18px;
            margin-left: 15px;
            color: #FFD700;
            font-weight: bold;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-form {
            background: rgba(25, 25, 25, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 2px solid #f39c12;
        }

        .login-form input {
            background-color: #333;
            color: #f1f1f1;
            border: 1px solid #f39c12;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 1em;
        }

        .login-form input:focus {
            border: 2px solid #f1c40f;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-form button:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        .back-home {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            background-color: #3498db;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-home:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h2 class="header">Worker Login</h2>
        <form method="POST" class="login-form">
            <input type="email" name="email" placeholder="Enter your Email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <button type="submit">Login</button>
            <a href="../register.php" class="back-home">Register</a>
            <a href="../index.php" class="back-home">Back to Home</a>
        </form>
    </div>
</body>
</html>