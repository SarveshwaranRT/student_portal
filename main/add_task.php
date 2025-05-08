<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$student_id = $_SESSION['user_id'];
$title = trim($_POST['title']);

if (!empty($title)) {
    $stmt = $conn->prepare("INSERT INTO tasks (student_id, title) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $title);
    $stmt->execute();
}

header("Location: index.php");
exit();
?>
