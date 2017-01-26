<?php
require './core.inc.php';
require './connect.inc.php';
error_reporting(E_ALL);
global $connection;

if(isset($_POST['wishlist'])){
    global $connection;
    $query = "SELECT * FROM `wishlist` WHERE `session_user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ";
    
    if ($query_run = mysqli_query($connection, $query)) {
        $query_num_rows = mysqli_num_rows($query_run);

        if($query_num_rows === 0){
            ?>
            <h2 id="no_result_head">No Result(s)</h2>
            <p id="no_result_news">
                There are (0) items in your wishlist.
            </p>
            <?php
        } 
                
        else if ($query_num_rows>0) {
            //Search and echo all database results
            while ($rows = mysqli_fetch_array($query_run)) {
                $ad_id = $rows ['ad_id'];
                $query2 = "SELECT * FROM `adverts` WHERE `id`='".mysqli_real_escape_string($connection, $ad_id)."'";
                        
                //Getting ad-information
                if ($query_run2 = mysqli_query($connection, $query2)){
                    $query_num_rows2 = mysqli_num_rows($query_run2);
                        
                    if ($query_num_rows2===1) {
                        while ($rows = mysqli_fetch_array($query_run2)) {
                            $ad_user_id = $rows['user_id'];
                                
                            $description = $rows['description'];
                            $departure = $rows['departure'];
                            $destination = $rows['destination'];
                            $date = $rows['date'];
                            $time = $rows['time'];
                            $amount = $rows['amount'];
                                
                            //Getting ad-owner information
                            $query3 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ";
                            if($query_run3 = mysqli_query($connection, $query3)){
                                $query_num_rows3 = mysqli_num_rows($query_run3);
                        
                                if ($query_num_rows3===1) {
                                    while ($rows = mysqli_fetch_array($query_run3)) {
                                        
                                        $id = $rows['id'];
                                        $name = $rows['name'];
										$picture_url = $rows['picture_url'];
                                        $phoneNumber = $rows['phoneNumber'];
                                        $email = $rows['email'];
                                        $gender = $rows['gender'];
                                    }                        
                                }                    
                    		}
                        }
                    }
                              
                    
                    ?>
                    <div class="all_results" id="all_results">                                             
						<div id="container">

							<div id="lefty">
								<div id="profile_imgs">
									<?php echo '<a href="./profile.html?'.$id.'">';?>
									<img id="profile_image_of_ad_user" src="<?php echo 'https://'.$picture_url; ?>" />
									<?php echo '</a>'; ?>
								</div>
								<div id="details">
									<?php echo $name.'<br><strong>'.$gender.'</strong>'; ?>
								</div>
								<div id="righty_departure_and_destination">
									<img id="departure_destination_image" src="../images/icons/posts/departure_destination.png" />

									<div id="post_departure_and_destination">									
										<p id="post_departure_tag">
											<span id="post_departure">From: </span>
											<?php echo $departure ?>
										</p>
										
										<p id="post_destination_tag">
											<span id="post_destination">To: </span> <?php echo $destination ?>
										</p>
									</div>                                        
								</div>
							</div>

							<div id="righty">
								<span id="post_date_tag">
									<span id="post_date">Date:</span>
									<?php echo $date ?> 
								</span>
								<span id="post_time_tag">
									<span id="post_time">Time:</span>
									<?php echo $time ?> 
								</span>
								<br>
								<span id="post_amount_tag">
									<span id="post_amount">Amount:</span>
									<?php echo "R".$amount ?> 
								</span>

								<p id="post_information">
									<span id="more_information_text">more information:</span>
									<span id="post_more_information"><?php echo '" '.$description.' "'; ?></span>
								</p>

								<!--   SEND MESSAGE	-->
								<button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="send_message(<?php echo $ad_id; ?>)"> Send Message</button>

								<!--    Delete TO WISH LIST    -->
								<button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="delete_from_wishlist(<?php echo $ad_id; ?>)">Remove</button>
							</div>
						</div>
					</div>
                	<?php
            	}
        	}
    	}
    }
    else{
        ?>
            <h2 id="no_result_head">No results</h2>
            <p id="no_reseult_news">
                Find posts you are interested in here by clicking "heart" on each of them.
            </p>
            <?php
    }
}

if(isset($_POST['delete_from_wishlist'])){
	$ad_id = $_POST['delete_from_wishlist'];
	$user_id = $_POST['session_user'];
	
	$query = "DELETE FROM `wishlist` WHERE `session_user_id`='".mysqli_real_escape_string($connection, $user_id)."' AND `ad_id`='".mysqli_real_escape_string($connection, $ad_id)."'";
	if (mysqli_query($connection, $query)){
		echo 'deleted';
		exit();
	}
	exit();
}
?>