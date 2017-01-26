<?php
require_once './core.inc.php';
require './connect.inc.php';
global $connection;

$output = '';

if(isset($_POST['html']) && isset($_POST['departure']) && isset($_POST['destination']) && isset($_POST['date']) && isset($_POST['type'])) {
	$departure = htmlentities($_POST['departure']);
	$destination = htmlentities($_POST['destination']);
	
	$date_entered = htmlentities($_POST['date']);
	$date_array = preg_split("/[-\/s,]+/", "2017/04-02");
	$yy = $date_array[0];
	$mm = $date_array[1];
	$dd = $date_array[2];
	$date1 = $yy."/".$mm."/".$dd;
	$date2 = $yy."-".$mm."-".$dd;
	
	$transport = htmlentities($_POST['type']);

	if(!empty($departure)&&!empty($destination)&&!empty($date_entered)) {

		if($transport==='o'){     
			echo '<h2 class="search_results_heading" id="results_heading">Offered transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>" on the '.$date1.'</h2>';
		}
		else {
			?>
			<span class="offering_heading" id="offering_heading">
				<?php echo '<h2 class="search_results_heading" id="results_heading">Commuters looking for transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>" on the '.$date1.'</h2>'; ?>
			</span>
			<?php
		}

		//query database
		$query1 = "SELECT * FROM `adverts` WHERE 
			`departure` LIKE '%".mysqli_real_escape_string($connection, $departure)."%' 
			AND `destination` LIKE '%".mysqli_real_escape_string($connection, $destination)."%' 
			AND `date`='".mysqli_real_escape_string($connection, $date1)."' OR `date`='".mysqli_real_escape_string($connection, $date2)."'
			AND `type`='".mysqli_real_escape_string($connection, $transport)."'
			";
		
		//Running the Query
		if ($query_run = mysqli_query($connection, $query1)) {
			$query_num_rows = mysqli_num_rows($query_run);   
            
			// User input (departure & destination) is NOT found in the `offered` database
			if($query_num_rows === 0){
				echo '<h2 id="results_heading">No Result(s)</h2>
				<p style"text-align:center;font-size:15px;">No travel plans posted for that date.</p>';
			} 
			else if ($query_num_rows > 0) {
				$i = 1;   
				
				while ($rows = mysqli_fetch_array($query_run)) {
					$description = $rows['description'];
					$departure = $rows ['departure'];
					$destination = $rows ['destination'];
					$date = $rows['date'];           
					$time = $rows['time'];      
					$amount = $rows['amount'];
					
					$ad_user_id = $rows['user_id']; 
					$ad_id = $rows['id'];
					//Select the ad owners information
					$session_user_gender = echo_session_user_gender();
					
					if ($session_user_gender = 'female'){
						$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ORDER BY gender asc";
					}	
					else{
						$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ORDER BY gender asc";
					}

					if ($query_run2 = mysqli_query($connection, $query2)) {
						$query_num_rows2 = mysqli_num_rows($query_run2);
						if($query_num_rows==1) {
							while ($rows = mysqli_fetch_array($query_run2)) {
								$ad_user_name =  $rows['name'];
								$ad_user_picture_url = $rows['picture_url'];
								$ad_user_phoneNumber = $rows['phoneNumber'];
								$ad_user_email = $rows['email'];
								$ad_user_gender = $rows['gender'];
							}
						}
					}
					
					?>
					<div class="all_results" id="all_results">                                             
						<div id="container">

							<div id="lefty">
								<div id="profile_imgs">
									<?php 
									echo '<a href="./profile.html?'.$ad_user_id.'">
									<img id="profile_image_of_ad_user" src="'.$ad_user_picture_url.'" />
									</a>'; ?>                                            
								</div>
								<div id="profile_info">
									<h4 id="profile_name"><?php echo $ad_user_name; ?></h4>
									<span id="profile_name"><strong><?php echo $ad_user_gender; ?></strong></span>
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
								<br>
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

								<!--    ADD TO WISH LIST    -->
								<button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
									<img class="heart" id="<?php echo $ad_id; ?>heart1" src="../images/icons/posts/heart.png" />
									<img class="addedwishlist" id="<?php echo $ad_id; ?>heart2" src="../images/icons/posts/added_to_wishlist.png" />
								</button>
							</div>

							<!--    REQUEST TO BOOK SCRIPT-->    
							

							<!--    ADD TO WISH LIST SCRIPT   -->    
							

						</div>
					</div>
					<?php
                    $i ++;
				}
			}
		
		}
	}
	else{
		echo '<h2 id="results_heading"> All fields are required.</h2>';
	}                        
} 

if(isset($_POST['index']) && isset($_POST['departure'])&&isset($_POST['destination'])&&isset($_POST['date'])&&isset($_POST['type'])){
	$departure = htmlentities($_POST['departure']);
	$destination = htmlentities($_POST['destination']);
	$date = htmlentities($_POST['date']);
	$transport = htmlentities($_POST['type']);

	if(!empty($departure)&&!empty($destination)&&!empty($date)) {

		if($transport==='o'){     
			echo '<h2 class="search_results_heading" id="results_heading">Offered transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>" on the '.$date.'</h2>';
		}
		else {
			?>
			<span class="offering_heading" id="offering_heading">
				<?php echo '<h2 class="search_results_heading" id="results_heading">Commuters looking for transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>" on the '.$date.'</h2>'; ?>
			</span>
			<?php
		}

		//query database
		$query1 = "SELECT * FROM `adverts` WHERE 
			`departure` LIKE '%".mysqli_real_escape_string($connection, $departure)."%' 
			AND `destination` LIKE '%".mysqli_real_escape_string($connection, $destination)."%' 
			AND `date` LIKE '%".mysqli_real_escape_string($connection, $date)."%'
			AND `type`='".mysqli_real_escape_string($connection, $transport)."'
			"; 
		
		//Running the Query
		if ($query_run = mysqli_query($connection, $query1)) {
			$query_num_rows = mysqli_num_rows($query_run);   
            
			// User input (departure & destination) is NOT found in the `offered` database
			if($query_num_rows === 0){
				echo '<h2 id="results_heading">No result(s)</h2>';
			} 
			else if ($query_num_rows>0) {
				$i = 1;   
				
				while ($rows = mysqli_fetch_array($query_run)) {
					$description = $rows['description'];
					$departure = $rows ['departure'];
					$destination = $rows ['destination'];
					$date = $rows['date'];           
					$time = $rows['time'];      
					$amount = $rows['amount'];
					
					$ad_user_id = $rows['user_id']; 
					$ad_id = $rows['id'];
					//Select the ad owners information
					$session_user_gender = echo_session_user_gender();
					
					if ($session_user_gender = 'female'){
						$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ORDER BY gender asc";
					}	
					else{
						$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ORDER BY gender asc";
					}

					if ($query_run2 = mysqli_query($connection, $query2)) {
						$query_num_rows2 = mysqli_num_rows($query_run2);
						if($query_num_rows==1) {
							while ($rows = mysqli_fetch_array($query_run2)) {
								$ad_user_name =  $rows['name'];
								$ad_user_phoneNumber = $rows['phoneNumber'];
								$ad_user_email = $rows['email'];
								$ad_user_gender = $rows['gender'];
							}
						}
					}
					
					//Check FOR USER PROFILE NAME                            
					$images = glob("../images/users/".$ad_user_id."*.{jpeg,jpg,png}", GLOB_BRACE);
					foreach($images as $image)
						$user_profile_picture_name = basename($image);
					
					?>
					<div class="all_results" id="all_results">                                             
						<div id="container">

							<div id="lefty">
								<div id="profile_imgs">
									<?php 
									echo '<a href="view_my_profile/viewmyprofile.php/'.getusername($ad_user_id).'">
									<img id="profile_image_of_ad_user" src="images/users/'.$user_profile_picture_name.'" />
									</a>'; ?>
								</div>
								
								<div id="righty_departure_and_destination">
									<img id="departure_destination_image" src="images/icons/posts/departure_destination.png" />

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
								<br>
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

								<!--    REQUEST TO BOOK-->
								<br>
								<button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="send_message(<?php echo $ad_id; ?>)">
									Send Message
								</button>

								<!--    ADD TO WISH LIST    -->
								<button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
									<img class="heart" id="<?php echo $ad_id; ?>heart1" src="images/icons/posts/heart.png" />
									<img class="addedwishlist" id="<?php echo $ad_id; ?>heart2" src="images/icons/posts/added_to_wishlist.png" />
								</button>
							</div>

							<!--    ADD TO WISH LIST SCRIPT   -->    
							<script type="text/javascript">
								function add_to_wishlist(id){
									var ad_id = id;
									$.post('index.php', {ad_id: ad_id, status:"wishlist"});
								}
							</script>

						</div>
					</div>
					<?php
                    $i ++;
				}
			}
		
		}
	}
	else{
		echo '<h2 id="results_heading"> All fields are required.</h2>';
	}                        
} 
?>