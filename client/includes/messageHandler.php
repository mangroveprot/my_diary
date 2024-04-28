<?php
if (!isset($_SESSION)) {
    session_start();
}

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : '';
unset($_SESSION['notification']);

$error_message = isset($_SESSION['err_message']) ? $_SESSION['err_message'] : '';
unset($_SESSION['err_message']);

if (!empty($notification)) {
    echo '<p class="notify">' . $notification . '</p>';
}

if (!empty($error_message)) {
    echo '<p class="error_type">' . $error_message . '</p>';
}
?>

<script>
    function hideMessages() {
        var notifications = document.querySelectorAll('.notify, .error_type');
        notifications.forEach(function(notification) {
            setTimeout(function() {
                notification.style.display = 'none';
            }, 5000);
        });
    }
    window.onload = hideMessages; 
</script>