<?php
// Include the database connection file
require_once "db_config.php";

// Define variables and initialize with empty values
$name = $email = $password = $dob = $course = $gender = $phone = "";
$name_err = $email_err = $password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);  // Hash the password before saving to the database
    }

    // Validate other form fields (dob, course, gender, phone)
    $dob = trim($_POST["dob"]);
    $course = trim($_POST["course"]);
    $gender = trim($_POST["gender"]);
    $phone = trim($_POST["phone"]);

    // Check if there are no errors
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        // Insert data into the database (Example)
        $sql = "INSERT INTO students (name, email, password, dob, course, gender, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bind_param("sssssss", $name, $email, $password, $dob, $course, $gender, $phone);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the welcome page after successful registration
                header("Location: welcome.php?name=$name&email=$email&dob=$dob&course=$course&gender=$gender&phone=$phone");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close the prepared statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Registration</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>

  <h1>Student Registration Form</h1>

  <form action="register.php" method="post" class="registration-form">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required><br>

    <label for="course">Course:</label>
    <select id="course" name="course" required>
      <option value="">--Select Course--</option>
      <option value="CSE">CSE</option>
      <option value="ECE">ECE</option>
      <option value="IT">IT</option>
      <option value="MECH">MECH</option>
      <option value="CIVIL">CIVIL</option>
      <option value="EEE">EEE</option>
      <option value="AIDS">AIDS</option>
    </select><br>

    <label for="gender">Gender:</label>
    <input type="radio" name="gender" value="Male" required> Male
    <input type="radio" name="gender" value="Female"> Female<br>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required><br>

    <input type="submit" value="Register">
  </form>

  <p class="back-to-login"><a href="login.html">← Back to Login</a></p>

</body>
</html>
