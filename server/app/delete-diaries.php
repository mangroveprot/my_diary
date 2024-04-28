<?php
session_start();
include ('../database/models/diaries_model.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diaryID = $_POST['diaryID'];
    $diary = new Diaries();
    $response = $diary->deleteDiary($diaryID);
    echo $response;
    exit;
}
