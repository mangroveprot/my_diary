<?php
if(!isset($_SESSION)) {
    session_start();
}
$uid = $_SESSION['uid'];
$firstname = $_SESSION['first_name'];
echo  "HeLLO" . " " . $uid . "<br/> ". $firstname ;
?>