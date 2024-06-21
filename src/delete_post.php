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

// Check if the logged-in user is an admin
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

// Delete the post from the database
if ($is_admin) {
    // Admin can delete any post
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $postId);
} else {
    // Regular user can delete only their own posts
    $query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $postId, $_SESSION['id']);
}

if ($stmt->execute()) {
    if ($is_admin) {
        // Redirect admin to index.php after deleting the post
        header("Location: index.php");
    } else {
        // Redirect regular user to myposts.php after deleting their post
        header("Location: myposts.php");
    }
    exit();
} else {
    echo "Error deleting post.";
}

// Close statement and connection
$stmt->close();
$connection->close();
?>