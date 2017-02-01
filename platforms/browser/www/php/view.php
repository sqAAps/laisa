<?php    
require_once './core.inc.php';
require './connect.inc.php';
global $connection;

//	P R O F I L E  P O S T S
function view_my_ads($USERID, $session_user){
    global $connection;
    
    $welcome = '<h2 id="results_heading">Offering Transport</h2>';
    $type = 'o';
    $query = "SELECT * FROM `adverts` 
                WHERE `user_id`='".mysqli_real_escape_string($connection, $USERID)."'
                AND `type`='".mysqli_real_escape_string($connection, $type)."'
            ORDER BY `date`  ";
    
    for ($count = 1; $count <= 2; $count ++) {
        if ($query_run = mysqli_query($connection, $query)) {
            $query_num_rows = mysqli_num_rows($query_run);
        
            //Welcome
            ?>
            <html>
                <span class="offering_heading" id="offering_heading">
                    <?php    echo $welcome; ?>
                </span>
            </html>
            <?php               
    
            if($query_num_rows === 0){
				if ($session_user === $USERID){
					if($type === "o"){
						echo '<h2 id="no-reviews">No Result(s)</h2>
				<p style="text-align:center;font-size:15px;padding:0px 5%;">You have not posted any Travel Plans offering transport. <br>Click "Add Post" (Top-Left) to post.</p>';
					}else{
						echo '<h2 id="no-reviews">No Result(s)</h2>
				<p style="text-align:center;font-size:15px;padding:0px 5%;">You have not posted any Travel Plans seeking transport. 
				<br>Click "Add Post" (Top-Left) to post.</p>';
					}
				}else{
					if($type === "o"){
						echo '<h2 id="no-reviews">No Result(s)</h2>
				<p style="text-align:center;font-size:15px;padding:0px 5%;">This user has not posted any Travel Plans offering transport.</p>';
					}else{
					echo '<h2 id="no-reviews">No Result(s)</h2>
				<p style="text-align:center;font-size:15px;padding:0px 5%;">This user has not posted any Travel Plans seeking transport.</p>';
					}
				}
            } 
            
			
            else if ($query_num_rows > 0) {
                $i = 1;
                while ($rows = mysqli_fetch_array($query_run)) {
                    $ad_id = $rows ['id'];
                    $description = $rows ['description'];
                    $departure = $rows ['departure'];
                    $destination = $rows ['destination'];
                    $date = $rows ['date'];
                    $time = $rows ['time'];
                    $amount = $rows ['amount'];
                    
                    
                    if ($user_id === $ad_user_id){
                        ?>
                        <div class="all_results" id="all_results">                                
							<div id="righty">
                                    
								<div id="righty_departure_and_destination">
									<img id="departure_destination_image" src="../images/icons/posts/departure_destination.png" />
                                        
									<div id="post_departure_and_destination">
										<span id="post_departure_tag">
											<span id="post_departure">Departure: </span>
											<?php echo $departure ?>
										</span>  
										<br>
										<span id="post_destination_tag">
											<span id="post_destination">Destination: </span>
											<?php echo $destination ?>
										</span>
									</div>                                        
								</div>
                                    
								<p id="post_details">                                        
									<span id="post_date_tag">
										<span id="post_date">Date:</span>
										<?php echo $date ?> 
									</span>
                                    
									<span id="post_time_tag">
										<span id="post_time">Time:</span>
										<?php echo $time ?> 
									</span>
                                    
									<span id="post_amount_tag">
										<span id="post_amount">Amount:</span>
										<?php echo "R".$amount ?> 
									</span>
								</p>
                                    
								<p id="post_information">
									<span id="more_information_text">More information:</span>
									<span id="post_more_information">
										<?php echo '" '.$description.' "'; ?>
									</span>
								</p>
                                    
								<!--    Edit & Delete Advert-->
								<?php
								echo '<form id="hidden_ad_id_form" method="post">
                                        <input id="hide_ad_id" type="text" name="edit" value='.$ad_id.'>
                                        <a href="./edit.html?'.$user_id.'&'.$ad_id.'">
											<button class="" id="edit" type="button" >Edit</button>
                                        </a>
									</form>
                                       
                                    <form id="hidden_ad_id_form" method="post" >
                                        <input id="hide_ad_id" type="text" name="delete" value='.$ad_id.'>
										<button class="" id="delete" type="button" onclick="delete_post('.$ad_id.')" >Delete</button>'.                                   
                                    '</form>';
								?>
							</div>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="all_results" id="all_results">
							<div id="righty">
                                    
								<div id="righty_departure_and_destination">
									<img id="departure_destination_image" src="../images/icons/posts/departure_destination.png" />
                                        
									<div id="post_departure_and_destination">
										<span id="post_departure_tag">
											<span id="post_departure">Departure: </span>
											<?php echo $departure ?>
										</span>            
										<br>
										<span id="post_destination_tag">
											<span id="post_destination">Destination: </span> <?php echo $destination ?>
										</span>
									</div>                                        
								</div>
                                    
								<p id="post_details">                                        
									<span id="post_date_tag">
										<span id="post_date">Date:</span>
										<?php echo $date ?> 
									</span>
                                    
									<span id="post_time_tag">
										<span id="post_time">Time:</span>
										<?php echo $time ?> 
									</span>
                                    
									<span id="post_amount_tag">
										<span id="post_amount">Amount:</span>
										<?php echo "R".$amount ?> 
									</span>
								</p>
                                    
								<p id="post_information">
									<span id="more_information_text">more information:</span>
									<span id="post_more_information"><?php echo '" '.$description.' "'; ?></span>
								</p>
                                    
								<!--    REQUEST TO BOOK-->
								<button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="send_message(<?php echo $ad_id; ?>)">
									Send Message
                                </button>
                                    
								<!--    ADD TO WISH LIST    -->
								<button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
									<img class="heart" id="<?php echo $ad_id; ?>heart1" src="../images/icons/posts/heart.png" />
                               	</button>
							</div>
                        </div>
                    	<?php
                    }
                    $i ++; 
                }
            }
        }
        
		$welcome = '<h2 id="results_heading">Seeking Transport</h2>';
        $type = 'w';
        $query = "SELECT * FROM `adverts` 
                    WHERE `user_id`='".mysqli_real_escape_string($connection, $USERID)."' 
                    AND `type`='".mysqli_real_escape_string($connection, $type)."'
                ORDER BY `date`  ";
    }
}

?>