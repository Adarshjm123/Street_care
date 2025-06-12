<?php
include '../includes/db.php';
session_start();

// Ensure only admins can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Retrieve list of workers.
$sql = "SELECT id, name FROM users WHERE role='worker'";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    // Insert the new task into the tasks table.
    $sql_insert = "INSERT INTO tasks (title, description, assigned_to) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssi", $title, $description, $assigned_to);

    if ($stmt->execute()) {
        echo "Task assigned successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Task</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* General Styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #f7f7f7, #e3f2fd); /* Light blue gradient */
    color: #333;
    text-align: center;
    padding: 20px;
}

/* Container */
.container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
    margin: auto;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.container:hover {
    transform: scale(1.02);
}

/* Headings */
h2 {
    color: #0277bd;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

input, textarea, select {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border 0.3s ease, transform 0.2s ease;
}

input:focus, textarea:focus, select:focus {
    border-color: #0277bd;
    transform: scale(1.02);
}

/* Button Styling */
button {
    background: #ff9800;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

button:hover {
    background: #e65100;
    transform: scale(1.05);
}

/* Dashboard Link */
a {
    display: inline-block;
    text-decoration: none;
    color: white;
    background: #4caf50;
    padding: 10px 15px;
    margin-top: 10px;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
}

a:hover {
    background: #2e7d32;
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <h2>Assign Task</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Task Title" required>
        <textarea name="description" placeholder="Task Description" required></textarea>
        <select name="assigned_to" required>
            <option value="">Select Worker</option>
            <?php while($worker = $result->fetch_assoc()): ?>
                <option value="<?php echo $worker['id']; ?>"><?php echo $worker['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Assign Task</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
