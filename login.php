<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] == 'worker') {
                header("Location: worker/dashboard.php");
            } else {
                header("Location: resident/dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
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
        /* Background Styling */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
        }

        /* Glassmorphism Card */
        .form-container {
            width: 350px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 5px 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.05);
        }

        h2 {
            color: white;
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            outline: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
        }

        button {
            width: 100%;
            padding: 10px;
            background: #573b8a;
            color: white;
            font-size: 1em;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        button:hover {
            background: #6d44b8;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .links {
            margin-top: 10px;
        }

        .links a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <div class="links">
            <a href="register.php">Don't have an account? Register</a>
            <br>
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
