<?php
include('../database/models/diaries_model.php');

class MyDiariesPage {
  private $diaryModel;

  public function __construct() {
    session_start();
    if (!isset($_SESSION['uid'])) {
      header('Location: ../auth/login.php');
      exit;
    }
    $this->diaryModel = new Diaries();
  }

  public function displayDiaries() {
    try {
      $uid = $_SESSION['uid'];
      $diaries = $this->diaryModel->getDiariesByUid($uid);
      $this->renderDiariesTable($diaries);
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
  private function findClosestMatch($diaries, $keyword) {
    $matchedDiaries = [];

    $keyword = strtolower($keyword);
    $firstLetter = substr($keyword, 0, 1);

    foreach ($diaries as $diary) {
      if (stripos($diary['title'], $keyword) === 0) {
        similar_text($diary['title'], $keyword, $percent);
        $diary['match_percent'] = $percent;
        $matchedDiaries[] = $diary;
      }
    }
    
    // If no direct matches are found, it then searches for matches with the first letter of the keyword in the title✨
    if (empty($matchedDiaries)) {
      foreach ($diaries as $diary) {
        if (stripos($diary['title'], $firstLetter) === 0) {
          similar_text($diary['title'], $firstLetter, $percent);
          $diary['match_percent'] = $percent;
          $matchedDiaries[] = $diary;
        }
      }
    }
     //Didn't find one
    if (empty($matchedDiaries)) {
      return [];
    }

    usort($matchedDiaries, function($a, $b) {
      return $b['match_percent'] <=> $a['match_percent'];
    });

    return $matchedDiaries;
  }

  private function renderDiariesTable($diaries, $search = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Diaries</title>
      <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
    </head>
    <body>
      <h2>My Diaries</h2>

      <?php include('../includes/messageHandler.php'); ?>
      <button class="btn"><a href="homepage.php">Back To Home</a></button>

      <!-- Search Bar -->
      <form method="GET">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
      </form>

      <!--Search Handler -->
      <?php
      if (isset($_GET['search']) && !empty($_GET['search'])) {
        try {
          $uid = $_SESSION['uid'];
          $searchKeyword = $_GET['search'];
          $matchedDiaries = $this->findClosestMatch($diaries, $searchKeyword);
        } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
        }
      } else {
        $matchedDiaries = $diaries;
      }
      //Also check if the users created atleast one diarys
      $hasContent = false;
      foreach ($matchedDiaries as $diary) {
        if (!empty($diary['content'])) {
          $hasContent = true;
          break;
        }
      }

      if (!$hasContent) {
        echo '<p>No Diarys found!</p>';
        return;
      }
      ?>

      <table>
        <thead>
          <tr>
            <th>Diary ID</th>
            <th>Title</th>
            <th>Date Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($matchedDiaries as $diary): ?>
          <tr>
            <td><?php echo $diary['diary_id']; ?></td>
            <td><?php echo $diary['title']; ?></td>
            <td><?php echo $diary['diary_datetime_created']; ?></td>
            <td><a href="view-diaries.php?id=<?php echo $diary['diary_id']; ?>">Read</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </body>
  </html>
    <?php
  }

}

$page = new MyDiariesPage();
$page->displayDiaries();
?>