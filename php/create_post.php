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
    <link rel="stylesheet" href="../css/styles.css"> <!-- Adjust path as needed -->
    <title>Create Post</title>
</head>
<body>
<?php include 'menu.php'; ?>

    <section class="create-post-section">
        <h2>Create a New Post</h2>
        <form method="POST" action="create_post.php" enctype="multipart/form-data">
            <label for="caption">Caption:</label>
            <textarea id="caption" name="caption" required></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <!-- Preview Container -->
            <div class="image-preview-container">
                <img id="image-preview" alt="Image Preview" style="display: none; max-width: 100%; border: 1px solid #ddd; margin-top: 10px;">
            </div>

            <!-- Resize Controls -->
            <div id="resize-container" style="display: none; margin-top: 10px;">
                <label for="resize-width">Width:</label>
                <input type="number" id="resize-width" value="300" style="width: 80px;">
                <label for="resize-height">Height:</label>
                <input type="number" id="resize-height" value="200" style="width: 80px;">
            </div>

            <button type="submit">Post</button>
        </form>

    </section>

    <!-- Link to the external JavaScript file -->
    <script src="../js/image_preview.js"></script>
</body>
</html>
