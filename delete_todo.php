<?php
// Check if an 'id' parameter is present in the URL
if (isset($_GET['id'])) {
      $todoId = $_GET['id'];

      $host = "localhost";
      $dbname = "login_db";
      $username = "root";
      $password = "";

      // Connection with MySQL
      $db = new mysqli($host, $username, $password, $dbname);

      // Checking the connection
      if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
      }

      $sql = "DELETE FROM todos WHERE id = '$todoId'";
      $result = mysqli_query($db, $sql);

      if ($result !== false) {
            // Redirect back to the todos_web.php page with a success message
            header('Location: todos_web.php?success=Todo Deleted Successfully!');
            exit;
      } else {
            echo "Error deleting todo: " . mysqli_error($db);
            exit;
      }
}
