<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    // Validate email (check if it's not empty)
    if (empty($_POST["email"])) {
        $is_invalid = true;
    } else {
        $sql = sprintf(
            "SELECT * FROM user WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"])
        );

        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if ($user) {
            // Validate password (check if it's not empty)
            if (!empty($_POST["password"]) && password_verify($_POST["password"], $user["password_hash"])) {
                session_start();
                session_regenerate_id();
                $_SESSION["user_id"] = $user["id"];
                header("Location: add-todo.php");
                exit;
            }
        }

        $is_invalid = true;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/formStyle.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="./validation.js" defer></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- login page -->
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
                <form action="#" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" id="email">
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <?php if ($is_invalid && empty($_POST["email"])) : ?>
                        <div class="error-message">Email is required*</div>
                    <?php endif; ?>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" name="password" id="password">
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <?php if ($is_invalid && (!isset($_POST["password"]) || empty($_POST["password"]) || !$user)) : ?>
                        <div class="error-message">Password is required*</div>
                    <?php endif; ?>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember me</label>
                        </div>
                        <a href="#" class="text">Forgot password?</a>
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Login">
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="signup.php" class="text signup-link">Signup Now</a>
                    </span>
                </div>
            </div>

            <script src="./script.js"></script>
        </div>
    </div>
</body>

</html>