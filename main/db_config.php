<?php
// Database configuration file (db_config.php)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_portal";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
