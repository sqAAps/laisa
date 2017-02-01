<?php
require './core.inc.php';
require './connect.inc.php';
global $connection;
error_reporting(E_ALL);

if(isset($_POST['message']) && isset($_POST['ad_id'])){
	$message = htmlentities(mysqli_real_escape_string($connection, $_POST['message']));
	$ad_id = $_POST['ad_id'];
	$user_id= $_POST['user_id'];
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
	$sql = "INSERT INTO `messages` (receiver_id, sender_id, time_sent, message) VALUES ('$ad_owner_id', '$user_id', now(), '$message')";
	if($query_run = mysqli_query($connection, $sql)){
		echo 'message_sent';
		exit();
	}
}

if(isset($_POST['reply'])){
	$message = htmlentities(mysqli_real_escape_string($connection, $_POST['reply']));
	$msg_id = $_POST['msg_id'];
	$session_user = $_POST['session_user'];
	//We have the AD-ID. NOW LETS LOOK FOR THE ADD-OWNER ID
	//query database
	$query1 = "SELECT * FROM `messages` WHERE 
			`id`='$msg_id'"; 
	//Running the Query
	if ($query_run = mysqli_query($connection, $query1)) {
		$query_num_rows = mysqli_num_rows($query_run);   
        if ($query_num_rows === 1) {
			while ($rows = mysqli_fetch_array($query_run)) {
				$sender_id = $rows['sender_id'];
			}
		}
	}
	$sql = "INSERT INTO `messages` (receiver_id, sender_id, time_sent, message) VALUES ('$sender_id', '$session_user', now(), '$message')";
	if($query_run = mysqli_query($connection, $sql)){
		echo 'message_sent';
		exit();
	}
}
?>
