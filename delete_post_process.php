<?php
include('config.php');
session_start();

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $sql = "DELETE FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
