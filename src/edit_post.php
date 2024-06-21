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

// Fetch the post details from the database
$query = "SELECT title, content FROM posts WHERE id = ? AND user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ii", $postId, $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if the post exists
if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    echo "Post not found.";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['postTitle'];
    $content = $_POST['postContent'];
    $updated_at = date('Y-m-d H:i:s'); // Current date and time for updated_at

    // Update the post in the database
    $updateQuery = "UPDATE posts SET title = ?, content = ?, updated_at = ? WHERE id = ? AND user_id = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param("sssii", $title, $content, $updated_at, $postId, $_SESSION['id']);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating post.']);
        exit();
    }
}

// Close statement and connection
$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <link rel="stylesheet" href="Styles/newPost.css">
    <link rel="stylesheet" href="Styles/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Blogger</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">All Posts</a>
                    </li>
                    <?php if (isset($_SESSION['id'])): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="myposts.php">My Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="newPost.php">Add New</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['is_admin'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php">Edit User</a>
                        </li>

                    <?php endif; ?>
                </ul>
            </div>
            <?php if (isset($_SESSION['id'])): ?>
                <a class="btn btn-outline-light" href="logout.php">Log Out</a>
            <?php else: ?>
                <a class="btn btn-outline-light" href="login.html">Log In</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="blog-post-form">
                    <h1>Edit Blog Post</h1>

                    <form id="editPostForm" action="" method="POST">
                        <label for="postTitle">Title:</label>
                        <input type="text" id="postTitle" name="postTitle" class="form-control"
                            value="<?php echo htmlspecialchars($post['title']); ?>" required>

                        <label for="postContent">Content:</label>
                        <textarea id="postContent" name="postContent" rows="8" class="form-control"
                            required><?php echo htmlspecialchars($post['content']); ?></textarea>

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <button type="reset" class="btn btn-secondary mt-3 ms-2">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editPostForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your post has been updated.',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'myposts.php';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'An error occurred while updating the post.',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the post.',
                        icon: 'error'
                    });
                });
        });
    </script>

</body>

</html>