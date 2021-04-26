<?php
session_start();
if (!isset($_SESSION["isAuthenticated"])) {
  header("Location: /app/register.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to the homepage</title>
  <?php require("./style.php") ?>
</head>

<body>
  <div class="container">
    <div id="index">
      <h1>Hello, Welcome to the homepage</h1>
      <main>
        <?php
        $dbHost = "localhost:3306";
        $dbUser = "princecee";
        $dbPassword = "password";
        $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die($mysqli->error);

        $email = $_SESSION["email"];
        $user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();

        if (!$user) {
          echo "<p class=\"error\">Error retrieving your detail</p>";
          exit;
        }

        $name = $user["names"];
        $email = $user["email"];
        ?>
        <div>
          <h3><?php echo $name ?></h3>
          <p><?php echo $email ?></p>
        </div>
        <div>
          <p><?php echo $about ?></p>
        </div>
        <a href="/app/logout.php">Log out</a>
        <div>
          <h2>Add new course</h2>
          <form method="POST">
            <input type="text" name="courseName" placeholder="enter the course name" />
            <button name="add-course" type="submit">Add</button>
          </form>
          <?php
          // connect to the database
          $dbHost = "localhost:3306";
          $dbUser = "princecee";
          $dbPassword = "password";
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die(mysqli_error($mysqli));

          if (isset($_POST["add-course"])) {
            $courseName = strtolower(trim($_POST["courseName"]));

            if (strlen($courseName) == 0) {
              echo "<p class=\"error\">You can't submit empty course</p>";
            }

            $course = $mysqli->query("SELECT * FROM courses WHERE course_name = '$courseName'")->fetch_assoc();
            if ($course == null) {
              $mysqli->query("INSERT INTO courses (course_name) VALUES('$courseName')");
            }
          }

          $mysqli->close();
          ?>
        </div>
        <div>
          <h2>My courses</h2>
          <?php
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die(mysqli_error($mysqli));
          $result = $mysqli->query("SELECT * FROM courses");
          while ($row = $result->fetch_assoc()) {
            $courseName = $row["course_name"];
            $id = $row["id"];
            echo "<ul><li><span>$courseName</span><a href=\"/app/edit-course.php?id=$id\"><button>Edit</button></a><a href=\"/app/delete-course.php?id=$id\"><button>Delete</button></a></li></ul>";
          }
          ?>
        </div>
      </main>
    </div>
  </div>
</body>

</html>