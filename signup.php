<?php
session_start();

// Function to clear error messages
function clearErrors()
{
      $_SESSION['nameError'] = '';
      $_SESSION['emailError'] = '';
      $_SESSION['passwordError'] = '';
      $_SESSION['passwordConfirmationError'] = '';
}

// Initialize session variables
clearErrors();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
      // Validate name
      if (empty($_POST["name"])) {
            $_SESSION['nameError'] = "Name is required*";
      }

      // Validate email
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailError'] = "Valid email is required*";
      }

      // Validate password
      $password = $_POST["password"];
      if (strlen($password) < 8) {
            $_SESSION['passwordError'] = "Password must be at least 8 characters*";
      }

      if (!preg_match("/[a-zA-Z]/", $password)) {
            $_SESSION['passwordError'] = "Password must contain at least one letter";
      }

      if (!preg_match("/[0-9]/", $password)) {
            $_SESSION['passwordError'] = "Password must contain at least one number*";
      }

      // Validate password confirmation
      $passwordConfirmation = $_POST["password_confirmation"];
      if ($password !== $passwordConfirmation) {
            $_SESSION['passwordConfirmationError'] = "Passwords must match*";
      }

      // Check if there are no validation errors
      if (empty($_SESSION['nameError']) && empty($_SESSION['emailError']) && empty($_SESSION['passwordError']) && empty($_SESSION['passwordConfirmationError'])) {
            $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $mysqli = require __DIR__ . "/database.php";

            $sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if (!$stmt) {
                  die("SQL error: " . $mysqli->error);
            }

            $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

            // If registration is successful, redirect to home page
            if ($stmt->execute()) {
                  header("Location: homepage.php");
                  exit;
            } else {
                  if ($mysqli->errno === 1062) {
                        $_SESSION['emailError'] = "Email already taken";
                  } else {
                        die("Database error: " . $mysqli->error . " " . $mysqli->errno);
                  }
            }
      }
}
?>

<!DOCTYPE html>
<html>

<head>
      <title>Signup</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
      <script src="./validation.js" defer></script>
      <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="./css/styleSignup.css">
</head>

<body>
      <div class="container">
            <div class="forms">
                  <div class="form signup">
                        <span class="title">Registration</span>
                        <hr>
                        <form action="#" method="post" id="signup" novalidate>
                              <div class="input-field">
                                    <input type="text" placeholder="Enter your name" id="name" name="name">
                                    <i class="uil uil-user"></i>
                              </div>
                              <div class="error-message"><?php echo $_SESSION['nameError']; ?></div>

                              <div class="input-field">
                                    <input type="text" placeholder="Enter your email" id="email" name="email">
                                    <i class="uil uil-envelope icon"></i>
                              </div>
                              <div class="error-message"><?php echo $_SESSION['emailError']; ?></div>

                              <div class="input-field">
                                    <input type="password" class="password" placeholder="Create a password" id="password" name="password">
                                    <i class="uil uil-lock icon"></i>
                              </div>
                              <div class="error-message"><?php echo $_SESSION['passwordError']; ?></div>

                              <div class="input-field">
                                    <input type="password" class="password" placeholder="Confirm a password" id="password_confirmation" name="password_confirmation">
                                    <i class="uil uil-lock icon"></i>
                                    <i class="uil uil-eye-slash showHidePw"></i>
                              </div>


                              <div class="error-message"><?php echo $_SESSION['passwordConfirmationError']; ?></div>

                              <div class="checkbox-text">
                                    <div class="checkbox-content">
                                          <input type="checkbox" id="termCon">
                                          <label for="termCon" class="text">I accepted all terms and conditions</label>
                                    </div>
                              </div>
                              <div class="signup-field">
                                    <input type="submit" value="Signup">
                              </div>
                        </form>
                        <div class="login-signup">
                              <span class="text">Already a member?
                                    <a href="login.php" class="text login-link">Login Now</a>
                              </span>
                        </div>
                  </div>
            </div>
      </div>

      <script src="./script.js"></script>

</body>

</html>