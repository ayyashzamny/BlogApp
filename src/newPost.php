<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Form</title>
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
                        <a class="nav-link " aria-current="page" href="index.php">All Posts</a>
                    </li>
                    <?php if (isset($_SESSION['id'])): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="myposts.php">My Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="newPost.php">Add New</a>
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
                    <h1>Create a New Blog Post</h1>

                    <form id="postForm" action="submit_post.php" method="POST">
                        <label for="postTitle">Title:</label>
                        <input type="text" id="postTitle" name="postTitle" class="form-control" required>

                        <label for="postContent">Content:</label>
                        <textarea id="postContent" name="postContent" rows="8" class="form-control" required></textarea>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        <button type="reset" class="btn btn-secondary mt-3 ms-2">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('postForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('submit_post.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Post Created',
                            text: 'Your new post has been successfully created!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while creating the post.'
                    });
                });
        });
    </script>
</body>

</html>