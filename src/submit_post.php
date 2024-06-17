<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Unauthorized access
    $response = ['success' => false, 'message' => 'Unauthorized access'];
    echo json_encode($response);
    exit();
}

// Include your database connection file
include ("db_connection.php");

// Retrieve data from the form
$user_id = $_SESSION['id']; // Assuming user_id is stored in session after login
$title = mysqli_real_escape_string($connection, $_POST["postTitle"]);
$content = mysqli_real_escape_string($connection, $_POST["postContent"]);
$created_at = date('Y-m-d H:i:s'); // Current date and time for created_at
$updated_at = $created_at; // Initially, updated_at is the same as created_at

// SQL query to insert post data into the database
$query = "INSERT INTO posts (user_id, title, content, created_at, updated_at) 
          VALUES ('$user_id', '$title', '$content', '$created_at', '$updated_at')";

if (mysqli_query($connection, $query)) {
    // Post insertion successful
    $response = ['success' => true];
} else {
    // Error handling
    $response = ['success' => false, 'message' => 'Error executing query: ' . mysqli_error($connection)];
}

// Close the database connection
mysqli_close($connection);

echo json_encode($response);
?>