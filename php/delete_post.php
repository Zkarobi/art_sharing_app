<?php
session_start(); // Start the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}

require 'config.php'; // Include the database connection

$post_id = $_GET['post_id'] ?? null;

if ($post_id) {
    try {
        // Fetch the post to ensure it belongs to the logged-in user
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id AND user_id = 
            (SELECT user_id FROM users WHERE username = :username)");
        $stmt->execute(['post_id' => $post_id, 'username' => $_SESSION['username']]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            // Delete the post from the database
            $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = :post_id");
            $stmt->execute(['post_id' => $post_id]);

            // Delete the associated image file
            $image_path = '../uploads/' . $post['image_path'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            header("Location: ../profile.php?message=Post deleted successfully");
            exit;
        } else {
            die("Post not found or you do not have permission to delete it.");
        }
    } catch (PDOException $e) {
        die("Error deleting post: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Delete Post</title>
</head>
<body>
    <h1>Delete Post</h1>
    <p>Unable to delete the post. Please try again later.</p>
    <p><a href="../profile.php">Back to profile</a></p>
</body>
</html>
