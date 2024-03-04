<?php
require_once 'database/database.php';

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createAccount($username, $password, $firstName, $lastName, $middleName = null) {
        $sql = "INSERT INTO users (username, password, first_name, last_name, middle_name) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $firstName, $lastName, $middleName);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function getUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }
}
?>