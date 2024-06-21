<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || !isset($_SESSION['is_admin'])) {
    header("Location: index.php"); // Redirect to index.php if not admin or not logged in
    exit();
}

// Include database connection
include ("db_connection.php");

// Function to delete all posts of a user by user_id
function deletePostsByUser($connection, $userId)
{
    $query = "DELETE FROM posts WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        return false; // Return false if deletion fails
    }
    return true;
}

// Get user ID to delete from URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete all posts by the user
    if (!deletePostsByUser($connection, $userId)) {
        echo "Error deleting user's posts.";
        exit();
    }

    // Delete the user from the user table
    $query = "DELETE FROM user WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Redirect to a success page or any other page after deletion
        header("Location: user.php");
        exit();
    } else {
        echo "Error deleting user.";
    }

    // Close statement and connection
    $stmt->close();
    $connection->close();
} else {
    echo "Invalid user ID.";
}
?>