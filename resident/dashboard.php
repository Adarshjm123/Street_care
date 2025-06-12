<?php
include '../includes/db.php';

// Start session only if not already active.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only residents can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: ../login.php");
    exit();
}

// Optionally, you can retrieve resident-specific data here if needed.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resident Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Inline styles for demonstration; move to your CSS file if desired */
        nav {
            background-color: #333;
            padding: 10px;
            color: #fff;
            text-align: center;
        }
        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="report_issue.php">Report Issue</a>
        <a href="view_feedback.php">View My Feedback</a>
        <a href="../logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Welcome, Resident!</h2>
        <p>This is your dashboard for reporting issues and providing feedback regarding street care operations.</p>
        <p>Use the links above to submit a new report or view your previous submissions.</p>
    </div>
</body>
</html>

