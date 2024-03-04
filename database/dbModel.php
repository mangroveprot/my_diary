<?php
require_once 'db_connection.php';
$conn =  connections();
class User {
    public function createAccount($username, $password, $firstName, $lastName, $middleName = null) {
        global $conn; // Access the global $conn variable
        $sql = "INSERT INTO users (username, password, first_name, last_name, middle_name) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $firstName, $lastName, $middleName);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function loginUser($username, $password) {
        global $conn; // Access the global $conn variable
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers() {
        global $conn; // Access the global $conn variable
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

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
