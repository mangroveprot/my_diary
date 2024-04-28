<?php
if (!isset($_SESSION)) {
  session_start();
}

$uid = $_SESSION['uid'] ?? null;
$firstname = $_SESSION['first_name'] ?? null;
?>

<?php include ('../includes/header.php'); ?>

<body>
  <?php include ('../includes/navbar.php'); ?>
  <div class="centered-content">
    <div class="transparent-box">
      <h2>Welcome to the free online diary</h2>
      <img src="../assets/logo.png" alt="Diary Logo" class="diary-logo">
      <p class="background-text"> <br>This is an online diary service, providing personal diaries and journals - it's
        free at
        my-diary.org! Our focus is on security and privacy, and all diaries are private by default. <br>Go ahead and
        register your own public or private diary today.<br>

        Writing a daily record of your life is a good way to make sure your memories and experiences stay alive.<br> It
        lets
        you keep track and reflect on your past and learn from your mistakes. It can also be tremendously
        therapeutic.<br> Not only to record fun and adventurous moments, but also sad and scary times. It can be
        helpful
        to be able to document changes in your life in an online journal.</p>
    </div>
  </div>

  <div class="footer">
    <!--Whoever you are add footer for my credentials ｡⁠:ﾟ⁠(⁠;⁠´⁠∩⁠`⁠;⁠)ﾟ⁠:-->
  </div>
</body>
<script src="../assets/index.js"></script>

</html>