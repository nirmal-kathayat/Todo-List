<?php



session_start(); // Start the session

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
                        $notificationSql = "INSERT INTO notifications (`message`) VALUES ('Created task successfully') ";
                        $notificationResult = mysqli_query($db, $notificationSql);
                  }

                  if ($result !== false) {

                        header('Location: todos_web.php?success=New Todo Added Successfully!');
                  }

                  // After the INSERT INTO todos query, add the following code to log the action
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
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "DELETE FROM todos WHERE id = ('" . $_POST['todo'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {

                        header('Location: todos_web.php?success=Todo Deleted Successfully!');
                  }
                  break;

            case 'complete':

                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `status` = 1 WHERE id = ('" . $_POST['todo'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {

                        header('Location: todos_web.php?success=Todo Marked Completed!');
                  }
                  // After the UPDATE todos query for marking as complete or pending, add the following code to log the action
                  if ($result !== false) {
                        $todoId = $_POST['todo'];
                        $action = ($_POST['action'] === 'complete') ? 'Complete' : 'Pending';
                        $historySql = "INSERT INTO todo_history (todo_id, title, datetime, action) VALUES ('$todoId', '$title', '$datetime', '$action')";
                        mysqli_query(
                              $db,
                              $historySql
                        );
                  }

                  break;

            case 'pending':

                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `status` = 0 WHERE id = ('" . $_POST['todo'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {

                        header('Location: todos_web.php?success=Todo Task Pending!');
                  }

                  break;

            case 'edited':

                  if (empty($_POST['id'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `title` = '" . $_POST['title'] . "' WHERE id = ('" . $_POST['id'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {

                        header('Location: todos_web.php?success=Todo Updated Successfully!');
                  }

                  // After the UPDATE todos query for editing, add the following code to log the action
                  if ($result !== false) {
                        $todoId = $_POST['id'];
                        $title = $_POST['title'];
                        $action = 'Edit';
                        $historySql = "INSERT INTO todo_history (todo_id, title, action) VALUES ('$todoId', '$title', '$action')";
                        mysqli_query(
                              $db,
                              $historySql
                        );
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
