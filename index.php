<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['uid'])) {
    header('Location: app/homepage.php');
    exit;
}
header("Location: auth/login.php");
?>
