<?php

session_start();
include ("db_conn.php");

$id = $_SESSION["id"];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $id . "';");

while ($row = mysqli_fetch_array($result))
    {
    echo "<p class='infobox_data' id='infobox_temp'>" . $row['coins'] . "</p>";
    }

mysqli_close($conn);
?>