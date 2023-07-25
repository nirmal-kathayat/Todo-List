<?php


include('db_conn.php');


if (isset($_POST['action'])) {
      switch ($_POST['action']) {
            case 'add':

                  if (empty($_POST['title'])) {
                        header('Location: add-todo.php');
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
                  break;

            case 'edit':

                  if (empty($_POST['todo'])) {
                        header('Location: todos_web.php?error=Select atleast one todo');
                  }


                  header('Location: edit-todo.php?id=' . $_POST['todo']);
                  break;
      }
}
