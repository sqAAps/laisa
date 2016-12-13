<?php
header('Access-Control-Allow-Origin: *');
$mysql_host = 'localhost';
$mysql_user = 'sqaapbms_namela';
$mysql_pass = 'i9M56JOD8P';
$mysql_db = 'sqaapbms_laisa';

/*$mysql_db = 'laisa';
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';

$mysql_db = 'namela';*/
$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if (mysqli_connect_errno($connection)) {
    die("Database connection failed:" . mysqli_connect_error());
}
?>

