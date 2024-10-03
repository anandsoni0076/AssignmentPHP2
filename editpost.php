<?php
include('header.php');

// Check if the form is submitted
if (isset($_POST['update'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $status = $_POST['status']; // Get the status from the dropdown

    // Update the post with new details
    $sql = "UPDATE blog_posts SET title = ?, content = ?, tags = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $content, $tags, $status, $post_id);
    $stmt->execute();

    header("Location: dashboard.php");
}

// Retrieve the post if an ID is provided
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
} else {
    header("Location: dashboard.php");
}
?>

<h2>Edit Post</h2>
<form action="" method="POST">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    <textarea id="editor" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    <input type="text" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>" placeholder="Tags (comma separated)">

    <!-- Dropdown for status -->
    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
        <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
    </select>

    <button type="submit" name="update">Update</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.tiny.cloud/1/9fdg7irb7w0mlyytw587jeze0uimg319aed273bhelvi0vq8/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#editor', // Match the ID of your textarea
        width: "100%",
        height: "200",
        plugins: 'lists link image preview',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview',
        setup: function (editor) {
            editor.on('init', function () {
                console.log('TinyMCE initialized'); // Confirm initialization
            });
        }
    });

    $(document).ready(function() {
        $('#buttonpost').on("click", function() {
            tinyMCE.triggerSave(); // Save content from TinyMCE to textarea
            return true; // Allow form submission
        });
    });
</script>

<?php include('footer.php'); ?>
