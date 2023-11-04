<?php  

$sname = "localhost";
$uname = "root";
$password = "sifra123";
$db_name = "socialcare";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection Failed!";
	exit();
}