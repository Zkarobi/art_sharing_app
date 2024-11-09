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
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <!-- Display user-specific posts -->
    <h2>Your Posts</h2>
    <?php if (!empty($posts)): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <strong><?php echo htmlspecialchars($post['caption']); ?></strong><br>
                    <img src="uploads/<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" style="max-width:200px;"><br>
                    <a href="php/edit_post.php?post_id=<?php echo $post['post_id']; ?>">Edit</a> |
                    <a href="php/delete_post.php?post_id=<?php echo $post['post_id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You haven’t shared any artwork yet. <a href="php/create_post.php">Create a new post</a></p>
    <?php endif; ?>

    <!-- Logout link -->
    <p><a href="php/logout.php">Logout</a></p>
</body>
</html>
