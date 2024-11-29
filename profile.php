<?php
session_start(); // Start the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: php/login.php");
    exit;
}

require 'php/config.php'; // Include database connection

// Fetch user-specific posts
try {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = (SELECT user_id FROM users WHERE username = :username)");
    $stmt->execute(['username' => $_SESSION['username']]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching user posts: " . $e->getMessage());
}

$page_title = "Your Profile";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Your Profile</title>
</head>
<body>
    <?php include 'php/menu.php'; ?>

    <!-- Profile Header -->
    <section class="profile-header">
        <div class="profile-info">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>View, edit, or delete your posts below.</p>
            <a href="php/create_post.php" class="create-post-button">+ Create New Post</a>
        </div>
    </section>

    <!-- Display user-specific posts -->
    <section class="posts-gallery">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <a href="php/image_detail.php?post_id=<?php echo $post['post_id']; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image">
                    </a>
                    <div class="post-details">
                        <p><?php echo htmlspecialchars($post['caption']); ?></p>
                        <div class="post-actions">
                            <a href="php/edit_post.php?post_id=<?php echo $post['post_id']; ?>" class="edit-button">Edit</a>
                            <a href="php/delete_post.php?post_id=<?php echo $post['post_id']; ?>" class="delete-button">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-posts">You haven’t shared any artwork yet. <a href="php/create_post.php" class="create-post-link">Create a new post</a></p>
        <?php endif; ?>
    </section>
</body>
</html>
