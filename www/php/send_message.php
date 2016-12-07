<?php
require 'connect.inc.php';
require 'core.inc.php';
global $connection;
error_reporting(E_ALL);

if(isset($_POST['message']) && isset($_POST['ad_id'])){
	$message = htmlentities(mysqli_real_escape_string($connection, $_POST['message']));
	$ad_id = $_POST['ad_id'];
	//We have the AD-ID. NOW LETS LOOK FOR THE ADD-OWNER ID
	//query database
	$query1 = "SELECT * FROM `adverts` WHERE 
			`id`='$ad_id'"; 
	//Running the Query
	if ($query_run = mysqli_query($connection, $query1)) {
		$query_num_rows = mysqli_num_rows($query_run);   
        if ($query_num_rows === 1) {
			while ($rows = mysqli_fetch_array($query_run)) {
				$ad_owner_id = $rows['user_id'];
			}
		}
	}
	$sql = "INSERT INTO `messages` (receiver_id, sender_id, time_sent, message) VALUES ('$ad_owner_id', '".$_SESSION['user_id']."', now(), '$message')";
	if($query_run = mysqli_query($connection, $sql)){
		echo 'message_sent';
		exit();
	}
}

if(isset($_POST['reply']) && isset($_POST['sender_id'])){
	$message = htmlentities(mysqli_real_escape_string($connection, $_POST['reply']));
	$sender_id = $_POST['sender_id'];
	//We have the AD-ID. NOW LETS LOOK FOR THE ADD-OWNER ID
	//query database
	$query1 = "SELECT * FROM `messages` WHERE 
			`sender_id`='$ad_id'"; 
	//Running the Query
	if ($query_run = mysqli_query($connection, $query1)) {
		$query_num_rows = mysqli_num_rows($query_run);   
        if ($query_num_rows === 1) {
			while ($rows = mysqli_fetch_array($query_run)) {
				$ad_owner_id = $rows['user_id'];
			}
		}
	}

	$sql = "INSERT INTO `messages` (receiver_id, sender_id, time_sent, message) VALUES ('$sender_id', '".$_SESSION['user_id']."', now(), '$message')";
	if($query_run = mysqli_query($connection, $sql)){
		echo 'message_sent';
		exit();
	}
}
?>
