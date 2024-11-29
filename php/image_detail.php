<?php
require 'config.php'; // Include database connection

// Get the post ID from the URL
$post_id = $_GET['post_id'] ?? null;

if ($post_id) {
    try {
        // Fetch the specific post
        $stmt = $pdo->prepare("SELECT p.*, u.username 
                               FROM posts p
                               JOIN users u ON p.user_id = u.user_id
                               WHERE p.post_id = :post_id");
        $stmt->execute(['post_id' => $post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching post: " . $e->getMessage());
    }
} else {
    // Redirect to feed if no post ID is provided
    header("Location: feed.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Image Detail</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <?php if ($post): ?>
        <section class="image-detail">
            <img src="../uploads/<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image">
            <div class="image-info">
                <h2>Caption: <?php echo htmlspecialchars($post['caption']); ?></h2>
                <p>Uploaded by: <strong><?php echo htmlspecialchars($post['username']); ?></strong></p>
                <p>Uploaded on: <?php echo htmlspecialchars($post['created_at']); ?></p> <!-- Assuming created_at exists -->
            </div>
            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <a href="feed.php" class="go-back-button">Go Back to Feed</a>
                <a href="../profile.php" class="go-back-button">Go Back to Profile</a>
            </div>
        </section>
    <?php else: ?>
        <p class="error-message">The post you are looking for does not exist.</p>
    <?php endif; ?>
</body>
</html>
