<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || !isset($_SESSION['is_admin'])) {
    header("Location: index.php"); // Redirect to index.php if not admin or not logged in
    exit();
}

// Include database connection
include ("db_connection.php");

// Fetch all users from the database excluding admin
$query = "SELECT id, username, email FROM user WHERE username != 'admin'";
$result = mysqli_query($connection, $query);

// Check if there are users
if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = [];
}

// Close connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- SweetAlert2 CDN -->
</head>

<body>
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
                            <a class="nav-link" href="newPost.php">Add New</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['is_admin'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="user.php">Edit User</a>
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
        <h2 class="mb-4">User Accounts</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete(<?php echo $user['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_user.php?id=' + userId;
                }
            })
        }
    </script>
</body>

</html>