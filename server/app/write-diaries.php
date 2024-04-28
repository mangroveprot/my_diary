<?php
require_once dirname(__DIR__) . '/database/models/diaries_model.php';

class WriteDiaryController
{
    private $diary;

    public function __construct()
    {
        $this->diary = new Diaries();
    }

    public function writeDiary()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $uid = $_SESSION['uid'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            try {
                $this->diary->writeDiary($uid, $title, $content);
                $_SESSION['notification'] = "Diary entry successfully submitted!";
                $this->redirectToHomepage();
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
            }
        }
    }

    private function redirectToHomepage()
    {
        header('Location: my_diary_page.php');
        exit;
    }
}
?>