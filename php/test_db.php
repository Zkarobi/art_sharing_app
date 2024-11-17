<?php
require 'config.php'; // Include the database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Display all table names in the database
    $stmt = $pdo->query("SHOW TABLES");
    echo "<h3>Tables in the Database:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Table: " . implode(", ", $row) . "<br>";
    }

    echo "<h3>Prompts Table Content:</h3>";
    // Query the `prompts` table to fetch all data
    $stmt = $pdo->query("SELECT * FROM prompts");
    $prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($prompts)) {
        // Display each prompt in a readable format
        foreach ($prompts as $prompt) {
            echo "Prompt ID: " . htmlspecialchars($prompt['prompt_id']) . "<br>";
            echo "Category: " . htmlspecialchars($prompt['category']) . "<br>";
            echo "Prompt Text: " . htmlspecialchars($prompt['prompt_text']) . "<br><br>";
        }
    } else {
        echo "No prompts found in the database.";
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>
