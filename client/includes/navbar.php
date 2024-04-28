<div class="navbars">
    <a href="homepage.php">Home</a>
    <?php if (isset($uid)): ?>
        <a href="my_diary_page.php">Read Diary</a>
        <a href="write_diary_page.php">Write Diary</a>
        <a href="logout.php" style="float: right;">Log-out</a>
        <span style="float: right; color: white; padding: 14px 16px;">Log-In As: <?php echo $firstname; ?></span>
    <?php else: ?>
        <a href="login_page.php">Log-in</a>
        <a href="signup_page.php">Sign-up</a>
    <?php endif; ?>

</div>

<?php
//Responsible for any notifications to display if it has a value to set.
include ('messageHandler.php'); ?>