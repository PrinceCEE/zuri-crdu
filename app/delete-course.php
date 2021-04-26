<?php
$dbHost = "localhost:3306";
$dbUser = "princecee";
$dbPassword = "password";
$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, "crud") or die(mysqli_error($mysqli));
$id = $_GET['id'];
$result = $mysqli->query("DELETE FROM courses WHERE id = $id");
header("Location: /app/index.php");
