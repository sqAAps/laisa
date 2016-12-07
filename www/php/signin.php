<?php 
require_once 'core.inc.php';
require 'connect.inc.php';
global $connection;

if(isset($_POST['fblogin'])){
	$query = "SELECT * FROM `users` WHERE `id`='".$_POST['id']."'";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		if($query_num_rows === 0){
			$sql = "INSERT INTO `users` VALUES ('".$_POST['id']."', '".$_POST['name']."', '".str_replace(':','%3A',str_replace('https://','',urldecode($_POST['picture'])))."', '".$_POST['phonenumber']."', 'aa', '".$_POST['gender']."')";
			
			if($sql_run = mysqli_query($connection, $sql)){
				$_SESSION['user_id'] = $_POST['id'];
				echo "inserted";
				exit();
			}
		}else if($query_num_rows > 0){
			$_SESSION['user_id'] = $_POST['id'];
			echo "inserted";
			exit();
		}
	}
}