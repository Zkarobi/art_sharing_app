<?php
session_start(); // Start the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

require 'config.php'; // Include the database connection

$errors = []; // Initialize an array to store error messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim($_POST['caption']); // Get the caption text
    $image = $_FILES['image']; // Get the uploaded file

    // Validate caption
    if (empty($caption)) {
        $errors[] = "Caption is required.";
    }

    // Validate image upload
    if ($image['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Image is required.";
    } elseif (!in_array(mime_content_type($image['tmp_name']), ['image/jpeg', 'image/png', 'image/gif'])) {
        $errors[] = "Only JPG, PNG, and GIF files are allowed.";
    }

    // If no errors, process the upload
    if (empty($errors)) {
        $image_path = uniqid() . "_" . basename($image['name']); // Generate unique filename
        $upload_dir = '../uploads/' . $image_path; // Define upload directory

        if (move_uploaded_file($image['tmp_name'], $upload_dir)) {
            // Insert the post into the database
            try {
                $stmt = $pdo->prepare("INSERT INTO posts (user_id, caption, image_path) VALUES (
                    (SELECT user_id FROM users WHERE username = :username),
                    :caption,
                    :image_path
                )");
                $stmt->execute([
                    'username' => $_SESSION['username'],
                    'caption' => $caption,
                    'image_path' => $image_path,
                ]);
                header("Location: ../profile.php"); // Redirect to the profile page
                exit;
            } catch (PDOException $e) {
                $errors[] = "Error saving post: " . $e->getMessage();
            }
        } else {
            $errors[] = "Failed to upload image.";
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
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>

    <!-- Display errors if any -->
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form for creating a new post -->
    <form method="POST" action="create_post.php" enctype="multipart/form-data">
        <label for="caption">Caption:</label>
        <textarea id="caption" name="caption" required></textarea>

        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Create Post</button>
    </form>
</body>
</html>
