<?php
require 'config.php'; // Include the database connection
$page_title = "Terms and Conditions"; // Page-specific title
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Adjust path if needed -->
    <title>Terms and Conditions</title>
</head>
<body>
    <?php include 'menu.php'; ?>


    <section class="terms-section">
        <div class="terms-container">
            <p class="intro-text">
                Welcome to our Art Sharing App! By using this platform, you agree to the following terms:
            </p>

            <div class="terms-content">
                <h2>Ownership</h2>
                <ul>
                    <li>You retain ownership of all artwork you upload.</li>
                    <li>By uploading artwork, you grant us the right to display it on this platform.</li>
                </ul>

                <h2>Acceptable Use</h2>
                <ul>
                    <li>Do not upload content that is offensive, illegal, or violates copyright laws.</li>
                    <li>Respect other users and their contributions.</li>
                </ul>

                <h2>Liability</h2>
                <ul>
                    <li>We are not responsible for any disputes or misuse of uploaded content.</li>
                    <li>We reserve the right to remove content that violates these terms.</li>
                </ul>

                <p class="contact-link">
                    If you have any questions about these terms, please <a href="contact.php">contact us</a>.
                </p>
            </div>
        </div>
    </section>
</body>
</html>
