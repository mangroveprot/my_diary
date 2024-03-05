<?php
session_start();
unset($_SESSION['uid']);
echo header("Location: login.php");