<?php
// Include the configuration file
include 'config.php';

// Initialize an empty array for search results
$results = [];

if (isset($_GET['query'])) {
    // Sanitize the input
    $query = '%' . $conn->real_escape_string(trim($_GET['query'])) . '%';

    // Prepare the SQL statement to search in title, content, and tags
    $sql = "SELECT bp.id, bp.title, bp.content, bp.tags, bp.created_at, u.username 
            FROM blog_posts bp 
            JOIN users u ON bp.user_id = u.id 
            WHERE (bp.title LIKE ? OR bp.content LIKE ? OR bp.tags LIKE ?) AND bp.status = 'published'";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $query, $query, $query);
        $stmt->execute();
        $stmt->store_result();
        
        // Check if there are results
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $title, $content, $tags, $created_at, $username);
            while ($stmt->fetch()) {
                $results[] = [
                    'id' => $id,
                    'title' => $title,
                    'content' => $content,
                    'tags' => $tags,
                    'created_at' => $created_at,
                    'username' => $username
                ];
            }
        } else {
            $message = "No posts found matching your search.";
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
</head>
<body>
<?php include('header.php');?>

<div class="container">
    <h2>Search Results</h2>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <h3><a href="view_post.php?id=<?php echo $result['id']; ?>"><?php echo htmlspecialchars($result['title']); ?></a></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($result['username']); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($result['created_at']); ?></p>
                    <p><strong>Tags:</strong> <?php echo htmlspecialchars($result['tags']); ?></p>
                    <p><?php echo substr($result['content'], 0, 100) . '...'; ?></p> <!-- Display a snippet of the content -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><?php echo isset($message) ? htmlspecialchars($message) : "No results found."; ?></p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
