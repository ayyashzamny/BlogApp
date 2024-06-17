<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

// Include your database connection file
include ("db_connection.php");

// Get the logged-in user's ID
$userId = $_SESSION['id'];

// Fetch posts created by the logged-in user from the database
$query = "SELECT posts.id, user.username, posts.title, posts.content, posts.created_at, posts.updated_at
          FROM posts 
          JOIN user ON posts.user_id = user.id 
          WHERE user.id = ? 
          ORDER BY posts.created_at DESC";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are posts
if ($result->num_rows > 0) {
    // Output data of each row
    $posts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $posts = []; // Empty array if no posts found
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
    <title>Blogger</title>
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
                        <a class="nav-link" href="index.php">All Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="myposts.php">My Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="newPost.php">Add New</a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-outline-light" href="logout.php">Log Out</a>
        </div>
    </nav>

    <main class="container mt-5">
        <section class="row">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <article class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-dark text-white"><?php echo htmlspecialchars($post['username']); ?></div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                            </div>
                            <div class="card-footer text-muted">
                                <div class="mt-2">
                                    Created at <?php echo htmlspecialchars($post['created_at']); ?>
                                </div>
                                Updated at <?php echo htmlspecialchars($post['updated_at']); ?>

                                <div class="mt-2">
                                    <a href="edit_post.php?id=<?php echo $post['id']; ?>"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete(<?php echo $post['id']; ?>)">Delete</a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </section>
    </main>

    <script>
        function confirmDelete(postId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_post.php?id=' + postId;
                }
            })
        }
    </script>
</body>

</html>