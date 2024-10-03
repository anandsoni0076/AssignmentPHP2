<?php include('header.php'); ?>
<link rel="stylesheet" href="style.css">
<style>
   

.container {
    max-width: 800px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
}

.btn {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 0;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-edit {
    background-color: #ffc107;
    color: #fff;
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn:hover {
    opacity: 0.9;
}

.post-card {
    background: #f9f9f9;
    border: 1px solid #e2e2e2;
    border-radius: 5px;
    padding: 15px;
    margin: 10px 0;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}

.post-actions {
    margin-top: 10px;
}

.status {
    font-weight: bold;
    color: #666;
}

</style>
<div class="container">
    <h2>Your Blog Posts</h2>
    <a class="btn btn-primary" href="createpost.php">Create New Post</a>

    <?php
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM blog_posts WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post-card'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p class='status'>Status: " . $row['status'] . "</p>";
            echo "<div class='post-actions'>";
            echo "<a class='btn btn-edit' href='editpost.php?id=" . $row['id'] . "'>Edit</a>";
            echo "<a class='btn btn-delete' href='delete_post_process.php?id=" . $row['id'] . "'>Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts found. Start creating your first post!</p>";
    }
    ?>

</div>

<?php include('footer.php'); ?>
