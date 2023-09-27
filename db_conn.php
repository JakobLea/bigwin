<?php

$sname= "bigwincash01.mysql.domeneshop.no";
$unmae= "bigwincash01";
$password = "Gambling123.";

$db_name = "bigwincash01";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}