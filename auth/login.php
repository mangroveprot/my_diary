<?php
// Path Checker
/*
$file_path = '../database/models/users_model.php';

if (file_exists($file_path)) {
    echo "The file exists.";
    return;
} else {
    echo "The file does not exist.";
    return;
}
*/

require_once '../database/models/users_model.php';

class LoginPage {
    private $userModel;

    public function __construct() {
        session_start();
        if (isset($_SESSION['uid'])) {
            header('Location: ../app/homepage.php');
            exit;
        }

        $this->userModel = new User();
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            try {
                $user = $this->userModel->loginUser($username, $password);

                if ($user) {
                    header("Location: ../app/homepage.php");
                    exit;
                } else {
                    $error = "Invalid username or password!";
                }
            } catch (Exception $e) {
                $error = "An error occurred: " . $e->getMessage();
            }
        }

        return isset($error) ? $error : null;
    }

    public function displayLoginForm($error = null, $username = '') {
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
            <h2>Login</h2>
            <?php if ($error): ?>
                <p class="error_type"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div id="notification" class="error_type" style="display: none;">Username or password is required.</div>
            
            <form action="login.php" method="POST" onsubmit="return validateForm()">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"><br>
                
                <label for="password">Password:</label>
                <div class="password-input">
                    <input type="password" id="password" name="password">
                    <span id="togglePassword" class="eye-toggle bi bi-eye-slash"></span>
                </div>
                    
                <input type="submit" name="submit" value="Login">
            </form>
        
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </body>
        <script src="../assets/index.js"></script>
        <script>
            function validateForm() {
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;
        
                if (username === "" || password === "") {
                    document.getElementById("notification").style.display = "block";
                    return false;
                } else {
                    document.getElementById("notification").style.display = "none";
                    return true;
                }
            }
        </script>
        </html>
        <?php
    }
}

$page = new LoginPage();
$error = $page->handleLogin();
$page->displayLoginForm($error);
?>