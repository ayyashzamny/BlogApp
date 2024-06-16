<?php
session_start();

// Initialize variables to hold user input and error messages
$username = $email = $password = $confirmPassword = "";
$usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include ("db_connection.php");

    // Validate and sanitize user input
    if (empty($_POST["userName"])) {
        $usernameErr = "Username is required";
    } else {
        $username = mysqli_real_escape_string($connection, $_POST["userName"]);
        // Check if username already exists
        $query = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $usernameErr = "Username already exists";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = mysqli_real_escape_string($connection, $_POST["email"]);
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = mysqli_real_escape_string($connection, $_POST["password"]);
    }

    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Please confirm password";
    } else {
        $confirmPassword = mysqli_real_escape_string($connection, $_POST["confirmPassword"]);
        // Check if passwords match
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // Proceed with registration if there are no errors
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        // Hash the password (use a strong hashing algorithm)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user data into the database
        $insert_query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        $insert_result = mysqli_query($connection, $insert_query);

        if ($insert_result) {
            // Registration successful, redirect to login page or any success page
            header("location: login.html");
            exit();
        } else {
            $error_message = "Error executing query: " . mysqli_error($connection);
        }
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/SignupStyle.css">
    <title>Registration Form</title>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <div class="form-container">
            <h1>Registration</h1>

            <?php if (!empty($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" value="<?php echo htmlspecialchars($username); ?>"
                    required>
                <span class="error"><?php echo $usernameErr; ?></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error"><?php echo $emailErr; ?></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="error"><?php echo $passwordErr; ?></span>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span class="error"><?php echo $confirmPasswordErr; ?></span>

                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="clear-btn" onclick="clearForm()">Clear</button>
            </form>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("userName").value = "";
            document.getElementById("email").value = "";
            document.getElementById("password").value = "";
            document.getElementById("confirmPassword").value = "";
        }
    </script>

</body>

</html>