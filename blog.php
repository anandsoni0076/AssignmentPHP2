<?php include('header.php'); ?>
<h2>All Published Blog Posts</h2>

<style>
    .blog-container {
    display: flex;
    flex-wrap: wrap; /* Allows the cards to wrap on smaller screens */
    gap: 20px; /* Adds space between cards */
    padding: 20px;
    justify-content: center; /* Centers the cards in the container */
}

.blog-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 15px;
    max-width: 100%;
    flex: 1 1 calc(33.333% - 30px); /* Cards will take up 1/3 of the row and adjust for spacing */
    min-width: 280px; /* Prevents cards from becoming too small */
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.blog-card h3 {
    font-size: 1.5em;
    margin: 10px;
    white-space: normal; /* Allows the title to wrap inside the card */
    overflow: hidden; /* Prevents overflowing content */
    text-overflow: ellipsis; /* Adds ellipsis if the text overflows */
}

.blog-card p {
    margin: 10px;
    color: #555;
    white-space: normal; /* Allows paragraph text to wrap */
}

.read-more {
    display: block;
    text-align: center;
    background: #007bff;
    color: white;
    padding: 10px;
    text-decoration: none;
    border-radius: 0 0 8px 8px;
    transition: background 0.3s;
    margin-top: auto; /* Forces the button to stay at the bottom of the card */
}

.read-more:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-card {
        flex: 1 1 calc(50% - 30px); /* Cards will take up half the row on smaller screens */
    }
}

@media (max-width: 480px) {
    .blog-card {
        flex: 1 1 100%; /* Cards will take up the entire row on very small screens */
    }
}

</style>

<div class="blog-container">
    <?php
    $sql = "SELECT * FROM blog_posts WHERE status = 'published'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<div class='blog-card'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . substr($row['content'], 0, 150) . "...</p>";
        echo "<a class='read-more' href='view_post.php?id=" . $row['id'] . "'>Read More</a>";
        echo "</div>";
    }
    ?>
</div>

<?php include('footer.php'); ?>
