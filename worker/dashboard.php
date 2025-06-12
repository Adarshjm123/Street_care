<?php
include '../includes/db.php';  // Include your database connection file
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: ../login.php");
    exit();
}

$worker_id = $_SESSION['user_id'];

// Retrieve tasks assigned to the logged-in worker.
$sql = "SELECT * FROM tasks WHERE assigned_to = $worker_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Worker Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
/* styles.css */

/* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #2c3e50, #4ca1af);
    color: white;
    text-align: center;
    padding: 20px;
}

/* Headings */
h2, h3 {
    color: #ffeb3b;
    margin-bottom: 10px;
}

/* Task Container */
.container {
    background: rgba(255, 255, 255, 0.15);
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
    margin: auto;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
}

.container:hover {
    transform: scale(1.03);
}

/* Task List */
ul {
    list-style: none;
    padding: 0;
}

li {
    background: rgba(255, 255, 255, 0.2);
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    transition: background 0.3s ease;
}

li:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Buttons & Links */
a {
    display: inline-block;
    text-decoration: none;
    color: white;
    background: #ff9800;
    padding: 10px 15px;
    margin-top: 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

a:hover {
    background: #e67e22;
}

a[href="../logout.php"] {
    background: #e74c3c;
}

a[href="../logout.php"]:hover {
    background: #c0392b;
}

    </style>
</head>
<body>
    <h2>Welcome Worker</h2>
    <h3>Your Tasks</h3>
    <?php if ($result->num_rows > 0): ?>
        <ul>
        <?php while($task = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo $task['title']; ?></strong> - <?php echo ucfirst($task['status']); ?>
                <br>
                <a href="update_task.php?id=<?php echo $task['id']; ?>">Update Task</a>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No tasks assigned.</p>
    <?php endif; ?>
    <br>
    <a href="../logout.php">Logout</a>
</body>
</html>
