<?php
require_once 'database/db_connection.php';
$conn =  connections();
class User {
    public function createAccount($username, $password, $firstName, $lastName, $middleName = null, $gender) {
        global $conn;
        $sql = "INSERT INTO users (username, password, first_name, last_name, middle_name, gender) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $firstName, $lastName, $middleName, $gender);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function loginUser($username, $password) {
        global $conn;
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            return true;
        } else {
            return false;
        }
    }

    public function getUsers() {
        global $conn;
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
