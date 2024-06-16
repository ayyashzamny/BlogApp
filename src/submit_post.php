<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.html");
    exit();
}

// Include your database connection file
include ("db_connection.php");

// Retrieve data from the form
$user_id = $_SESSION['id']; // Assuming user_id is stored in session after login
$title = $_POST["postTitle"];
$content = $_POST["postContent"];
$created_at = date('Y-m-d H:i:s'); // Current date and time for created_at
$updated_at = $created_at; // Initially, updated_at is the same as created_at

// SQL query to insert post data into the database
$query = "INSERT INTO posts (user_id, title, content, created_at, updated_at) 
          VALUES ('$user_id', '$title', '$content', '$created_at', '$updated_at')";

$result = mysqli_query($connection, $query);

if ($result) {
    // Post insertion successful
    header("Location: index.php"); // Redirect to a page showing all posts
    exit();
} else {
    // Error handling
    $error_message = "Error executing query: " . mysqli_error($connection);
    header("Location: new_post.php?error=$error_message"); // Redirect back to new post form with error message
    exit();
}


// // Close the database connection
// mysqli_close($connection);
?>