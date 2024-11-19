<?php
session_start(); // Start the session to check login status

// Dynamically calculate the base URL
$base_url = '/art_sharing_app/';
?>
<header>
<h1>Welcome to Muse</h1>
<nav>
    <button class="menu-button">Menu</button>
    <div class="dropdown">
        <a href="<?php echo $base_url; ?>index.php">Home</a>
        <a href="<?php echo $base_url; ?>php/explore_prompts.php">Explore Prompts</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="<?php echo $base_url; ?>profile.php">Profile (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
            <a href="<?php echo $base_url; ?>php/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base_url; ?>php/login.php">Login</a>
            <a href="<?php echo $base_url; ?>php/register.php">Register</a>
        <?php endif; ?>
        <a href="<?php echo $base_url; ?>php/about.php">About</a>
        <a href="<?php echo $base_url; ?>php/contact.php">Contact Us</a>
        <a href="<?php echo $base_url; ?>php/terms.php">Terms and Conditions</a>
    </div>
</header>
</nav>
