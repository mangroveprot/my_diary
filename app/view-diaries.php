<?php
include('../database/models/diaries_model.php');

class DiaryView {
    private $diary_id;
    private $title;
    private $content;
    private $date_created;
    private $error_message;

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['uid'])) {
            header('Location: ../auth/login.php');
            exit;
        }

        $this->error_message = '';

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $this->diary_id = $_GET['id'];
            $this->fetchDiaryData();
        } else {
            $this->error_message = "Invalid request.";
        }
    }

    private function fetchDiaryData() {
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

    public function displayDiary() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Diary</title>
            <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
            <style>
                /* Modal style */
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgba(0,0,0,0.4);
                }

                /* Modal content */
                .modal-content {
                    background-color: #fefefe;
                    margin: 15% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                }

                .edit-modal-content {
                    background-color: #fefefe;
                    margin: 5% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                    height: 80%;
                    overflow: auto;
                }

                #editTitle {
                    width: 80%;
                    padding: 10px;
                    font-size: 20px;
                    margin-bottom: 15px;
                }

                #editContent {
                    width: 80%;
                    height: 200px;
                    padding: 10px;
                    font-size: 18px;
                    margin-bottom: 15px;
                    resize: none;
                }

                /* Close button */
                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
            </style>
        </head>
        <body>
        <button class="btn"><a href="read-diaries.php">Back</a></button>
        <?php include('../includes/messageHandler.php'); ?>
        
        <?php if (!empty($this->title)): ?>
            <h2><?php echo $this->title; ?></h2>
            <p><?php echo $this->content; ?></p>
            <p>Date Created: <?php echo $this->date_created; ?></p>

            <button onclick="openEditModal()">Edit</button>
            <!-- Edit modal -->
            <div id="editModal" class="modal">
                <div class="edit-modal-content">
                    <span class="close" onclick="closeEditModal()">&times;</span>
                    <form id="editForm" action="edit-diaries.php" method="post">
                        <input type="hidden" name="diary_id" value="<?php echo $this->diary_id; ?>">
                        <label for="editTitle">Title:</label><br>
                        <input type="text" id="editTitle" name="title" value="<?php echo $this->title; ?>"><br>
                        <label for="editContent">Content:</label><br>
                        <textarea id="editContent" name="content"><?php echo $this->content; ?></textarea><br>
                        <input type="submit" value="Save Changes">
                    </form>
                </div>
            </div>

            <button onclick="openDeleteModal()">Delete</button>
            <!-- Delete modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeDeleteModal()">&times;</span>
                    <p>
                        Title: "<?php echo $this->title; ?>" <br><br>
                        Are you sure you want to delete this diary?
                    </p>
                    <button onclick="deleteDiary()">Delete</button>
                    <button onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openEditModal() {
                    document.getElementById("editModal").style.display = "block";
                }

                function closeEditModal() {
                    document.getElementById("editModal").style.display = "none";
                }

                function openDeleteModal() {
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function deleteDiary() {
                    window.location.href = "delete-diaries.php?id=<?php echo $this->diary_id; ?>";
                }
            </script>
        <?php endif; ?>

        </body>
        </html>
        <?php
    }
}

$diaryView = new DiaryView();
$diaryView->displayDiary();
?>