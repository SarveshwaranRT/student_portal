<?php
$timeout_duration = 60; // 10 minutes

// Check if the user is logged in and session activity is set
if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];

    if ($inactive_time > $timeout_duration) {
        session_unset();              // Clear session data
        session_destroy();           // End session
        header("Location: login.php?message=Session expired. Please login again.");
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>

