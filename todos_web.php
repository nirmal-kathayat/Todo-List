<?php



include('db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Todo App</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="./css/main.css">


      <style>
            /* navbar */

            .nav-todo {
                  background-color: black;
                  padding: 10px 16px;
                  position: fixed;
                  top: 0;
                  left: 0;
                  width: 100%;
                  z-index: 9999;
                  height: 12%;
            }

            .container-icon {
                  margin-left: 75rem;
                  margin-top: -2rem;
            }



            .navbar-todos {
                  font-size: 24px;
                  font-weight: bold;
                  color: white;
                  text-decoration: none;
                  font-size: 50px;
                  margin: 5rem;
                  margin-left: 16rem;
                  padding: 8rem;
            }

            .make-todo {
                  font-size: 2.5rem;
                  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                  color: chartreuse;
                  margin-left: 1rem;

            }

            /* styling alert message*/
            .alert {
                  padding: 15px;
                  margin-bottom: 20px;
                  border: 1px solid transparent;
                  border-radius: 4px;
            }

            .alert-danger {
                  color: #721c24;
                  background-color: #f8d7da;
                  border-color: #f5c6cb;
            }

            .alert-success {
                  color: #155724;
                  background-color: #d4edda;
                  border-color: #c3e6cb;
            }

            /* history log */
            .history {
                  background-color: #007bff;
                  color: white;
                  border: none;
                  padding: 10px 20px;
                  text-decoration: none;
                  border-radius: 5px;
                  font-size: 16px;
                  margin-right: 10px;
                  margin-left: 0.4rem;

                  font-family: "Roboto", sans-serif;
            }

            /* Hover effect for the button */
            .history:hover {
                  background-color: #0056b3;
                  /* Darker blue on hover */
                  color: white;
                  /* Text color remains white on hover */
            }
      </style>
</head>

<body>


      <nav class="nav-todo">
            <div class="content">
                  <a class="navbar-todos" href="#"> Task Lists</a>

            </div>
            <div class="container-icon">
                  <button type="button" class="btn btn-primary position-relative m-3">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="counter">
                              <span id="output" class="badge rounded-pill bg-success">

                                    <?php

                                    $sqlNotifications = 'SELECT  message FROM notifications';
                                    $result = $db->query($sqlNotifications);

                                    if ($result->num_rows > 0) {
                                          while ($row = $result->fetch_assoc()) {
                                                echo  "- Message: " . $row["message"] . "<br>";
                                          }
                                    } else {
                                          echo '0';
                                    }

                                    // mysqli_close($conn);
                                    ?>
                              </span>
                        </span>
                        <?php
                        $sql = "SELECT COUNT(*) AS count FROM todos WHERE status = 'Pending'";
                        $result = mysqli_query($db, $sql);
                        $count = mysqli_fetch_assoc($result)['count'];
                        echo $count;
                        ?>
                  </button>

            </div>
      </nav>


      <div class="container">
            <form action="process.php" method="POST">
                  <div class="todo-table">
                        <div class="alert alert-success alert-block" role="alert">

                              <?php if (!empty($_GET['error'])) echo "  " . $_GET['error']; ?>


                              <?php if (!empty($_GET['success'])) echo "  " . $_GET['success']; ?>
                              <script>
                                    const timer = 2000;
                                    setTimeout(function() {
                                          $('.alert').slideUp();
                                    }, timer);
                              </script>

                        </div>

                        <h1>Lists Of Tasks</h1>
                        <h6><?php
                              $sql = "SELECT * FROM todos";
                              $result = mysqli_query($db, $sql);
                              $todos = mysqli_fetch_all($result);
                              $total = count($todos);
                              $complete = 0;

                              foreach ($todos as $todo) {

                                    if ($todo[2] == true) {
                                          $complete++;
                                    }
                                    // print_r($todo);
                              }
                              echo $total . " Total, " . $complete . " Complete," . ($total - $complete) . " Pending.";


                              ?>
                        </h6>

                        <div class="btn-holder">
                              <a href="add-todo.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Todo</a>
                              <button name="action" value="edit" class="btn btn-secondary"><i class="fa fa-edit"></i>
                                    Edit Todo</button>
                              <button name="action" value="delete" class="btn btn-danger"><i class="fa fa-times"></i>
                                    Delete Todo</button>
                              <button name="action" value="complete" class="btn btn-purple"><i class="fa fa-thumbs-up"></i> Mark
                                    Complete</button>
                              <button name="action" value="pending" class="btn btn-orange"><i class="fa fa-thumbs-down"></i> Mark
                                    Pending</button>

                              <a href="todo_history.php" class="history"><i class="fa fa-history"></i> History
                                    Log</a>
                        </div>

                        <table>
                              <thead>
                                    <tr>
                                          <th>S.N</th>
                                          <th>Todo Title</th>
                                          <th>Status</th>
                                          <th>Date-Time</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <?php
                                    foreach ($todos as $todo) {
                                    ?>
                                          <tr class="<?php echo $todo[2] ? 'complete' : ''; ?>">
                                                <td><input type="radio" required name="todo" value="<?php echo $todo[0]; ?>" id=""></td>
                                                <td><?php echo $todo[1]; ?></td>
                                                <td><?php echo $todo[2] ? 'Complete' : 'Pending'; ?>
                                                </td>

                                                <td><?php echo $todo[3]; ?>

                                                </td>

                                          </tr>
                                    <?php } ?>

                              </tbody>
                        </table>
                  </div>

            </form>
      </div>
</body>



</html>