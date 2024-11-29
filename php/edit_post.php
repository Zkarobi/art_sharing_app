<?php
session_start(); // Start the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}
$page_title = "Edit Post";
require 'config.php'; // Include the database connection

$post_id = $_GET['post_id'] ?? null; // Get post ID from the query string
$errors = [];
$success = false;

// Fetch the post to edit
if ($post_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id AND user_id = 
            (SELECT user_id FROM users WHERE username = :username)");
        $stmt->execute(['post_id' => $post_id, 'username' => $_SESSION['username']]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            die("Post not found or you do not have permission to edit it.");
        }
    } catch (PDOException $e) {
        die("Error fetching post: " . $e->getMessage());
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim($_POST['caption']);

    // Validate caption
    if (empty($caption)) {
        $errors[] = "Caption is required.";
    }

    // Update the post if there are no errors
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE posts SET caption = :caption WHERE post_id = :post_id");
            $stmt->execute(['caption' => $caption, 'post_id' => $post_id]);
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Error updating post: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Edit Post</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <section class="edit-post-container">
       

        <?php if ($success): ?>
            <p class="success-message">Post updated successfully! <a href="../profile.php">Back to profile</a></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="edit-post-card">
            <div class="image-preview-section">
                <h2>Image Preview</h2>
                <img src="../uploads/<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" class="edit-post-image">
            </div>

            <form method="POST" action="edit_post.php?post_id=<?php echo htmlspecialchars($post_id); ?>" class="edit-post-form">
                <label for="caption">Edit Caption:</label>
                <textarea id="caption" name="caption" required oninput="updateCaptionPreview()"><?php echo htmlspecialchars($post['caption']); ?></textarea>
                


                <button type="submit" class="update-button">Update Post</button>
                <a href="../profile.php" class="cancel-button">Cancel</a>
            </form>
        </div>
    </section>

    <script>
        function updateCaptionPreview() {
            const captionInput = document.getElementById('caption');
            const captionPreview = document.getElementById('caption-preview');
            captionPreview.textContent = captionInput.value;
        }
    </script>
</body>
</html>
