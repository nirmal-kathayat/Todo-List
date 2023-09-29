<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

// Create a MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
} else {
      // Connection successful!
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Todo Item History</title>
      <link rel="stylesheet" href="./css/historyStyle.css">


</head>

<body>


      <div class="navbar">
            <h2>History Logs</h2>
            <a href="todos_web.php" class="history-icon"></i> Back</a>
      </div>
      <?php
      $sql = "SELECT * FROM todo_history";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
            echo '<h1>Todo Item History</h1>';
            echo '<table>';
            echo '<tr>
                  <th>Todo ID</th>
                  <th>Title</th>
                  <th>Action</th>
                  <th>Datetime</th>
                  <th>Timestamp</th>
                  <th>History Status</th>
                  </tr>';
            while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . $row["todo_id"] . '</td>';
                  echo '<td>' . $row["title"] . '</td>';
                  echo '<td>' . $row["action"] . '</td>';
                  echo '<td>' . $row["datetime"] . '</td>';
                  echo '<td>' . $row["timestamp"] . '</td>';

                  // dlete button
                  echo '<td>';
                  echo '<form method="POST" action="delete_history.php">';
                  echo '<input type="hidden" name="history_id" value="' . $row["id"] . '">';
                  echo '<button type="submit" class="btn-delete">Delete</button>';
                  echo '</form>';
                  echo '</td>';

                  echo '</tr>';
            }
            echo '</table>';
      } else {
            echo "No todos found in the todo_history table.";
      }

      $conn->close();
      ?>
</body>

</html>