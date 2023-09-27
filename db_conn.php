<?php

$sname= "bigwincash01.mysql.domeneshop.no";
$unmae= "bigwincash01";
$password = "Gambling123.";

$db_name = "bigwincash01";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
$db = mysqli_select_db($conn, $db_name);
if(!$db){
    echo 'Database not connected';
}
?>