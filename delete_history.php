<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['history_id'])) {
      $historyId = $_POST['history_id'];

      //DELETE query to delete the entire row
      $deleteSql = "DELETE FROM todo_history WHERE id = ?";


      $stmt = $conn->prepare($deleteSql);

      if ($stmt) {

            $stmt->bind_param("i", $historyId);


            $stmt->execute();

            // Check if the deletion was successful
            if ($stmt->affected_rows > 0) {

                  header("Location: todo_history.php?success=History record deleted successfully");
                  exit;
            } else {

                  header("Location: todo_history.php?error=Failed to delete history record");
                  exit;
            }
      } else {
            header("Location: todo_history.php?error=Database error");
            exit;
      }
} else {
      header("Location: todo_history.php?error=History ID not provided");
      exit;
}
