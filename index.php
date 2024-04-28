<?php
//Set a landing page here!
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['uid'])) {
    header('Location: client/pages/homepage.php');
    exit;
}
header("Location: client/pages/login_page.php");
?>
