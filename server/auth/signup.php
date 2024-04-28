<?php
require_once dirname(__DIR__) . '/database/models/users_model.php';

class SignUpPage {
    
    public function handleSignUp() {
      try {
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
              $username = $_POST["username"];
              $password = $_POST["password"];
              $confirm_password = $_POST["confirm_pass"];
              $firstName = $_POST["first_name"];
              $lastName = $_POST["last_name"];
              $middleName = isset($_POST["middle_name"]) ? $_POST["middle_name"] : null;
              $gender = $_POST["gender"];
  
              if ($password !== $confirm_password) {
                  throw new Exception("Passwords do not match.");
              } else {
                  $userModel = new User();
                  $success = $userModel->createAccount($username, $password, $firstName, $lastName, $middleName, $gender);
                  if (!$success) {
                      throw new Exception("Account creation failed. Please check your input and try again.");
                  }
                  return ['status' => true];
              }
          }
      } catch (Exception $e) {
          return ['error' => $e->getMessage()];
      }
      return "";
  }
}
?>