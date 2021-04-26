<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit course</title>
  <?php require("./style.php") ?>
</head>

<body>
  <div class="container">
    <div>
      <h1>Edit course</h1>
      <main>
        <form method="POST">
          <?php
          // connect to the database
          $dbHost = "localhost:3306";
          $dbUser = "princecee";
          $dbPassword = "password";
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die($mysqli->error);

          $id = $_GET["id"];
          $course = $mysqli->query("SELECT * FROM courses WHERE id = '$id'")->fetch_assoc();
          $course_name = $course["course_name"];
          ?>
          <div>
            <label>Edit course</label>
            <input type="text" name="courseName" value=<?php echo $course_name; ?>>
          </div>
          <button type="submit" name="edit">Edit course</button>
          <?php
          $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die($mysqli->error);

          if (isset($_POST["edit"])) {
            $courseName = trim($_POST["courseName"]);
            if (strlen($courseName) > 0) {
              $id = $_GET['id'];
              $result = $mysqli->query("UPDATE courses SET course_name = '$courseName' WHERE id = '$id' ") or die($mysqli->error);
              header("Location: /app/index.php");
            }
          }

          ?>
        </form>
      </main>
    </div>
  </div>
</body>

</html>


<?php
