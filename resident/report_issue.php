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

$msg = "";

// Process form submission for new feedback.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    // Insert feedback using a prepared statement for security.
    $sql = "INSERT INTO feedback (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $message);
    
    if ($stmt->execute()) {
        $msg = "Feedback submitted successfully!";
    } else {
        $msg = "Error submitting feedback: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve previous feedback submitted by the resident.
$sql = "SELECT * FROM feedback WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resident Feedback</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* General Styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #f7f7f7, #e3f2fd); /* Light blue & white gradient */
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
h2, h3 {
    color: #0277bd;
}

/* Feedback Form */
textarea {
    width: 90%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

textarea:focus {
    border-color: #0288d1;
    outline: none;
}

/* Buttons */
button {
    background: #0288d1;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background: #01579b;
}

/* Previous Feedback */
ul {
    list-style: none;
    padding: 0;
}

li {
    background: #e1f5fe;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    transition: background 0.3s ease;
}

li:hover {
    background: #b3e5fc;
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
    transition: background 0.3s ease;
}

a:hover {
    background: #e65100;
}

    </style>
</head>
<body>
    <h2>Submit Feedback / Report an Issue</h2>
    <?php if ($msg): ?>
        <p><?php echo $msg; ?></p>
    <?php endif; ?>
    <form method="POST">
        <textarea name="message" placeholder="Enter your feedback or report an issue" required></textarea>
        <br>
        <button type="submit">Submit Feedback</button>
    </form>
    <br>
    <h3>Your Previous Feedback</h3>
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
