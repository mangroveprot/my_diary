<?php
include('../database/models/diaries_model.php');

class WriteDiaryController {
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['uid'])) {
            header('Location: ../auth/login.php');
            exit;
        }
    }

    public function writeDiary() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $uid = $_SESSION['uid'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $diary = new Diaries();

            try {
                $diary->writeDiary($uid, $title, $content);
                $_SESSION['notification'] = "Diary entry successfully submitted!";
                $this->redirectToHomepage();
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
            }
        } 
    }

    private function redirectToHomepage() {
        header('Location: homepage.php');
        exit;
    }

    public function renderView() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Write Diary</title>
            <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
        </head>
        <body>
          <button class="btn"><a href="homepage.php">Back To Home</a></button>
        
        <h2>Write Diary</h2>

        <?php
        if(isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required><br><br>

            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="4" cols="50" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea><br><br>

            <button type="submit">Submit</button>
        </form>

        </body>
        </html>
        <?php
    }
}

$writeDiaryController = new WriteDiaryController();
$writeDiaryController->writeDiary();
$writeDiaryController->renderView();
?>