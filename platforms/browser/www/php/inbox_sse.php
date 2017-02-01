<?php
require './connect.inc.php';
require './core.inc.php';
global $connection;
header("Content-Type: text/event-stream");
header("Cache-Control: no-Control");

// Number of entries
$query = "SELECT COUNT(*) as total FROM `messages` WHERE `receiver_id`='".$_SESSION['session_user']."'";
$query_run = mysqli_query($connection, $query);
$rows = mysqli_fetch_array($query_run);
	
if ($rows['total'] > 0){
	$sql = mysqli_query($connection, "SELECT * FROM `messages` WHERE `receiver_id`='".mysqli_real_escape_string($connection, $_SESSION['session_user'])."'");
	if(mysqli_num_rows($sql) > 0){
		while($row = mysqli_fetch_array($sql)){
			$_SESSION['msgs']++;
			if($_SESSION['msg_id'] < $row['id']){
				
				//message last added message id
				$_SESSION['msg_id'] = $row['id'];
			
				$fr_id = $row['sender_id'];
					
				//Collect user details
				$query1 = "SELECT * FROM `users` WHERE 	`id`='$fr_id' LIMIT 1";
				$query_run1 = mysqli_query($connection, $query1);
				while($raw = mysqli_fetch_array($query_run1)){
					$Fname = $raw['name'];
				}
				
				echo "data:'".$Fname."'\n";
				echo "data:'".$row['message']."'\n\n";
				@ob_flush();
				flush();
			}
		}
	}
	$_SESSION['msgs'] = $rows['total'];
} else{
	//Initial number of Messages
	$_SESSION['msgs'] = 0;
	$_SESSION['msg_id'] = 0;
}
	
?>