<?php
function connections()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "my_diarys";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>