<?php
require 'config.php'; // Include the database connection

// Simple query to test connection
try {
    $stmt = $pdo->query("SELECT * FROM prompts LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Database connection successful! Sample prompt: " . $row['prompt text'];
    } else {
        echo "Database connection successful, but no data found in the prompts table.";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>
