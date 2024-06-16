<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include ("db_connection.php");

    // Get user input
    $username = $_POST["userName"];
    $password = $_POST["password"];

    // SQL query to check if the username exists
    $check_query = "SELECT id, username, password FROM user WHERE username = ?";
    $stmt = $connection->prepare($check_query);

    if ($stmt === false) {
        // Error preparing statement
        die('MySQL prepare error: ' . $connection->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the row
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            $error_message = "Username or password is incorrect.";
        }
    } else {
        // Invalid username
        $error_message = "Username or password is incorrect.";
    }

    // Close statement
    $stmt->close();

    // Close connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/LoginStyle.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> <!-- SweetAlert CDN -->
    <title>Login Page</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            <h1>Login</h1>

            <?php if (isset($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <p>Don't have an account? <a href="signup.php" class="signup-btn">Sign Up</a></p>

                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>
</body>

</html>