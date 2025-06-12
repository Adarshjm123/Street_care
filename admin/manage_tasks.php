<?php
include '../includes/db.php';
session_start();

// Ensure only admins can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Retrieve tasks with worker names (if assigned).
$sql = "SELECT t.*, u.name AS worker_name 
        FROM tasks t 
        LEFT JOIN users u ON t.assigned_to = u.id
        ORDER BY t.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .task-photos img {
            width: 80px;
            height: auto;
            margin-right: 5px;
        }
        nav {
            background-color: #333;
            padding: 10px;
            color: #fff;
        }
        nav a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="assign_task.php">Assign Task</a>
        <a href="view_feedback.php">View Feedback</a>
        <a href="manage_tasks.php">Manage Tasks</a>
        <a href="../logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Manage Tasks</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task Title</th>
                        <th>Description</th>
                        <th>Assigned Worker</th>
                        <th>Status</th>
                        <th>Photos</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($task = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $task['id']; ?></td>
                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                            <td><?php echo htmlspecialchars($task['description']); ?></td>
                            <td><?php echo $task['worker_name'] ? htmlspecialchars($task['worker_name']) : "Not Assigned"; ?></td>
                            <td><?php echo ucfirst($task['status']); ?></td>
                            <td class="task-photos">
                                <?php if (!empty($task['before_photo'])): ?>
                                    <a href="<?php echo $task['before_photo']; ?>" target="_blank">
                                        <img src="<?php echo $task['before_photo']; ?>" alt="Before">
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($task['after_photo'])): ?>
                                    <a href="<?php echo $task['after_photo']; ?>" target="_blank">
                                        <img src="<?php echo $task['after_photo']; ?>" alt="After">
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $task['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tasks available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
