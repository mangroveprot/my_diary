<?php
$action = isset($_GET['action']) ? $_GET['action'] : null;
$diaryID = $_POST['dID'] ?? null;
?>

<span>Are you sure you want to delete this tenant?</span>
<div class="modal-footer">
    <button type="button" class="btn btn-danger deleteTenant">
        <span class="btn-text" data-id="<?php echo $diaryID; ?>">Delete</span>
    </button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

<script>
    $(document).ready(function () {
        $('.deleteTenant').click(function (event) {
            event.preventDefault();
            var diaryID = $(this).find('.btn-text').data('id');
            console.log(diaryID);
            $.ajax({
                url: '../../server/app/delete-diaries.php',
                type: 'post',
                data: { diaryID: diaryID },
                success: function (response) {
                    console.log(response);
                    if (response == 0) {
                        window.location.href = 'my_diary_page.php';
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>