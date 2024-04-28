<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once '../../server/app/write-diaries.php';
include ('../../server/app/view-diaries.php');

$writeDiaryController = new WriteDiaryController();
$diaryView = new DiaryView();


$uid = $_SESSION['uid'] ?? null;
$firstname = $_SESSION['first_name'] ?? null;

if (!isset($_SESSION['uid'])) {
  header('Location: homepage.php');
  exit;
}

$diaryID = $_GET['diary-id'] ?? null;
if (!isset($diaryID)) {
  $writeDiaryController->writeDiary();
}
?>

<?php include ('../includes/header.php'); ?>

<body>
  <?php include ('../includes/navbar.php'); ?>
  <div class="transparent-boxx">
    <!--Error Message -->
    <p id="error_message" class="error_type"></p>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
      <h3 style="color: gray"><?php echo isset($diaryID) ? "Edit Diary" : "What's On Your Mind?" ?></h3>
    </div>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
      <div class="transparent-boxx">
        <div class="card" style="width: 60vw; ">
          <div class="row justify-content-center">
            <div class="card-body">

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                onsubmit="return SubmitEntryValidation()" id="writeDiary" method="POST">
                <input type="hidden" name="diaryID" value="<?php echo $diaryID; ?>">
                <label for="title">
                </label>
                <div class="input-group input-group-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-lg">Title:</span>
                  </div>
                  <input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm"
                    name="title"
                    value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : (isset($diaryID) ? $diaryView->getTitle() : ''); ?>"
                    placeholder="Enter Your Title Here">
                </div>
                <textarea id="editor" name="content"> <?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : (isset($diaryID) ? $diaryView->getContent() : ''); ?>
                </textarea>
                <div class="card-footer text-muted">
                  <?php if (isset($diaryID)): ?>
                    <button type="submit" class="btn btn-success save_changes" data-id="<?php echo $diaryID; ?>">Save
                      Changes</button>
                  <?php else: ?>
                    <button type="submit" class="btn btn-success">Submit</button>
                  <?php endif; ?>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
</body>
<script src="../assets/index.js"></script>
<script>
  $(document).ready(function () {
    $("#editor").editor();


    $(document).on('click', '.save_changes', function () {
      $('#writeDiary').submit(function (event) {
        event.preventDefault();
        var dID = '<?php echo $diaryID; ?>';
        var formData = $(this).serialize();
        $.ajax({
          url: '../../server/app/edit-diaries.php',
          type: 'post',
          data: formData,
          success: function (response) {
            console.log(response);
            if (response == 0) {
              window.location.href = 'view_diary_page.php?id=' + dID;
            } else {
              console.log(response);
              window.location.href = 'view_diary_page.php?id=' + dID;
            }
          },
          error: function (xhr, status, error) {
            console.error(error);
          }
        });

      });
    });
  });
</script>

</html>