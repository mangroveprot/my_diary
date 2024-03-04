<?php
require 'database/db_connection.php';

$conn = connections();

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["uid"]. " - Name: " . $row["first_name"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
