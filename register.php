<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<p class='error'>Error: Email already exists. Please use a different email.</p>";
    } else {
        // Insert new user if email does not exist
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            echo "<p class='success'>Registration successful! <a href='index.php'>Login here</a></p>";
        } else {
            echo "<p class='error'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        input, select {
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
        }

        .success {
            color: green;
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
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="worker">Worker</option>
                <option value="resident">Resident</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <div class="links">
            <a href="index.php">Already have an account? Login</a>
            <br>
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
