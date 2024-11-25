<?php
require 'config.php'; // Include the database connection
$page_title = "Explore Prompts"; // Page-specific title
$category = $_GET['category'] ?? 'All'; // Get selected category or default to 'All'

try {
    // Fetch distinct categories for the dropdown menu
    $stmt = $pdo->query("SELECT DISTINCT category FROM prompts");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch prompts based on selected category
    if ($category === 'All') {
        $stmt = $pdo->query("SELECT * FROM prompts");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM prompts WHERE category = :category");
        $stmt->execute(['category' => $category]);
    }
    $prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching prompts: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Adjusted path -->
    <title>Explore Prompts</title>
</head>
<body>
    <?php include 'menu.php'; ?>
   

   

    <!-- Category Filter -->
    <section>
        <form method="GET" action="explore_prompts.php" class="filter-form">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category">
                <option value="All" <?php echo $category === 'All' ? 'selected' : ''; ?>>All</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                        <?php echo $category === $cat['category'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['category']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Apply Filter</button>
        </form>
    </section>

    <!-- Display Prompts -->
    <section class="prompts-container">
        <?php if (!empty($prompts)): ?>
            <?php foreach ($prompts as $prompt): ?>
                <div class="prompt-card">
                    <h3><?php echo htmlspecialchars($prompt['category']); ?></h3>
                    <p><?php echo htmlspecialchars($prompt['prompt_text']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No prompts available in this category.</p>
        <?php endif; ?>
    </section>
</body>
</html>
