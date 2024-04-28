<?php
if (isset($_SESSION)) {
    session_start();
}
include_once ('../../server/auth/signup.php');
$signup = new SignUpPage();
$result = $signup->handleSignup();
$error = isset($result['error']) ? $result['error'] : '';
$username = $_POST['username'] ?? '';
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$middleName = $_POST['middle_name'] ?? '';
$gender = $_POST['gender'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <?php include ('../includes/navbar.php'); ?>
    <div class="signup-box">
        <h2>Sign Up</h2>
        <p id="error_message" class="error_type">
            <?php echo htmlspecialchars($error); ?>
        </p>
        <?php
        //If account created successfully it will show this paragraph 
        if (isset($result['status']) && $result['status'] === true): ?>
            <p class="success-message">Account created successfully! <a href="login_page.php">Click here to log in</a></p>
            <?php exit(); ?>
        <?php endif;
        //End
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            onsubmit="return SignUpValidateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"><br><br>

            <label for="password">Password:</label>
            <div class="password-input">
                <input type="password" id="password" name="password">
                <span id="togglePassword" class="eye-toggle bi bi-eye-slash"></span>
            </div><br>

            <label for="confirm_pass">Confirm Password:</label>
            <div class="password-input">
                <input type="password" id="confirm_pass" name="confirm_pass">
                <span id="toggleConfirmPassword" class="eye-toggle bi bi-eye-slash"></span>
            </div><br>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name"
                value="<?php echo htmlspecialchars($firstName); ?>"><br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name"
                value="<?php echo htmlspecialchars($lastName); ?>"><br><br>

            <label for="middle_name">Middle Name:</label>
            <input type="text" id="middle_name" name="middle_name"
                value="<?php echo htmlspecialchars($middleName); ?>"><br><br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="male" <?php if ($gender === 'male')
                    echo 'selected="selected"'; ?>>Male</option>
                <option value="female" <?php if ($gender === 'female')
                    echo 'selected="selected"'; ?>>Female</option>
                <option value="other" <?php if ($gender === 'other')
                    echo 'selected="selected"'; ?>>Other</option>
            </select><br><br>

            <button class="button-33" role="button" type="submit" name="submit">Sign-Up </button>
        </form>
        <p>Already have an account? <a href="login_page.php">Log In</a></p>
    </div>
</body>
<script src="../assets/index.js"></script>

</html>