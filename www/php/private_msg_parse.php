<?php
require './core.inc.php';
require './connect.inc.php';
require './View/view.php';
global $connection;
//error_reporting(E_ALL);


/*/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
        ERROR HANDLING AND LOW LEVEL SECURITY CHECKS         
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////*/

$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
/* echo $_SESSION['wipit'] . ' | ' . $_SESSION['user_id'] . ' | ' . $_POST['senderID'];
exit(); */
// If session variable for wipit is not set OR if session id is not set
if (!isset($_SESSION['wipit']) || !isset($_SESSION['user_id'])) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; <strong>Your session expired from inactivity. Please refresh your browser and continue.</strong>';
    exit();
}
// else if session id IS NOT EQUAL TO the posted variable for sender ID
else if ($_SESSION['user_id'] != $_POST['senderID']) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>$_SESSION[user_id] != $_POST[senderID]</strong>';
    exit();
}
// else if session wipit variable IS NOT EQUAL TO the posted wipit variable
/*else if ($sessWipit != $thisWipit) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>$sessWipit != $thisWipit</strong>';
    exit();
}*/
// else if either wipit variables are empty
else if ($thisWipit == "" || $sessWipit == "") {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>Missing Data</strong>';
    exit();
}
// PREVENT DOUBLE POSTS /////////////////////////////////////////////////////////////////////////////
$checkuserid = $_POST['senderID'];
$query = "SELECT id FROM messages WHERE from_id='$checkuserid' AND time_sent between subtime(now(),'0:0:5') and now()";
$prevent_dp = mysqli_query($connection, $query);
$nr = mysqli_num_rows($prevent_dp);
if ($nr > 0){
	echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  You must wait 5 seconds between your private message sending.';
	exit();
}
///////////////////////////////////////////////////////////////////////////////////////
// PREVENT MORE THAN 30 IN ONE DAY FROM THIS MEMBER  /////////////////////////////////////////////////////////////////////////////
$sql = mysqli_query($connection, "SELECT id FROM messages WHERE from_id=".$checkuserid." AND DATE(time_sent) = DATE(NOW()) LIMIT 40");
$numRows = mysqli_num_rows($sql);
if ($numRows > 1000) {
	echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  You can only send 10000 Private Messages per day.';
    exit();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////                                                    PARSE THE MESSAGE                                                 //////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Process the message once it has been sent 
if (isset($_POST['message'])) { 
  // Escape and prepare our variables for insertion into the database 
  // This is also where you would run any sort of editing, such as BBCode parsing 
  $to = preg_replace('#[^0-9]#i', '', $_POST['rcpntID']); 
  $from = preg_replace('#[^0-9]#i', '', $_POST['senderID']); 
  //$toName = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['rcpntName']); 
  //$fromName = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['senderName']); 
  $msg = htmlspecialchars($_POST['message']); // Convert html tags and such to html entities which are safer to store and display
  $msg  = mysqli_real_escape_string($connection, $msg); // Just in case anything malicious is not converted, we escape those characters here
  // Handle all pm form specific error checking here 
  if (empty($to) || empty($from) || empty($msg)) { 
    echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  Missing Data to continue';
	exit();
  } else { 
		// Delete the message residing at the tail end of their list so they cannot archive more than 100 PMs ------------------
        $sqldeleteTail = mysqli_query($connection, "SELECT * FROM messages WHERE receiver_id='$to' ORDER BY time_sent DESC LIMIT 0,100"); 
        $dci = 1;
        while($row = mysqli_fetch_array($sqldeleteTail)){ 
                $pm_id = $row["id"];
				if ($dci > 99) {
					$deleteTail = mysqli_query($connection, "DELETE FROM messages WHERE id='$pm_id'"); 
				}
				$dci++;
        }
        // End delete any comments past 100 off of the tail end -------------  
		
    // INSERT the data into your table now
    $sql = "INSERT INTO messages (receiver_id, sender_id, time_sent, message) VALUES ('$to', '$from', now(), '$msg')"; 
    
      if ($query_run == mysqli_query($connection, $sql)) { 
	    
          echo '<img src="../../images/messages/round_success.png" alt="Success" width="60" height="60" /> &nbsp;  Message Sent';
        
        header('location: ../../index.php');
	    exit();
    } else { 
        echo '<img src="../../images/messages/round_error.png" alt="Error" width="60" height="60" /> &nbsp;  Could not send message!';
        
        exit();
    } 
       
      
      // close else after the sql DB INSERT check
  } // Close if (empty($msg)) { 
} // Close if (isset($_POST['message'])) { 
?>