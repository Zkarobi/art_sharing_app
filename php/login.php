<?php
require 'config.php'; // Include the database connection
session_start(); // Start a session for user login

$errors = []; // Initialize an array to store error messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize inputs
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Proceed if there are no errors
    if (empty($errors)) {
        try {
            // Fetch the user from the database
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Password is correct, log the user in
                $_SESSION['username'] = $user['username'];
                header("Location: ../profile.php"); // Redirect to the homepage
                exit;
            } else {
                $errors[] = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body>
<?php include 'menu.php'; ?>

    <header>
    <h1>Login</h1>
    </header>

    <!-- Display errors if any -->
    <?php if (!empty($errors)): ?>
        <div class="errors" style="display: block;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Login form -->
    <section>
    <form method="POST" action="login.php" novalidate>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    </section>
    <script src="../js/login_validation.js"></script>
</body>
</html>
