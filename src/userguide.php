<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog App User Guide</title>
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <?php if (!isset($_SESSION['id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="userguide.php">User Guide</a>
                        </li>
                    <?php endif; ?>

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

    <main class="container mt-5">
        <section id="viewing-reading-posts" class="mb-5">
            <h2>1. Viewing and Reading Posts</h2>
            <p><strong>Accessing Posts:</strong> All users, including new users, can view and read posts on the blog.
            </p>
            <p><strong>Navigation:</strong> Navigate through different posts by clicking on their titles or "Read More"
                links on the main page.</p>
        </section>

        <section id="posting-on-the-blog" class="mb-5">
            <h2>2. Posting on the Blog</h2>
            <p><strong>Logging In or Creating an Account:</strong></p>
            <ul>
                <li><strong>New Users:</strong> If you're new to the blog and want to post, you need to create an
                    account first.</li>
                <li><strong>Existing Users:</strong> If you already have an account, log in using your credentials.</li>
            </ul>
            <p><strong>Posting Guidelines:</strong></p>
            <ul>
                <li>Once logged in, navigate to the "Add New" page where you can create and publish your posts.</li>
                <li>Follow community guidelines and ensure your content adheres to the blog's posting policies.</li>
            </ul>
        </section>

        <section id="editing-deleting-posts" class="mb-5">
            <h2>3. Editing and Deleting Posts</h2>
            <p><strong>Editing Your Posts:</strong></p>
            <ul>
                <li>Go to "My Posts" section after logging in to view all your published posts.</li>
                <li>Click on the edit icon or link provided next to each post to make changes.</li>
            </ul>
            <p><strong>Deleting Your Posts:</strong></p>
            <ul>
                <li>If you decide to remove a post, simply navigate to "My Posts," find the post, and click on the
                    delete button.</li>
                <li>Confirm the deletion when prompted to remove the post permanently from the blog.</li>
            </ul>
        </section>

        <section id="additional-tips">
            <h2>Additional Tips</h2>
            <ul>
                <li><strong>Engage Responsibly:</strong> Interact with other bloggers and readers respectfully.</li>
                <li><strong>Explore Blog Features:</strong> Discover more functionalities like searching posts,
                    filtering by categories, or sorting posts by date.</li>
                <li><strong>Stay Updated:</strong> Check for new posts regularly and engage in discussions through
                    comments or social sharing options.</li>
            </ul>
        </section>
    </main>

    <footer class="bg-dark text-center text-white py-3">
        <p>&copy; 2024 Your Blog App. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>