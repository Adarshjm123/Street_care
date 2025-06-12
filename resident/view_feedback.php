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

// Retrieve feedback entries for the logged-in resident.
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM feedback WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View My Feedback</title>
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

/* Feedback List */
ul {
    list-style: none;
    padding: 0;
}

li {
    background: #e1f5fe;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
}

li:hover {
    background: #b3e5fc;
    transform: scale(1.02);
}

/* Small Timestamp */
small {
    display: block;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

/* Dashboard Link */
a {
    display: inline-block;
    text-decoration: none;
    color: white;
    background: #ff9800;
    padding: 10px 15px;
    margin-top: 10px;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
}

a:hover {
    background: #e65100;
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <h2>Your Feedback</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['message']); ?>
                    <small>(<?php echo $row['created_at']; ?>)</small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have not submitted any feedback yet.</p>
    <?php endif; ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
