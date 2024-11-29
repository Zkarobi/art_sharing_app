<?php
session_start(); // Start the session to check login status

// Dynamically calculate the base URL
$base_url = '/art_sharing_app/';

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="page-header">
    <?php if ($current_page === 'index.php'): ?>
        <!-- Homepage Header -->
        <h1 class="page-title"><?php echo isset($page_title) ? htmlspecialchars($page_title) : ''; ?></h1>
    <?php else: ?>
        <!-- Other Pages Header -->
        <a href="<?php echo $base_url; ?>index.php" class="muse-button">Muse</a>
        <h1 class="page-title"><?php echo isset($page_title) ? htmlspecialchars($page_title) : ''; ?></h1>
    <?php endif; ?>

    <!-- Navigation Menu -->
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
            <a href="<?php echo $base_url; ?>php/feed.php">Feed</a>
        </div>

    </nav>
</header>
<!-- Link the JavaScript file -->
<script src="<?php echo $base_url; ?>js/menu.js"></script>