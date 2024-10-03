<?php
// Start session to check if user is logged in
include('header.php');
?>

<!-- Home Page Content -->
<div class="container">
    <h1>Welcome to the Blog Platform</h1>
    <p>Your space to create, share, and explore blog posts.</p>

    <!-- Display buttons for login or dashboard depending on user authentication -->
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="btn">Login</a>
        <a href="signup.php" class="btn">Sign Up</a>
    <?php else: ?>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    <?php endif; ?>

    <!-- Section for displaying recent blog posts -->
    <section>
        <h2>Recent Published Posts</h2>
        <?php
        // Query to get recent published posts
        $sql = "SELECT * FROM blog_posts WHERE status = 'published' ORDER BY created_at DESC LIMIT 5";
        $result = $conn->query($sql);

        // Display each post with a link to view the full post
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <article>
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo substr($row['content'], 0, 150); ?>...</p> <!-- Allow HTML here -->
            <a href="view_post.php?id=<?php echo $row['id']; ?>">Read More</a>
        </article>
        <?php
            endwhile;
        else:
        ?>
            <p>No published posts found.</p>
        <?php endif; ?>
    </section>
</div>

<?php include('footer.php'); ?>
