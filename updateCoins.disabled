<?php

session_start();
include ("db_conn.php");

$id = $_SESSION["id"];
$updatedCoins = $_COOKIE["coins"];

$sql = "UPDATE users SET coins=" . $updatedCoins . " WHERE id=" . $id . ";";

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $id . "';");

if ($conn->query($sql) === TRUE) {
    echo "<p class='coins' id='coins'>" . $updatedCoins . "</p>";
  } else {
    echo "Error!";
  }

mysqli_close($conn);
?>