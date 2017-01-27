<?php
require './core.inc.php';
require './connect.inc.php';
require './view.php';
global $connection;
error_reporting(E_ALL);

$user_id = $_POST['session_user'];
//User that owns the ad
//$ad_user_id = get_ad_user_id();
$ad_user_id = $_POST['session_user'];


// Decode the Session IDX variable and extract the user's ID from it
$decryptedID = base64_decode($user_id);
$id_array = explode("p3h9xfn8sq03hs2234", $decryptedID);

$_SESSION['username'] = getusername($user_id);
$my_uname = $_SESSION['username'];// Put user's first name into a local variable


// ------- ESTABLISH THE INTERACTION TOKEN ---------
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum); // Will always overwrite itself each time this script runs
// ------- END ESTABLISH THE INTERACTION TOKEN ---------



// Mailbox Parsing for deleting inbox messages
if (isset($_POST['deleteBtn'])) {
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
		if ($key != "deleteBtn") {
		   $sql = mysqli_query($connection, "UPDATE messages SET recipient_delete='1', opened='1' WHERE id='$value' AND receiver_id='$user_id' LIMIT 1");
		   // Check to see if sender also removed from sent box, then it is safe to remove completely from system
		}
    }
	header('location: ../inbox.php/'.getuserfield('firstName').'');
}

if(isset($_POST['delete_msg'])){
	$msg_id = mysqli_real_escape_string($connection, $_POST['delete_msg']);
	
	$query = mysqli_query($connection, "DELETE from `messages` WHERE id='$msg_id'");
	
	if($query_run = mysqli_query($connection, $query)){
		echo "deleted";
		exit();
	}
}


if(isset($_POST['inbox'])){
	$session_user = $_POST['session_user'];
	?>
	<table id="table_container">
            <tr>
                <td id="table_container_td">
                    <!-- START THE PM FORM AND DISPLAY LIST -->
                    <form name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <?php
                        ///////////End take away///////////////////////
                        // SQL to gather their entire PM list
                        $sql = mysqli_query($connection, "SELECT * FROM messages WHERE receiver_id=".mysqli_real_escape_string($connection, $session_user)." AND recipient_delete='0' ORDER BY id DESC LIMIT 100");

                        if(mysqli_num_rows($sql)>0){
                            while($row = mysqli_fetch_array($sql)){ 
                                $date = strftime("%b %d, %Y",strtotime($row['time_sent']));

                                if($row['opened'] == "0"){
                                        $textWeight = 'msgDefault';
                                } else {
                                        $textWeight = 'msgRead';
                                }

                                $fr_id = $row['sender_id']; $msg_id = $row['id'];   

                                // SQL - Collect username for sender inside loop
								$query = "SELECT * FROM `users` WHERE `id`='$fr_id' LIMIT 1";
                                $query_run = mysqli_query($connection, $query);
                                while($raw = mysqli_fetch_array($query_run)){
                                    $Fname = $raw['name'];
									$ad_user_picture_url = $raw['picture_url'];
                                }

                                ?>
                                <table id="message_container">
                                    <tr>
                                        <td id="sender_image_container">
											<?php           
											echo '<a href="./profile.html?'.$fr_id.'">';?>
												<img id="profile_image_of_ad_user" src="<?php echo 'https://'.$ad_user_picture_url; ?>" />
											<?php echo '</a>'; ?>
                                        </td>

                                        <td id="sender_message_container">
											<?php
											echo '<a id="sender_name" href="../view_my_profile/viewmyprofile.php/'.getusername($fr_id).'">'.$Fname.'</a>';
											?>
                                            <span class="toggle" style="padding:3px;">
                                                <br>
                                                <a class="<?php echo $textWeight; ?>" id="subj_line_<?php echo $row['id']; ?>" style="cursor:pointer;" onclick="markAsRead(<?php echo $row['id']; ?>)">
                                                    <?php echo stripslashes($row['message']); ?>
                                                </a>

                                            </span>

                                            <div class="hiddenDiv"> 
                                                <!--< ?php echo stripslashes(wordwrap(nl2br($row['message']), 54, "\n", true)); ?>-->
                                                <a id="reply_a" href="javascript:toggleReplyBox('<?php echo $my_uname; ?>','<?php echo $session_user; ?>','<?php echo $Fname; ?>','<?php echo $fr_id; ?>','<?php echo $thisRandNum; ?>')">
                                                    Reply
                                                </a>
                                            </div>
											
											<div id="message_options">
												<button class="delete_button" id="delete.<?php echo $row['id']; ?>" type="button" onclick="delete_msg('<?php echo $row['id']; ?>')">Delete Message</button>
												
												<button class="reply" id="reply.<?php echo $row['id']; ?>" type="button" onclick="reply_msg(<?php echo $msg_id; ?>)">Reply</button>
											</div>
                                        </td>

                                        <td id="sender_date_container">
                                            <span style="font-size:10px;">
                                                <?php echo $date; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            <?php
                            }
                        }
                        else{
                            echo '<h2 style="text-align: center;">No message(s)</h2>';
                        }
                        
                        // Close Main while loop
                        ?>
                    </form>
                    <!-- END THE PM FORM AND DISPLAY LIST -->
                    
                    
                    <!-- Start Hidden Container the holds the Reply Form -->            
                    <div id="replyBox">
                        <div id="close_container">
                            <a href="javascript:toggleReplyBox('close')">
                                <span id="close">CLOSE</span>
                            </a>
                        </div>
                    
                        <h3>Replying to 
                            <span id="recipientShow"></span>
                        </h3>

                        <form action="javascript:processReply();" name="replyForm" id="replyForm" method="post">
                            <textarea id="pmTextArea" rows="8"></textarea>
                            <input type="hidden" id="pm_rec_id" />
                            <input type="hidden" id="pm_rec_name" />
                            <input type="hidden" id="pm_sender_id" />
                            <input type="hidden" id="pm_sender_name" />
                            <input type="hidden" id="pmWipit" />
                            <br />
                            <input id="replyBtn" name="replyBtn" type="button" onclick="javascript:processReply()" /> 
                            &nbsp;&nbsp;&nbsp; 
                            <span id="pmFormProcessGif">
                                <img src="../images/messages/loading.gif" width="28" height="10" alt="Loading" />
                            </span>
                            <div id="PMStatus" style="color:#F00; font-size:14px; font-weight:700;">&nbsp;</div>
                        </form>
                    </div>
                    <!-- End Hidden Container the holds the Reply Form -->     
                    
                    
                    <!-- Start PM Reply Final Message box showing user message status when needed -->    
                    <div id="PMFinal" style="display:none; width:652px; background-color:#005900; border:#666 1px solid; top:51px; position:fixed; margin:auto; z-index:50; padding:40px; color:#FFF; font-size:16px;"></div>
                    <!-- End PM Reply Final Message box showing user message status when needed --> 
                </td>
                
                
            </tr>
        </table>
	<?php
}
?>