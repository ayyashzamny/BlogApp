<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

// Include your database connection file
include ("db_connection.php");

// Get the post ID from the URL
$postId = $_GET['id'];

// Delete the post from the database
$query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ii", $postId, $_SESSION['id']);
if ($stmt->execute()) {
    header("Location: myposts.php");
    exit();
} else {
    echo "Error deleting post.";
}

// Close statement and connection
$stmt->close();
$connection->close();
?>