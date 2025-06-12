<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Street Care Operation Portal</title>
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
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="nav">
        <a href="admin/login.php">Admin Login</a>
        <a href="worker/login.php">Worker Login</a>
        <a href="resident/login.php">Resident Login</a>
    </div>
    <div class="container">
        <h1 class="header">Welcome to Street Care Operation Portal</h1>
        <p class="sub-header">A platform for municipal cleaning operations.</p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>You are logged in as <strong><?php echo $_SESSION['role']; ?></strong>.</p>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin/dashboard.php" class="login-btn">Go to Admin Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'worker'): ?>
                <a href="worker/dashboard.php" class="login-btn">Go to Worker Dashboard</a>
            <?php else: ?>
                <a href="resident/dashboard.php" class="login-btn">Go to Resident Dashboard</a>
            <?php endif; ?>
            <a href="logout.php" class="login-btn logout">Logout</a>
        <?php else: ?>
           
        <?php endif; ?>
    </div>
</body>
</html>
