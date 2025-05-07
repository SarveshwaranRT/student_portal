<?php
// Sanitize data received from query parameters
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Guest";
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : "";
$dob = isset($_GET['dob']) ? htmlspecialchars($_GET['dob']) : "";
$course = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : "";
$gender = isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : "";
$phone = isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome, <?php echo $name; ?></title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <h1>Welcome, <?php echo $name; ?>!</h1>

  <h2>Your Details</h2>
  <ul>
    <li><strong>Email:</strong> <?php echo $email; ?></li>
    <li><strong>Date of Birth:</strong> <?php echo $dob; ?></li>
    <li><strong>Course:</strong> <?php echo $course; ?></li>
    <li><strong>Gender:</strong> <?php echo $gender; ?></li>
    <li><strong>Phone Number:</strong> <?php echo $phone; ?></li>
  </ul>

  <p><a href="login.html">Login</a></p>
  <p><a href="register.php">Go Back to Register</a></p>
</body>
</html>
