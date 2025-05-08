<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$student_id = $_SESSION['user_id'];
$task_id = $_GET['id'];

// Make sure the task belongs to the logged-in user
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND student_id = ?");
$stmt->bind_param("ii", $task_id, $student_id);
$stmt->execute();

header("Location: index.php");
exit();
?>
