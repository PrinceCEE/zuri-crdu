<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset password page</title>
  <?php require("./style.php") ?>
</head>

<body>
  <div class="container">
    <div>
      <h1>Reset your password</h1>
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
          <div>
            <label>Confirm assword</label>
            <input type="password" name="cpassword" placeholder="******" required>
          </div>
          <button type="submit" name="reset">Reset</button>
          <?php
          $dbHost = "localhost:3306";
          $dbUser = "princecee";
          $dbPassword = "password";
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die($mysqli->error);

          if (isset($_POST["reset"])) {
            $email = strtolower($_POST["email"]);
            $pwd = $_POST["password"];
            $cPwd = $_POST["cpassword"];

            if ($pwd != $cPwd) {
              echo "<p class=\"error\">Passwords not the same</p>";
              exit;
            }

            $user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
            if (!$user) {
              echo "<p class=\"error\">Sorry, email not registered</p>";
              exit;
            }

            $res = $mysqli->query("UPDATE users SET pwd ='$pwd' WHERE email = '$email'");
            if (!$res) {
              echo "<p class=\"error\">Password update not successful</p>";
              exit;
            }

            header("Location: /app/login.php");
          }

          $mysqli->close();
          ?>
        </form>
      </main>
    </div>
  </div>
</body>

</html>