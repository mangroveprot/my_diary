<?php
require_once dirname(__DIR__) . '/database/models/diaries_model.php';
class MyDiariesPage
{
  private $diaryModel;

  public function __construct()
  {
    $this->diaryModel = new Diaries();
  }

  public function getDiaries()
  {
    $uid = $_SESSION['uid'];
    return $this->diaryModel->getDiariesByUid($uid);
  }

  public function findClosestMatch($diaries, $keyword)
  {
    $matchedDiaries = [];
    $keyword = strtolower($keyword);

    foreach ($diaries as $diary) {
      if (stripos($diary['title'], $keyword) !== false) {
        $matchedDiaries[] = $diary;
      }
    }

    return $matchedDiaries;
  }
}
?>