<?php
include('../database/models/diaries_model.php');

class EditDiaryController {
    private $error_message = "";

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function editDiary() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diary_id'], $_POST['title'], $_POST['content'])) {
            $diary_id = $_POST['diary_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            if (empty($diary_id) || empty($title) || empty($content)) {
                $_SESSION['err_message'] = "Diaries' ID, Title, and Content must be valid and not empty!";
                $this->redirectWithError($diary_id);
            }

            $diary = new Diaries();
            try {
                $diary->editDiary($diary_id, $title, $content);
                $_SESSION['notification'] = "Diary successfully edited!";
                $this->redirectToViewDiaries($diary_id);
            } catch (Exception $e) {
                $_SESSION['err_message'] = "Error: " . $e->getMessage();
                $this->redirectWithError($diary_id);
            }
        }
    }

    private function redirectWithError($diary_id) {
        header("Location: view-diaries.php?id=$diary_id");
        exit();
    }

    private function redirectToViewDiaries($diary_id) {
        header("Location: view-diaries.php?id=$diary_id");
        exit();
    }
}

$editDiaryController = new EditDiaryController();
$editDiaryController->editDiary();
?>