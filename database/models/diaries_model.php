<?php
 require dirname(__DIR__, 2) . '/database/db_connection.php';

class Diaries {
  private $conn;

  public function __construct() {
    $this->conn = connections();
  }

  // Get All Diaries From That Particular UID
  public function getDiariesByUid($uid) {
    try {
      if (empty($uid)) {
        throw new Exception("Empty uid provided.");
      }

      $sql = "SELECT u.username, d.title, d.content, d.diary_datetime_created, d.diary_id
                    FROM users u
                    LEFT JOIN diaries_data d ON u.uid = d.uid
                    WHERE u.uid = :uid";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
      $stmt->execute();

      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $data;
    } catch (Exception $e) {
      throw $e;
    }
  }

  // Get Diary By ID
  public function getDiaryByID($diary_id) {
    try {
      if (empty($diary_id)) {
        throw new Exception("Empty diary ID provided.");
      }

      $sql = "SELECT u.username, d.title, d.content, d.diary_datetime_created
                    FROM users u
                    LEFT JOIN diaries_data d ON u.uid = d.uid
                    WHERE d.diary_id = :diary_id";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':diary_id', $diary_id, PDO::PARAM_INT);
      $stmt->execute();

      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      return $data;
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  // Write a New Diary Entry
  public function writeDiary($uid, $title, $content) {
    try {
      if (empty($uid) || empty($title) || empty($content)) {
        throw new Exception("Empty uid, title, or content provided.");
      }

      $datetime_created = date('Y-m-d H:i:s');
      $sql = "INSERT INTO diaries_data (uid, title, content, diary_datetime_created)
                    VALUES (:uid, :title, :content, :datetime_created)";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':content', $content, PDO::PARAM_STR);
      $stmt->bindParam(':datetime_created', $datetime_created, PDO::PARAM_STR);
      $stmt->execute();

      return true;
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  // Edit Diary By ID
  public function editDiary($diary_id, $title, $content) {
    try {
      if (empty($diary_id) || empty($title) || empty($content)) {
        throw new Exception("Empty diary ID, title, or content provided.");
      }
  
      $sql = "UPDATE diaries_data 
              SET title = :title, content = :content
              WHERE diary_id = :diary_id";
  
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':diary_id', $diary_id, PDO::PARAM_INT);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':content', $content, PDO::PARAM_STR);
      $stmt->execute();
  
      return true;
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  // Delete Diary By ID
public function deleteDiary($diary_id) {
    try {
        if (empty($diary_id)) {
            throw new Exception("Empty diary ID provided.");
        }

        $sql = "DELETE FROM diaries_data WHERE diary_id = :diary_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':diary_id', $diary_id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (Exception $e) {
        throw $e;
    }
}

}


// Example usage
/*
$diariesManager = new Diaries();
$diariesManager->getDiariesByUid($uid);
$diariesManager->writeDiary($uid, $title, $content);
*/

?>