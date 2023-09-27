<?php

include('db_conn.php');

if (empty($_GET['id'])) {
      header('Location: todos_web.php?error=Select atleast one todo');
}

$sql = "SELECT * FROM todos WHERE `id` = " . $_GET['id'];
$result = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Todo App</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="./css/styleEdit.css">
</head>

<body>
      <nav class="navbar">
            <div class="container">
                  <h1 class="navbar-brand">TODO-LIST</h1>
            </div>
      </nav>

      <div class="container">
            <form action="queryProcess.php" method="POST">
                  <div class="todo-table">
                        <h1>Edit Your Todo</h1>
                        <hr />
                        <div class="form-elements">
                              <label for="title-id">Todo Title:</label> <br>
                              <input type="text" name="title" name="title" class="main-title" required
                                    value="<?php echo $data['title']; ?>" placeholder="Type your todo here...">
                        </div>

                        <label for="message"> Description:</label><br>
                        <textarea id="message" name="message" rows="4" cols="50"
                              placeholder="Enter the description here..."></textarea> <br>

                        <label for="datetime">Date Time:</label><br>
                        <input type="hidden" name="action" value="edited">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <input type="datetime-local" id="datetime" name="datetime" class="date-time"
                              value="<?php echo $datetime; ?>" required>
                        <br>
                        <br>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Update Todo</button>
                        <a href="todos_web.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                              Back</a>
                  </div>
            </form>
      </div>
</body>

</html>