<?php 
include('header.php'); 
include('config.php');

// Check if post ID is set in the URL
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); // Sanitize the input

    // Prepare and execute the SQL statement to fetch the post along with the author's username
    $sql = "SELECT bp.title, bp.content, bp.tags, bp.created_at, u.username 
            FROM blog_posts bp 
            JOIN users u ON bp.user_id = u.id 
            WHERE bp.id = ? AND bp.status = 'published'";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->store_result();
        
        // Check if the post exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($title, $content, $tags, $created_at, $username);
            $stmt->fetch();
        } else {
            echo "<p style='color:red;'>Post not found or not published.</p>";
            exit();
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error preparing statement: " . $conn->error . "</p>";
        exit();
    }
} else {
    echo "<p style='color:red;'>No post ID specified.</p>";
    exit();
}
?>

<div class="container"> 
    <style> img {
    max-width: 100%; 
    height: auto;    
}</style>
    <h2><?php echo htmlspecialchars($title); ?></h2>
    <p><strong>Created At:</strong> <?php echo htmlspecialchars($created_at); ?></p>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($username); ?></p> <!-- Display the author's username -->
    <p><strong>Tags:</strong> <?php echo htmlspecialchars($tags); ?></p>
    <div>
        <?php echo $content; // Output the content directly to render HTML ?>
    </div>
    <?php
    if (isset($_SESSION['user_id'])){
        echo '<a href="dashboard.php" class="btn">Back to Dashboard</a>';
    }
    ?>
</div>

<?php include('footer.php'); ?>
