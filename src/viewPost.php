<?php
session_start();

// Include your database connection file
include ("db_connection.php");

// Check if the post ID is set
if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);

    // Fetch the post from the database
    $query = "SELECT user.username, posts.title, posts.content, posts.updated_at 
              FROM posts 
              JOIN user ON posts.user_id = user.id 
              WHERE posts.id = $postId";

    $result = mysqli_query($connection, $query);

    // Check if the post exists
    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
    } else {
        // Redirect to main page if post not found
        header("Location: index.php");
        exit();
    }

    // Close connection
    mysqli_close($connection);
} else {
    // Redirect to main page if ID is not set
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card-textarea {
            width: 100%;
            border: none;
            resize: none;
            overflow: hidden;
            background-color: transparent;
            padding: 0;
        }

        .card-textarea:focus {
            outline: none;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Blogger</a>
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
                </ul>
            </div>
            <?php if (isset($_SESSION['id'])): ?>
                <a class="btn btn-outline-light" href="logout.php">Log Out</a>
            <?php else: ?>
                <a class="btn btn-outline-light" href="login.html">Log In</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container mt-5">
        <article class="col-md-8 offset-md-2 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">Post By :
                    <?php echo htmlspecialchars($post['username']); ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                    <textarea class="card-textarea"
                        readonly><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>
                <div class="card-footer text-muted">Posted On : <?php echo htmlspecialchars($post['updated_at']); ?>
                </div>
            </div>
        </article>
    </main>

    <script>
        // Adjust the height of the textarea to fit its content
        document.addEventListener("DOMContentLoaded", function () {
            var textareas = document.querySelectorAll('.card-textarea');
            textareas.forEach(function (textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            });
        });
    </script>
</body>

</html>