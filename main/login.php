<?php

session_start();
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once "db_config.php";

// Start the session


// Include the session timeout script to manage inactivity
include('session_timeout.php');  // Ensure you have created this file

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before querying the database
    if (empty($email_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, email, password FROM students WHERE email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bind_param("s", $email);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $stmt->store_result();

                // Check if email exists in the database
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        // Check if the password is correct
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Set last activity time for session timeout logic
                            $_SESSION['last_activity'] = time();

                            // Redirect to home page (index.php) after successful login
                            header("Location: index.php");
                            exit();
                        } else {
                            // Password is incorrect
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Email doesn't exist in the database
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Close the connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Login</title>
  <link rel="stylesheet" href="login-style.css">
</head>
<body>

  <h1>Student Login</h1>

  <form action="login.php" method="post" class="login-form">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <span class="error"><?php echo $email_err; ?></span><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <span class="error"><?php echo $password_err; ?></span><br>

    <input type="submit" value="Login">
  </form>

  <p class="register-link">New user? <a href="register.html">Register here</a></p>

</body>
</html>
