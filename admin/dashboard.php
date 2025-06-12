<?php
include '../includes/db.php';
session_start();

// Ensure only admins can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
/* Styling for the admin dashboard navigation with transitions */
nav {
    background-color: #222;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}
/* Admin Dashboard Title Styling */
h1 {
    text-align: center;
    font-size: 32px;
    font-weight: bold;
    color: #222;
    margin-top: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
}

/* Hover effect to make it more interactive */
h1:hover {
    color: #f39c12;
    transform: scale(1.05);
}

nav:hover {
    background-color: #1a1a1a;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
}

nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
    transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

nav a:hover {
    color: #f39c12;
    transform: scale(1.1);
}

/* Styling for the dashboard container */
.container {
    margin: 30px auto;
    max-width: 1100px;
    padding: 25px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.container:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-3px);
}

/* Centered and well-spaced heading */
h2 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: color 0.3s ease-in-out;
}

h2:hover {
    color: #f39c12;
}

    </style>
</head>
<body>
    <nav>
    <span style="color: white; font-weight: bold;">Admin Dashboard</span>


        <a href="assign_task.php">Assign Task</a>
        <a href="view_feedback.php">View Feedback</a>
        <a href="manage_tasks.php">Manage Tasks</a>
        <a href="../logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <p>This dashboard allows you to oversee the operations of the Street Care Portal. Use the navigation menu above to:</p>
        <ul>
    <li><span style="font-weight: bold; color: #ffc107;">Assign Tasks:</span> Efficiently distribute and manage cleaning assignments for workers.</li>
    <li><span style="font-weight: bold; color: #17a2b8;">View Feedback:</span> Analyze reports and concerns submitted by residents.</li>
    <li><span style="font-weight: bold; color: #28a745;">Manage Tasks:</span> Monitor task completion and review uploaded progress photos.</li>
</ul>

    </div>
</body>
</html>

