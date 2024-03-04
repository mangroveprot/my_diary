<?php
require_once 'database/dbModel.php';

$user = new User($conn);

$username = 'john_doe';
$password = 'password123';

if ($user->loginUser($username, $password)) {
    echo "Login successful!";
} else {
    echo "Invalid username or password!";
}
?>