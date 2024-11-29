<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}

require 'config.php'; // Include database connection

$page_title = "Feed";

try {
    // Fetch all posts except the current user's, ordered by the latest
    $stmt = $pdo->prepare("SELECT p.*, u.username 
                           FROM posts p
                           JOIN users u ON p.user_id = u.user_id
                           WHERE u.username != :current_user
                           ORDER BY p.created_at DESC"); // Assuming `created_at` column exists
    $stmt->execute(['current_user' => $_SESSION['username']]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching feed posts: " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Feed</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <!-- Feed Header -->
    <section class="feed-header">
        <h2>Discover Posts</h2>
        <p>Explore artwork shared by other users!</p>
    </section>

    <!-- Feed Posts -->
    <section class="posts-gallery">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <img src="../uploads/<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image">
                    <div class="post-details">
                        <p><strong><?php echo htmlspecialchars($post['username']); ?></strong></p>
                        <p><?php echo htmlspecialchars($post['caption']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-posts">No posts available to discover. <a href="create_post.php" class="create-post-link">Create a new post</a>.</p>
        <?php endif; ?>
    </section>
</body>
</html>
