<?php
/*
// Path Checker
$file_path = dirname(__DIR__) . '/database/models/users_model.php';

if (file_exists($file_path)) {
    echo "The file exists.";
    return;
} else {
    echo "The file does not exist.";
    return;
}
*/

require_once dirname(__DIR__) . '/database/models/users_model.php';

class LoginPage {
    private $userModel;

    public function __construct() {
        session_start();
        $this->userModel = new User();
    }

    public function handleLogin() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            $user = $this->userModel->loginUser($username, $password);

            if ($user) {
                return ['status' => true];
            } else {
                throw new Exception("Invalid username or password!");
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    return null;
  }
}
?>