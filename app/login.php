<?php
session_start();
if (isset($_SESSION["isAuthenticated"])) {
  header("Location: /app/index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login page</title>
  <?php require("./style.php") ?>
</head>

<body>
  <div class="container">
    <div>
      <h1>Log to Zuri Authentication</h1>
      <main>
        <form method="POST">
          <div>
            <label>Email address</label>
            <input type="email" name="email" placeholder="example@joe.com" required>
          </div>
          <div>
            <label>Password</label>
            <input type="password" name="password" placeholder="******" required>
          </div>
          <p>
            <a href="/app/registration.php">Don't have an account? Register</a>
          </p>
          <p>
            <a href="/app/reset-password.php">Reset password</a>
          </p>
          <button type="submit" name="login">Login</button>
          <?php
          // connect to the database
          $dbHost = "localhost:3306";
          $dbUser = "princecee";
          $dbPassword = "password";
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die($mysqli->error);

          if (isset($_POST["login"])) {
            $email = strtolower($_POST["email"]);
            $pwd = $_POST["password"];

            // retrieve the user from the database and compare the password
            $user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
            if (count($user) != 0) {
              if ($user["pwd"] == $pwd) {
                $_SESSION["isAuthenticated"] = true;
                $_SESSION["email"] = $email;
                header("Location: /app/index.php");
                exit;
              } else {
                echo "<p class=\"error\">Invalid login details, did you forget anything?</p>";
              }
            } else {
              echo "<p class=\"error\">Details not found</p>";
            }
          }

          ?>
        </form>
      </main>
    </div>
  </div>
</body>

</html>