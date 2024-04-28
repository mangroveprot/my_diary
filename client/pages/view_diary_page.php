<?php
if (!isset($_SESSION)) {
    session_start();
}
$uid = $_SESSION['uid'] ?? null;
$firstname = $_SESSION['first_name'] ?? null;
$dID = $_GET['id'] ?? null;
include ('../../server/app/view-diaries.php');

if (!isset($_SESSION['uid'])) {
    header('Location: login_page.php');
    exit;
}
$diaryView = new DiaryView();
?>

<?php include ('../includes/header.php'); ?>

<body>
    <?php include ('../includes/navbar.php'); ?>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center" style="width: 80vw;">
            <div class="card-body">
                <form action="">
                    <input type="hidden" class="dID" value="<?php echo $dID; ?>">

                    <h5 class="card-title"><?php echo $diaryView->getTitle(); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $diaryView->getDateCreated(); ?></h6>
                    <hr>
                    <p class="card-text"><?php echo $diaryView->getContent(); ?></p>
                    <hr>
                    <button class="btn btn-sm btn-outline-success edit_diaries" type="button"
                        data-diary-id="<?php echo $dID ?>">
                        Edit</button>
                    <button type="button" id="delete_diary" class="btn btn-sm btn-outline-danger"
                        data-target=".delete_diary_modal">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editButtons = document.querySelectorAll('.edit_diaries');

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var dID = this.getAttribute('data-diary-id');
                    window.location.href = 'write_diary_page.php?diary-id=' + dID;
                });
            });
        });
        $(document).on('click', '#delete_diary', function () {
            var dID = $('input.dID').val();
            $.ajax({
                url: '../subpages/manager/modals.php',
                type: 'post',
                data: { dID: dID },
                success: function (response) {
                    $('.modal-body').html(response);
                    $('.modal-title').text('Update Diary');
                    $('#empModal').modal('show');
                }
            });
        });
    </script>
    <div class="modal fade" id="empModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
</body>

</html>