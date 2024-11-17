<?php
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Simulate saving the message (e.g., log to a file or database)
    // For now, we'll just confirm the submission
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Adjust path if needed -->
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>

    <!-- Success Message -->
    <?php if ($success): ?>
        <p style="color: green;">Thank you for your message! We’ll get back to you soon.</p>
    <?php endif; ?>

    <!-- Contact Form -->
    <form method="POST" action="contact.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send</button>
    </form>

    <p><a href="../index.php">Go Back to Home</a></p> <!-- Adjust link if needed -->
</body>
</html>
