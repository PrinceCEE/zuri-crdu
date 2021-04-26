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
  <title>Registration page</title>
  <?php require("./style.php") ?>
</head>

<body>
  <div class="container">
    <div>
      <h1>Register with your details to Zuri Authentication</h1>
      <main>
        <form method="POST">
          <div>
            <label>Names</label>
            <input type="text" name="names" placeholder="John Doe" required>
          </div>
          <div>
            <label>Email address</label>
            <input type="email" name="email" placeholder="example@joe.com" required>
          </div>
          <div>
            <label>Password</label>
            <input type="password" name="password" placeholder="******" required>
          </div>
          <p>
            <a href="/app/login.php">Already have an account? Login</a>
          </p>
          <button type="submit" name="register">Register</button>
        </form>
        <?php
        // connect to the database
        $dbHost = "localhost:3306";
        $dbUser = "princecee";
        $dbPassword = "password";
        $mysqli = new mysqli($dbHost, $dbUser, $dbPassword) or die(mysqli_error($mysqli));

        // create a new database
        $mysqli->query("CREATE DATABASE crud");

        $mysqli->close();
        $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, 'crud') or die(mysqli_error($mysqli));

        // create user table;
        $res = $mysqli->query("CREATE TABLE users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, names VARCHAR(30) NOT NULL, email VARCHAR(30) NOT NULL, pwd VARCHAR(50))");

        // create courses table
        $res = $mysqli->query("CREATE TABLE courses (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,course_name VARCHAR(30) NOT NULL)");

        if (isset($_POST["register"])) {
          // retrieve the user details
          $names = $_POST["names"];
          $email = strtolower($_POST["email"]);
          $pwd = $_POST["password"];

          // find the email in the database and redirect
          $user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
          if ($user) {
            header("Location: /app/login.php");
          } else {
            $mysqli->query("INSERT INTO users (names, email, pwd) VALUES('$names', '$email', '$pwd')") or die($conn->error);
            $_SESSION["isAuthenticated"] = true;
            $_SESSION["email"] = $email;
            header("Location: /app/index.php");
          }
        }

        $mysqli->close();
        ?>
      </main>
    </div>
  </div>
</body>

</html>