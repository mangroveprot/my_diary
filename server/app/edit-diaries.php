<?php
require_once dirname(__DIR__) . '/database/models/diaries_model.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diary = new Diaries();
    $diaryID = $_POST['diaryID'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $response = $diary->editDiary($diaryID, $title, $content);
    echo $response;
    exit;
}
?>