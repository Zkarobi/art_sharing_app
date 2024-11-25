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

$page_title = "Contact Us"; // Page-specific title
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
    <?php include 'menu.php'; ?>

    
    <!-- Main Content -->
    <section class="contact-section">
        <div class="contact-container">
            <!-- Success Message -->
            <?php if ($success): ?>
                <div class="success-message">
                    <p>Thank you for your message! We’ll get back to you soon.</p>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <h2>We’d Love to Hear from You!</h2>
            <p>If you have any questions, suggestions, or feedback, feel free to drop us a message below.</p>
            <form method="POST" action="contact.php" class="contact-form">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" placeholder="Write your message here..." rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>
</body>
</html>
