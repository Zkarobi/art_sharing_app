<?php
session_start(); // Start the session to check login status

// Dynamically calculate the base URL
$base_url = '/art_sharing_app/';
?>
<nav>
    <ul>
        <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
        <li><a href="<?php echo $base_url; ?>php/explore_prompts.php">Explore Prompts</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="<?php echo $base_url; ?>profile.php">Profile (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
            <li><a href="<?php echo $base_url; ?>php/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="<?php echo $base_url; ?>php/login.php">Login</a></li>
            <li><a href="<?php echo $base_url; ?>php/register.php">Register</a></li>
        <?php endif; ?>
        <li><a href="<?php echo $base_url; ?>php/about.php">About</a></li>
        <li><a href="<?php echo $base_url; ?>php/contact.php">Contact Us</a></li>
        <li><a href="<?php echo $base_url; ?>php/terms.php">Terms and Conditions</a></li>
    </ul>
</nav>
