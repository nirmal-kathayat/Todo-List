<?php
include 'db_conn.php';
session_start();

if (isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      $titleErr = $_SESSION['titleErr'];
      $datetimeErr = $_SESSION['datetimeErr'];
      unset($_SESSION['error']);
      unset($_SESSION['titleErr']);
      unset($_SESSION['datetimeErr']);
}

// Rest of your HTML and PHP code for the add-todo.php page
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Todo App</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">


      <link rel="stylesheet" href="./css/project.css">

</head>

<body>
      <nav class="navbar">
            <div class="container">
                  <h1 class="navbar-brand">TODO-LIST</h1>
                  <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>

                  </ul>
            </div>
      </nav>




      <div class="container">

            <form action="process.php" method="POST">
                  <div class="todo-table">

                        <h1 class="head-class">Welcome!</h1>
                        <h1 class="heading-class">Add Your Todo</h1>
                        <hr />
                        <div class="form-elements">
                              <label for="title-id">Todo Title:</label> <br>
                              <input type="text" name="title" class="main-title" id="title-id" placeholder="Add your Todo...">
                              <?php
                              if (isset($titleErr) && !empty($titleErr)) {
                                    echo '<span class="error">' . $titleErr . '</span>';
                              }
                              ?>


                        </div><br>
                        <label for="message"> Description:</label><br>
                        <textarea id="message" name="message" rows="4" cols="50" placeholder="Enter the description here..."></textarea> <br>

                        <label for="datetime">Date Time:</label><br>
                        <input type="hidden" name="action" value="add">
                        <input type="datetime-local" id="datetime" name="datetime" class="date-time" value="<?php echo $datetime; ?>">

                        <?php
                        if (isset($titleErr) && !empty($titleErr)) {
                              echo '<span class="error">' . $datetimeErr . '</span>';
                        }
                        ?>


                        <br>
                        <br>

                        <button class="btn btn-success"><i class="fa fa-save"></i>
                              Save</button>
                        <a href="todos_web.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                              Back</a>
                  </div>
            </form>
      </div>
</body>

</html>