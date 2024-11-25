<?php
require 'php/config.php'; // Include database connection
$page_title = "Welcome to Muse"; // Define the title

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if a category is selected via GET, default to 'default'
$category = isset($_GET['category']) ? $_GET['category'] : 'default';

try {
    // Fetch a random prompt based on the selected category
    if ($category === 'default') {
        $stmt = $pdo->query("SELECT prompt_text FROM prompts ORDER BY RAND() LIMIT 1");
    } else {
        $stmt = $pdo->prepare("SELECT prompt_text FROM prompts WHERE category = :category ORDER BY RAND() LIMIT 1");
        $stmt->execute(['category' => $category]);
    }
    $prompt = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching prompt: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Art Sharing App - Home</title>
</head>
<body>
    <!-- Navigation Menu -->
    <?php include 'php/menu.php'; ?>




    <!-- Prompt Generator -->
    <section>
        <h2>Generate a Random Art Prompt</h2>

        <form method="GET" action="index.php">
            <label for="category">Choose a category:</label>
            <select name="category" id="category">
                <option value="default" <?php echo ($category === 'default') ? 'selected' : ''; ?>>Default</option>
                <?php
                // Fetch categories dynamically
                try {
                    $stmt = $pdo->query("SELECT DISTINCT category FROM prompts");
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $cat) {
                        $catName = $cat['category'];
                        echo '<option value="' . htmlspecialchars($catName) . '" ' . (($category === $catName) ? 'selected' : '') . '>' . htmlspecialchars($catName) . '</option>';
                    }
                } catch (PDOException $e) {
                    echo '<option value="">Error loading categories</option>';
                }
                ?>
            </select>
            <button type="submit">Generate Prompt</button>
        </form>

        <?php if (!empty($prompt) && isset($prompt['prompt_text'])): ?>
            <p><strong>Your Prompt:</strong> <?php echo htmlspecialchars($prompt['prompt_text']); ?></p>
        <?php else: ?>
            <p><strong>Your Prompt:</strong> No prompt available. Try selecting a different category or ensure the database has data.</p>
        <?php endif; ?>
    </section>
</body>
</html>
