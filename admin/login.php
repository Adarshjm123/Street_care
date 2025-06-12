<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Please fill in both fields.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = 'admin'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'admin';
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No admin found with that email.";
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
    <title>Admin Login</title>
    <style>
       body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Jost', sans-serif;
    background: url('https://media.istockphoto.com/id/916291672/photo/indian-women-cleaning-road-in-the-street.jpg?s=612x612&w=0&k=20&c=qWEwLDOVEjpQsZz5m3R6jviuJz6Z8FB7QXR3av2K9vc=') no-repeat center center/cover;
    background-size: cover;
    position: relative;
    color: white;
}

.main {
    width: 350px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    font-size: 1.8em;
    color: #fff;
}

input {
    width: 100%;
    height: 45px;
    margin: 10px 0;
    padding: 12px;
    border: none;
    border-radius: 8px;
    outline: none;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 1em;
    transition: 0.3s;
}

input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

input:focus {
    background: rgba(255, 255, 255, 0.3);
}

button {
    width: 100%;
    height: 45px;
    margin-top: 15px;
    border: none;
    border-radius: 8px;
    background: #ff7b00;
    color: white;
    font-size: 1.1em;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #e66a00;
}

.back-home {
    display: block;
    margin-top: 15px;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 1em;
    transition: 0.3s;
}

.back-home:hover {
    color: #ff7b00;
}
    </style>
</head>
<body>

    <div class="main">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your Email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="../register.php" class="back-home">Register</a>
        <a href="../index.php" class="back-home">Back to Home</a>
    </div>

</body>
</html>
