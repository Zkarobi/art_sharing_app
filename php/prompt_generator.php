<?php
require 'config.php'; // Include the database connection file

// Check if a category is selected via the GET parameter, default to 'default' if none is selected
$category = isset($_GET['category']) ? $_GET['category'] : 'default';

try {
    // If the user selects "Default" (no category), fetch a completely random prompt
    if ($category === 'default') {
        $stmt = $pdo->query("SELECT `prompt text` FROM prompts ORDER BY RAND() LIMIT 1");
    } else {
        // If a specific category is selected, prepare a query to fetch a random prompt within that category
        $stmt = $pdo->prepare("SELECT `prompt text` FROM prompts WHERE category = :category ORDER BY RAND() LIMIT 1");
        $stmt->execute(['category' => $category]); // Bind the category value to the query
    }

    // Fetch the prompt as an associative array
    $prompt = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any database errors and stop execution if an error occurs
    die("Error fetching prompt: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Specify the character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Make the page responsive -->
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to the external CSS file for styling -->
    <title>Prompt Generator</title> <!-- Page title -->
</head>
<body>
    <h1>Art Prompt Generator</h1> <!-- Page header -->
    
    <!-- Form to select a category and generate a prompt -->
    <form method="GET" action="prompt_generator.php"> <!-- Use GET method to send the category selection -->
        <label for="category">Choose a category:</label>
        <select name="category" id="category"> <!-- Dropdown menu for category selection -->
            <option value="default">Default</option> <!-- Default option to fetch random prompts -->
            <option value="Animals">Animals</option> <!-- Fetch prompts from the "Animals" category -->
            <option value="Nature">Nature</option> <!-- Fetch prompts from the "Nature" category -->
            <!-- Add more categories here as needed -->
        </select>
        <button type="submit">Generate Prompt</button> <!-- Submit button to generate the prompt -->
    </form>

    <!-- Display the generated prompt if available -->
    <?php if (isset($prompt['prompt text'])): ?> <!-- Check if a prompt was retrieved -->
        <p><strong>Your Prompt:</strong> <?php echo htmlspecialchars($prompt['prompt text']); ?></p> <!-- Display the prompt -->
    <?php endif; ?>
</body>
</html>
