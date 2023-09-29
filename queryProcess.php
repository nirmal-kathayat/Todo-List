<?php



session_start();

include('db_conn.php');

if (isset($_POST['action'])) {
      function input_data($data)
      {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
      }

      switch ($_POST['action']) {
            case 'add':
                  // validation part
                  $titleErr = $datetimeErr = "";
                  $title = $datetime = "";

                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST["title"])) {
                              $titleErr = "Title is required*";
                        } else {
                              $title = input_data($_POST["title"]);
                              if (!preg_match("/^[a-zA-Z ]*$/", $title)) {
                                    $titleErr = "Invalid title format";
                              }
                        }

                        if (empty($_POST["datetime"])) {
                              $datetimeErr = "Date and Time is required*";
                        } else {
                              $datetime = input_data($_POST["datetime"]);
                              $dateTimeObj = DateTime::createFromFormat('Y-m-d\TH:i', $datetime);
                              if ($dateTimeObj === false) {
                                    $datetimeErr = "Invalid datetime format";
                              }
                        }
                  }

                  if (!empty($titleErr) || !empty($datetimeErr)) {
                        $_SESSION['error'] = "Validation Failed!";
                        $_SESSION['titleErr'] = $titleErr;
                        $_SESSION['datetimeErr'] = $datetimeErr;
                        header('Location: add-todo.php');
                        exit();
                  }
                  $sql = "INSERT INTO todos (`title`) VALUES ('" . $_POST['title'] . "')";

                  $result = mysqli_query($db, $sql);
                  if ($result) {
                        $notification_message = "Todo Added!";
                        $notification_datetime = $datetime;
                        $notificationSql = "INSERT INTO notifications (`message`, `datetime`) VALUES ('$notification_message', '$notification_datetime')";
                        $notificationResult = mysqli_query($db, $notificationSql);
                  }

                  if ($result !== false) {
                        echo "<script>alert('New Todo Added Successfully!');</script>";
                        // header('Location: todos_web.php?success=New Todo Added Successfully!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  }

                  // After the INSERT INTO todos query history
                  if ($result) {
                        $todoId = mysqli_insert_id($db);
                        $title = $_POST['title'];
                        $datetime = $_POST['datetime'];
                        $action = 'Add';
                        $historySql = "INSERT INTO todo_history (todo_id, title, datetime, action) VALUES ('$todoId', '$title', '$datetime', '$action')";
                        mysqli_query($db, $historySql);
                  }

                  break;

            case 'delete':
                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select at least one todo');
                        exit;
                  }

                  $todoId = $_POST['todo'];


                  echo "<script>
                        if (confirm('Are you sure you want to delete this todo?')) {
                            // If the user clicks 'OK', proceed with the deletion
                            window.location.href = 'delete_todo.php?id=$todoId';
                        } else {
                            // If the user clicks 'Cancel', go back to the previous page
                            window.location.href = 'todos_web.php';
                        }
                      </script>";
                  break;


            case 'complete':
                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select at least one todo');
                  }

                  // Fetch the title and datetime of the selected todo
                  $todoId = $_POST['todo'];
                  $fetchTodoSql = "SELECT title, datetime FROM todos WHERE id = '$todoId'";
                  $fetchTodoResult = mysqli_query($db, $fetchTodoSql);

                  if ($fetchTodoResult && mysqli_num_rows($fetchTodoResult) > 0) {
                        $todoData = mysqli_fetch_assoc($fetchTodoResult);
                        $title = $todoData['title'];
                        $datetime = $todoData['datetime'];
                  }

                  $sql = "UPDATE todos SET `status` = 1 WHERE id = ('$todoId')";
                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {
                        echo "<script>alert('Todo Marked Completed!');</script>";
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  }

                  // After the UPDATE todos query for marking as complete or pending
                  if ($result !== false) {
                        $action = ($_POST['action'] === 'complete') ? 'Complete' : 'Pending';
                        $historySql = "INSERT INTO todo_history (todo_id, title, datetime, action) VALUES ('$todoId', '$title', '$datetime', '$action')";
                        mysqli_query($db, $historySql);
                  }

                  break;


            case 'pending':

                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `status` = 0 WHERE id = ('" . $_POST['todo'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {
                        echo "<script> alert('Task is Pending!');</script>";
                        // header('Location: todos_web.php?success=Todo Task Pending!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  }

                  break;

                  // history
            case 'delete_history':
                  if (isset($_POST['history_id'])) {
                        $historyId = $_POST['history_id'];

                        // Perform a DELETE query to remove the history entry with the given ID
                        $deleteHistorySql = "DELETE FROM todo_history WHERE id = '$historyId'";
                        $deleteHistoryResult = mysqli_query($db, $deleteHistorySql);

                        if ($deleteHistoryResult) {
                              // Redirect back to the page where you manage history entries
                              header('Location: todo_history.php?success=History entry deleted successfully');
                        } else {
                              // Handle the case where the deletion fails
                              header('Location: todo_history.php?error=Failed to delete history entry');
                        }
                  } else {
                        // Handle the case where history_id is not set
                        header('Location: todo_history.php?error=History ID not provided');
                  }
                  break;



            case 'edited':
                  if (empty($_POST['id'])) {
                        header('Location: todos_web.php?error=Select at least one todo');
                  }

                  // Fetch the current title and datetime of the todo being edited
                  $todoId = $_POST['id'];
                  $fetchTodoSql = "SELECT title, datetime FROM todos WHERE id = '$todoId'";
                  $fetchTodoResult = mysqli_query($db, $fetchTodoSql);

                  if ($fetchTodoResult && mysqli_num_rows($fetchTodoResult) > 0) {
                        $todoData = mysqli_fetch_assoc($fetchTodoResult);
                        $currentTitle = $todoData['title'];
                        $datetime = $todoData['datetime'];
                  }

                  $newTitle = $_POST['title'];
                  $sql = "UPDATE todos SET `title` = '$newTitle' WHERE id = '$todoId'";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {
                        echo "<script>alert('Task is Updated successfully!');</script>";
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  }

                  // After the UPDATE todos query for editing
                  if ($result !== false) {
                        $action = 'Edit';
                        $historySql = "INSERT INTO todo_history (todo_id, title, datetime, action) VALUES ('$todoId', '$currentTitle', '$datetime', '$action')";
                        mysqli_query($db, $historySql);
                  }

                  break;


            case 'edit':

                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }


                  header('Location: edit-todo.php?id=' . $_POST['todo']);
                  break;
      }
}
