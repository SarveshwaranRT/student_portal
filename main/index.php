<?php
// Start the session
session_start();

// Include the session timeout script to manage inactivity
include('session_timeout.php');  // You need to create this file as per the previous discussion

include 'db_config.php';  // Connect to your database

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

$student_id = $_SESSION['id'];  // Get the student id from session

// Handle Task Submission (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    if (!empty($title)) {
        $stmt = $mysqli->prepare("INSERT INTO tasks (student_id, title) VALUES (?, ?)");
        $stmt->bind_param("is", $student_id, $title);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Task Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task_id'])) {
    $delete_id = intval($_POST['delete_task_id']);
    $stmt = $mysqli->prepare("DELETE FROM tasks WHERE id = ? AND student_id = ?");
    $stmt->bind_param("ii", $delete_id, $student_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch Tasks
$tasks = [];
$stmt = $mysqli->prepare("SELECT * FROM tasks WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Portal - To-Do List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="register.html">Register</a></li>
      <li><a href="view.html">View Students</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <h1>Welcome to the Student Portal</h1>
  <p>This portal helps manage student information effectively.</p>

  <hr>

  <h2>Your To-Do List</h2>

  <!-- Add Task Form -->
  <form action="index.php" method="POST">
    <input type="text" name="title" placeholder="Enter a task..." required>
    <button type="submit">Add Task</button>
  </form>

  <!-- Tasks List with Delete Option -->
  <ul id="task-list">
    <?php foreach ($tasks as $task): ?>
      <li>
        <?= htmlspecialchars($task['title']) ?>
        <form action="index.php" method="POST" style="display:inline;">
          <input type="hidden" name="delete_task_id" value="<?= $task['id'] ?>">
          <button type="submit" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>

</body>
</html>
