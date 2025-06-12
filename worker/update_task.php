<?php
include '../includes/db.php';

// Start session only if not already active.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only workers can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: ../login.php");
    exit();
}

// Retrieve the task based on the passed ID.
$task_id = $_GET['id'];
$sql = "SELECT * FROM tasks WHERE id = $task_id AND assigned_to = " . $_SESSION['user_id'];
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Task not found or you do not have permission to update this task.";
    exit();
}

$task = $result->fetch_assoc();

// Define upload directory and create it if it doesn't exist.
$uploadDir = "../uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    
    // Retain current photo paths if no new files are uploaded.
    $before_photo = $task['before_photo'];
    $after_photo  = $task['after_photo'];

    // Upload Before Photo
    if (isset($_FILES['before_photo']) && $_FILES['before_photo']['error'] == 0) {
        $before_photo_name = basename($_FILES['before_photo']['name']);
        $targetBefore = $uploadDir . time() . "_before_" . $before_photo_name;
        if (move_uploaded_file($_FILES['before_photo']['tmp_name'], $targetBefore)) {
            $before_photo = $targetBefore;
        } else {
            echo "Error uploading before photo.";
        }
    }
    
    // Upload After Photo
    if (isset($_FILES['after_photo']) && $_FILES['after_photo']['error'] == 0) {
        $after_photo_name = basename($_FILES['after_photo']['name']);
        $targetAfter = $uploadDir . time() . "_after_" . $after_photo_name;
        if (move_uploaded_file($_FILES['after_photo']['tmp_name'], $targetAfter)) {
            $after_photo = $targetAfter;
        } else {
            echo "Error uploading after photo.";
        }
    }

    // Update the task record with new status and photo paths.
    $sql_update = "UPDATE tasks SET status = ?, before_photo = ?, after_photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssi", $status, $before_photo, $after_photo, $task_id);

    if ($stmt->execute()) {
        echo "Task updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Task</title>
    <style>
        /* styles.css */

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f9;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h2 {
    margin-top: 30px;
    font-size: 28px;
    color: #2c3e50;
}

form {
    background-color: #fff;
    padding: 25px 35px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 500px;
    margin-top: 20px;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #34495e;
}

select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    transition: border 0.3s ease;
}

select:focus,
input[type="file"]:focus {
    outline: none;
    border-color: #2980b9;
}

button {
    margin-top: 20px;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    background-color: #3498db;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}

a {
    margin-top: 20px;
    display: inline-block;
    text-decoration: none;
    color: #3498db;
    font-weight: 500;
    transition: color 0.2s ease;
}

a:hover {

    </style>
</head>
<body>
    <h2>Update Task: <?php echo htmlspecialchars($task['title']); ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="pending" <?php if($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
            <option value="in-progress" <?php if($task['status'] == 'in-progress') echo 'selected'; ?>>In Progress</option>
            <option value="completed" <?php if($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
        </select>
        <br><br>
        <label for="before_photo">Before Cleaning Photo:</label>
        <input type="file" name="before_photo" id="before_photo" accept="image/*">
        <br><br>
        <label for="after_photo">After Cleaning Photo:</label>
        <input type="file" name="after_photo" id="after_photo" accept="image/*">
        <br><br>
        <button type="submit">Update Task</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
