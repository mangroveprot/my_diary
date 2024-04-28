<?php
if (!isset($_SESSION)) {
  session_start();
}
$uid = $_SESSION['uid'] ?? null;
$firstname = $_SESSION['first_name'] ?? null;
if (!isset($_SESSION['uid'])) {
  header('Location: homepage.php');
  exit;
}
include ('../../server/app/read-diaries.php');

$page = new MyDiariesPage();
$diaries = $page->getDiaries();
$i = 0;
?>

<?php include ('../includes/header.php'); ?>
<style>
  .items {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-content: flex-start;
    justify-content: center;
  }

  .card {
    max-width: calc(80% - 1rem);
  }

  .search-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;
    margin-bottom: 2rem
  }
</style>

<body>
  <?php include ('../includes/navbar.php'); ?>

  <div class="search-bar">
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="search" type="search" placeholder="Search" aria-label="Search"
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>

  <!--Search Handler -->
  <?php
  if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $matchedDiaries = $page->findClosestMatch($diaries, $searchKeyword);
  } else {
    $matchedDiaries = $diaries;
  }

  $hasContent = false;
  foreach ($matchedDiaries as $diary) {
    if (!empty($diary['content'])) {
      $hasContent = true;
      break;
    }
  }

  if (!$hasContent) {
    echo '
    <div class="no_content"><h2>No Diaries found!</h2></div>
    ';
  } else {
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
      <div class="card text-center" style="width: 90vw; height: auto;">
        <div class="card-header">
          <h4>My Diaries
            <h4>
        </div>
        <div class="card-body items">
          <?php foreach ($matchedDiaries as $diary):
            $i++ ?>
            <div class="card bg-light mb-3" style="max-width: 18rem;">
              <div class="card-header"># <?php echo $i; ?></div>
              <div class="card-body">
                <span><i class='bx bxs-notepad'></i>Title: <b>"<?php echo $diary['title']; ?>"</b></span>
                <hr>
                <p class="card-text"><i class='bx bxs-calendar'></i> <?php echo $diary['diary_datetime_created']; ?></p>
                <a href="view_diary_page.php?id=<?php echo $diary['diary_id']; ?>">View</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="card-footer text-muted">

        </div>
      </div>
    </div>

    <?php
  }
  ?>
</body>

<script src="../assets/index.js"></script>

</html>