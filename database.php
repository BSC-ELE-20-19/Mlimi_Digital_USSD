<?php
$db_hostname="localhost";
$db_database="mlimi";
$db_username="root";
$db_password="";


$connect=mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if (!$connect) die("Unable to connect to MySQL: " . mysqli_error());
mysqli_select_db($connect, $db_database)
or die("Unable to select database: " . mysqli_error());

?>
