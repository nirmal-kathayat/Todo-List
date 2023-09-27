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
                        $notificationSql = "INSERT INTO notifications (`message`) VALUES ('Created task successfully!') ";
                        $notificationResult = mysqli_query($db, $notificationSql);
                  }

                  if ($result !== false) {
                        echo "<script>alert('New Todo Added Successfully!');</script>";
                        // header('Location: todos_web.php?success=New Todo Added Successfully!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
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

                  // case 'delete':

                  //       if (empty($_POST['todo'])) {
                  //             header('Location: todos_web.php?error=Select atleast one todo');
                  //       }

                  //       $sql = "DELETE FROM todos WHERE id = ('" . $_POST['todo'] . "')";

                  //       $result = mysqli_query($db, $sql);

                  //       if ($result !== false) {
                  //             echo "<script>confirm('Are you sure to delete?');</script>";
                  //             // header('Location: todos_web.php?success=Todo Deleted Successfully!');
                  //             echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  //       }
                  //       break;

            case 'delete':
                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select at least one todo');
                        exit; // Terminate script execution if there's an error
                  }

                  $todoId = $_POST['todo'];

                  // Display a confirmation dialog using JavaScript
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

                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `status` = 1 WHERE id = ('" . $_POST['todo'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {
                        echo "<script>confirm('Todo Marked Completed!');</script>";
                        // header('Location: todos_web.php?success=Todo Marked Completed!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
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
                        echo "<script> alert('Task is Pending!');</script>";
                        // header('Location: todos_web.php?success=Todo Task Pending!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
                  }

                  break;

            case 'edited':

                  if (empty($_POST['id'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }

                  $sql = "UPDATE todos SET `title` = '" . $_POST['title'] . "' WHERE id = ('" . $_POST['id'] . "')";

                  $result = mysqli_query($db, $sql);

                  if ($result !== false) {
                        echo "<script>alert('Task is Updated successfully!');</script>";
                        // header('Location: todos_web.php?success=Todo Updated Successfully!');
                        echo "<script>setTimeout(function(){ window.location.href = 'todos_web.php'; });</script>";
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
