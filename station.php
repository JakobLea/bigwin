<?php

session_start();
include ("db_conn.php");

$id = $_SESSION["id"];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $id . "';");

while ($row = mysqli_fetch_array($result))
    {
    echo "<p class='coins' id='coins'>" . $row['coins'] . "</p>";
    }

mysqli_close($conn);
