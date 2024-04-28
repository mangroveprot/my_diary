<?php

 //require dirname(__DIR__, 2) . '/database/db_connection.php';

require_once dirname(__DIR__) . '/db_connection.php';

$conn = connections();
class User
{
  //Sign-up
    public function createAccount($username, $password, $firstName, $lastName, $middleName = null, $gender)
    {
        global $conn;
        try {
            $sql = "INSERT INTO users (username, password, first_name, last_name, middle_name, gender) 
                    VALUES (:username, :password, :firstName, :lastName, :middleName, :gender)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":firstName", $firstName);
            $stmt->bindParam(":lastName", $lastName);
            $stmt->bindParam(":middleName", $middleName);
            $stmt->bindParam(":gender", $gender);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to create account.");
            }
        } catch (PDOException $e) {
            throw new Exception("Sign-Up error: " . $e->getMessage());
        }
    }
    
    //Sign-in
    public function loginUser($username, $password)
      {
      global $conn;
      try {
          $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(":username", $username);
          $stmt->bindParam(":password", $password);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
          if (!$result) {
              return false; 
          }
  
          $_SESSION['uid'] = $result['uid'];
          $_SESSION['first_name'] = $result['first_name'];
          $_SESSION['last_name'] = $result['last_name'];
  
          return true;
      } catch (PDOException $e) {
          throw new Exception("Log-in error: " . $e->getMessage());
      }
}

    public function getUsers()
    {
        global $conn;
        try {
            $sql = "SELECT * FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            throw new Exception("Error while fetching users: " . $e->getMessage());
        }
    }
}
?>