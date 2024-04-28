<?php
if (isset($_SESSION)) {
  session_start();
}

include ('../../server/auth/login.php');
$login_model = new LoginPage();
$result = $login_model->handleLogin();

if (isset($result['status']) && $result['status'] === true || isset($_SESSION['uid'])) {
  header("Location: homepage.php");
  exit();
} elseif (isset($result['error'])) {
  $error = $result['error'];
}

$username = isset($_POST["username"]) ? $_POST["username"] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body>
  <?php include ('../includes/navbar.php'); ?>
  <div class="login-box">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
      <p class="error_type">
        <?php echo htmlspecialchars($error); ?>
      </p>
    <?php endif; ?>
    <div id="notification" class="error_type" style="display: none;">
      Username or password is required.
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
      onsubmit="return LoginValidateForm()">
      <label for="username">Username:</label><br>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"><br>

      <label for="password">Password:</label>
      <div class="password-input">
        <input type="password" id="password" name="password">
        <span id="togglePassword" class="eye-toggle bi bi-eye-slash"></span>
      </div>
      <button class="button-33" role="button" type="submit" name="submit">Log-in</button>

    </form>

    <p>
      Don't have an account? <a href="signup_page.php">Sign up</a>
    </p>
</body>
<script src="../assets/index.js"></script>

</html>