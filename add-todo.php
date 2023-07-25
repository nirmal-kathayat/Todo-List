<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Todo App</title>
      <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="./css/main.css">


</head>

<body>
      <nav class="navbar">
            <div class="container">
                  <a class="navbar-brand" href="#">TODO-LIST</a>
                  <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>

                  </ul>
            </div>
      </nav>




      <div class="container">

            <form action="process.php" method="POST">
                  <div class="todo-table">

                        <h1>Welcome</h1>
                        <h1>Add New Todo</h1>
                        <div class="form-elements">
                              <input type="text" name="title" required placeholder="Add your Todo...">
                        </div>
                        <input type="hidden" name="action" value="add">
                        <input type="datetime-local" id="datetime" name="datetime" value="<?php echo $datetime; ?>"
                              required>

                        <br>
                        <br>

                        <button class="btn btn-purple"><i class="fa fa-save"></i>
                              Save</button>
                        <a href="todos_web.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                              Back</a>
                  </div>
            </form>
            <!-- <div class="img">
                              <img src="./assets/todo.jpg" alt="" width="280px" height="400px">
                    </div> -->
      </div>
</body>

</html>