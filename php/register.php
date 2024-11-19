<?php
require 'config.php'; // Include the database connection
session_start(); // Start a session for user login

$errors = []; // Initialize an array to store error messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Proceed if there are no errors
    if (empty($errors)) {
        try {
            // Check if the username or email already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->execute(['username' => $username, 'email' => $email]);
            $existing_user = $stmt->fetch();

            if ($existing_user) {
                $errors[] = "Username or email is already taken.";
            } else {
                // Insert the new user into the database
                $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => $hashed_password,
                ]);
                $_SESSION['username'] = $username; // Log the user in
                header("Location: ../index.php"); // Redirect to the homepage
                exit;
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
    <title>Register</title>
</head>
<body>
<?php include 'menu.php'; ?>

    <header>
        <h1>Register</h1>
    </header>

<!-- Display errors if any -->
<div class="errors" style="<?php echo empty($errors) ? 'display: block;' : ''; ?>">
    <ul>
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>


    <!-- Registration form -->
    <form id="registerForm" method="POST" action="register.php" novalidate>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <button type="submit">Register</button>
    </form>

    <script src="../js/validation.js"></script>

</body>
</html>
