<?php
require 'config.php'; // Include the database connection
$page_title = "About Us"; // Page-specific title
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>About Us</title>
</head>
<body>
    <?php include 'menu.php'; ?>

  \

    <!-- About Section -->
    <section class="about-section">
        <div class="about-container">
            <h2>Welcome to Muse</h2>
            <p>
                Muse is an art-sharing platform designed to inspire creativity and bring artists together. 
                Whether you're looking for inspiration through random art prompts or sharing your creations with the world, 
                Muse is the perfect place to explore and express your artistic talents.
            </p>
            <p>
                Our mission is to foster a community where artists can connect, collaborate, and celebrate their work.
                From beginners to professionals, Muse is here to provide a welcoming and encouraging space for all.
            </p>
        </div>
        <div class="about-image">
            <img src="../images/art.jpg" alt="Art Inspiration">
        </div>
    </section>

    <!-- Call to Action -->
    <section class="call-to-action">
        <h3>Ready to Get Started?</h3>
        <p>Generate your first art prompt or share your masterpiece with the world!</p>
        <!--<a href="index.php" class="cta-button">Explore Prompts</a>-->
        <a href="<?php echo $base_url; ?>index.php" class="cta-button">Explore Prompts</a>

    </section>
</body>
</html>
