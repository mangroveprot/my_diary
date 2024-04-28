<?php
require_once dirname(__DIR__) . '/database/models/diaries_model.php';

class DiaryView
{
    private $diary_id;
    private $title;
    private $content;
    private $date_created;
    private $error_message;

    public function __construct()
    {

        $this->error_message = '';

        if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['diary-id']) || isset($_GET['id']))) {
            $this->diary_id = $_GET['id'] ?? $_GET['diary-id'];
            $this->fetchDiaryData();
        } else {
            $this->error_message = "Can't find content for this Diary.";
        }

    }

    private function fetchDiaryData()
    {
        $diary = new Diaries();
        try {
            $diaryData = $diary->getDiaryByID($this->diary_id);
            if ($diaryData) {
                $this->title = $diaryData['title'];
                $this->content = $diaryData['content'];
                $this->date_created = $diaryData['diary_datetime_created'];
            } else {
                $this->error_message = "Diary not found.";
            }
        } catch (Exception $e) {
            $this->error_message = "Error: " . $e->getMessage();
        }
    }

    // Getter methods to access private properties
    public function getDiaryId()
    {
        return $this->diary_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }
}
?>