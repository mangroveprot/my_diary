<?php
include('../database/models/diaries_model.php');

class DeleteDiaryController {
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function deleteDiary() {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $diary_id = $_GET['id'];
            $diary = new Diaries();
            try {
                // Delete the diary entry
                $deleted = $diary->deleteDiary($diary_id);
                if ($deleted) {
                    $_SESSION['notification'] = "Diary successfully deleted!";
                    $this->redirectToReadDiaries();
                } else {
                    $_SESSION['err_message'] = "Failed to delete diary.";
                    $this->redirectToViewDiaries($diary_id);
                }
            } catch (Exception $e) {
                $_SESSION['err_message'] = "Error: " . $e->getMessage();
                $this->redirectToViewDiaries($diary_id);
            }
        } else {
            $_SESSION['err_message'] = "Invalid request.";
            $this->redirectToReadDiaries();
        }
    }

    private function redirectToReadDiaries() {
        header("Location: read-diaries.php");
        exit();
    }

    private function redirectToViewDiaries($diary_id) {
        header("Location: view-diaries.php?id=$diary_id");
        exit();
    }
}

$deleteDiaryController = new DeleteDiaryController();
$deleteDiaryController->deleteDiary();
?>