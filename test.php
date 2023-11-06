<?php
// Include necessary files and initialize the database connection
require_once("config.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user's email address from the form
    $email = $_POST["email"];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token (e.g., a random string)
        $token = bin2hex(random_bytes(32));

        // Store the token and timestamp in the database
        $sql = "INSERT INTO password_reset (email, token, timestamp) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $token, time()]);

        // Send a reset email with the token link
        $resetLink = "http://example.com/reset-password.php?token=" . $token;
        $to = $email;
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: webmaster@example.com\r\n";

        // Send the email
        mail($to, $subject, $message, $headers);

        // Redirect to a confirmation page
        header("Location: reset-link-sent.php");
        exit();
    } else {
        // If the email is not found, display an error message
        $error = "Email not found in our records.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <?php if (isset($error)) {
        echo "<p>$error</p>";
    } ?>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
