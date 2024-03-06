<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'database/models/users_model.php';

$error = "";
$username = $firstName = $password = $confirm_password = $lastName = $middleName = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_pass"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $middleName = isset($_POST["middle_name"]) ? $_POST["middle_name"] : null;
    $gender = $_POST["gender"];

    if ($password !== $confirm_password) {
        $error = "Password and Confirm Password do not match.";
    } else {
        $userModel = new User();
        $success = true;//$userModel->createAccount($username, $password, $firstName, $lastName, $middleName, $gender);
        try {
            if (!$success) {
                throw new Exception("Account creation failed. Please check your input and try again.");
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

</head>

<body>
    <h2>Sign Up</h2>
    <?php
    if (!empty($success)) {
        echo '<p class="success-message">Account created successfully! <a href="login.php">Click here to log in</a></p>';
    } else {
        ?>
        <p class="error_type">
            <?php if (!empty($error)) {
                echo $error;
            } ?>
        </p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

            <label for="password">Password:</label>
            <div class="password-input">
                <input type="password" id="password" name="password" required>
                <span id="togglePassword" class="eye-toggle bi bi-eye-slash"></span>
            </div>
            <br>
            <label for="confirm_pass">Confirm Password:</label>
            <div class="password-input">
                <input type="password" id="confirm_pass" name="confirm_pass" required>
                <span id="toggleConfirmPassword" class="eye-toggle bi bi-eye-slash"></span>
            </div>
            <br>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required><br><br>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required><br><br>

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo htmlspecialchars($middleName); ?>"><br><br>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="male" <?php if ($gender === 'male')
                    echo 'selected="selected"'; ?>>Male</option>
                <option value="female" <?php if ($gender === 'female')
                    echo 'selected="selected"'; ?>>Female</option>
                <option value="other" <?php if ($gender === 'other')
                    echo 'selected="selected"'; ?>>Other</option>
            </select><br><br>

            <input type="submit" name="submit" id="submit" value="Sign Up">
        </form>
        <?php
    }
    ?>
</body>
<script src="assets/index.js"></script>

</html>