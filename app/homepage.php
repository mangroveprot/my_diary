<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['uid'])) {
  header('Location: ../auth/login.php');
  exit;
}
$firstname = $_SESSION['first_name'];
echo "Log-In As: " . $firstname;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Homepage</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <?php include('../includes/messageHandler.php'); 
  ?>
  <p>
    <a href="../auth/logout.php">Log-out</a>
  </p>
  <p>
    <a href="read-diaries.php">Read Diary</a>
  </p>
  <p>
    <a href="write-diaries.php">Write Diary</a>
  </p>
</body>
</html>