<?php
require_once 'database/models/users_model.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['uid'])) {
    header('Location: homepage.php');
    exit;
}

$userModel = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $user = $userModel->loginUser($username, $password);

        if ($user) {
            header("Location: homepage.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } catch (Exception $e) {
        $error = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p>
            <?php echo $error; ?>
        </p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>

</html>