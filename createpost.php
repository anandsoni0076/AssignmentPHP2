<?php 
include('header.php'); 
include('config.php'); // Ensure you have a proper DB connection

// Initialize variables for the form fields
$title = '';
$content = '';
$tags = '';

// Handle saving or publishing the post
if (isset($_POST['publish']) || isset($_POST['save_draft'])) {
    // Sanitize user input to prevent SQL injection
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $tags = trim($_POST['tags']);
    $status = isset($_POST['publish']) ? 'published' : 'draft';

    // Validate title and content
    if (empty($title) || empty($content)) {
        echo "<p style='color:red;'>Title and content cannot be empty.</p>";
    } else {
        // Insert a new post (or draft)
        $sql = "INSERT INTO blog_posts (user_id, title, content, tags, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $title, $content, $tags, $status);

        if ($stmt->execute()) {
            // Successfully inserted the post or draft
            if ($status === 'draft') {
                echo "<p style='color:green;'>Draft saved successfully!</p>";
            } else {
                header("Location: dashboard.php"); // Redirect to the dashboard after successful publishing
                exit();
            }
        } else {
            // Handle execution error
            echo "<p style='color:red;'>Error saving post: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Create Post with TinyMCE</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/9fdg7irb7w0mlyytw587jeze0uimg319aed273bhelvi0vq8/tinymce/5/tinymce.min.js"></script>
    <link rel="stylesheet" href="style.css">
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
            // Save TinyMCE content to the textarea when the submit button is clicked
            $('input[type="submit"]').on("click", function() {
                tinyMCE.triggerSave(); 
                console.log("TinyMCE content saved to textarea."); 
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Create New Post</h1>
        <form action="" method="POST">
            <input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($title); ?>" required />
            <textarea name="content" id="editor" placeholder="Write your post..." required><?php echo htmlspecialchars($content); ?></textarea>
            <input type="text" name="tags" placeholder="Tags (comma separated)" value="<?php echo htmlspecialchars($tags); ?>" />
            <input type="submit" id="buttonpost" name="publish" value="Publish Post" />
            <input type="submit" id="buttondraft" name="save_draft" value="Save as Draft" />
        </form>
    </div>

    <div id="display-post" style="width:700px; margin-top: 20px;"></div>

    <?php include('footer.php'); ?>
</body>
</html>
