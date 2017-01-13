<?php
require_once './core.inc.php';
require_once './connect.inc.php';
require './view.php';
global $connection;

// Checking if the logged in User and the
//Logged in User
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
//User that owns the ad
//$ad_user_id = get_ad_user_id();
//  FUNCTION

if(isset($_POST['profile'])){
	$ad_user_id = $_POST['profile'];
	
	function view_my_profile($USERID){ 
		global $connection;

		//Searching Users
		$query = "SELECT * FROM `users` WHERE `id`=".mysqli_real_escape_string($connection, $USERID)." ";
		//Running the Query
		if ($query_run = mysqli_query($connection, $query)) {
			$query_num_rows = mysqli_num_rows($query_run);             

			if ($query_num_rows === 1) {                
				$rows = mysqli_fetch_array($query_run);
				if ($rows) {                
					$name = $rows['name'];
					$phoneNumber = $rows['phoneNumber'];
					$picture_url = $rows['picture_url'];
					$email = $rows['email'];
					$gender = $rows['gender'];
					
					?>
					<div id="account">
						<div class="container-fluid">

							<div id="account_image">
								<img id="profile_image" src="<?php echo 'https://'.$picture_url; ?>" />
							</div>

							<div id="account_details">
								<h2 id="profile_name">
									<?php echo $name?>
									<script>
										_("profile_name").innerHTML = localStorage.getItem("name");
									</script>
								</h2>

								<p id="account_personal_details">
									<?php echo 'Mobile<strong>:</strong> '.$phoneNumber.'<br>'.$email.'<br><strong>'.$gender.'</strong>'; ?>
								</p>
							</div>
						</div>
					</div>
					<?php
				}
			} 
		}
	}
	
	?>
	<!--            Section bar         -->    
	<section id="profile_contents">  
		<div class="" id="user_profile">      
			<?php
			if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $ad_user_id){
				$profile = view_my_profile($_SESSION['user_id']);
				
				?>
				<!--	P R I N T	S E A R C H		R E S U L T S-->		
				<div id="search_results"></div>
				
				<!--	V I E W		A L L		P O S T S-->
				<div class="view_all_ads" id="view_all_ads">
					<?php   view_my_ads($user_id); ?>
                </div>
				<?php
			}else{
				$profile = view_my_profile($ad_user_id);
				?>
				<!--	P R I N T	S E A R C H		R E S U L T S-->		
				<div id="search_results"></div>
				
				<!--	V I E W		A L L		P O S T S-->
				<div class="view_all_ads" id="view_all_ads">
					<?php $my_ads = view_my_ads($ad_user_id); ?>
                </div>
				<?php
            }
			?>
        </div>
	</section>
            
	<!--            FOOTER          -->
	<footer>
            <div class="container-fluid">
                    
                <ul id="footer_info">
                    <li class="footer_items" id="about_us">
                        <a id="footer_links" href="../about_us/about_us.php#company_info?">About Us</a>
                    </li>
                    <li class="footer_items" id="privacy">
                        <a id="footer_links" href="../about_us/about_us.php#terms_info">Privacy & Terms</a>
                    </li>
                    <li class="footer_items" id="Careers">
                        <a id="footer_links" href="../about_us/about_us.php#careers_info">Careers</a>
                    </li>
                    <li class="footer_items" id="contact_us">
                        Contact Us
                    </li>
                </ul>
                
                <div id="contact_us_form">
                    <h2 id="contact_us_heading">Contact Us</h2>
                        
                    <form id="contact_us" name="contact_us" method="post">
                        <label id="name_label" for="name_input">Name:</label>
                        <input id="name_input" type="text" name="name_input" />
                        
                        <br>
                        <label id="email_label" for="email_input">Email:</label>
                        <input id="email_input" type="email" name="email_input" />
                        
                        <br>
                        <label id="message_label" for="message_input">Message:</label>
                        <textarea id="message_input" name="message_input" rows="10" cols="50"></textarea>
                            
                        <br>
                        <button id="submit_contact_us_form" type="submit" name="submit_contact_us_form">Submit</button>
                            
                        <p id="physical_information">
                            email: info@namela.co.za
                            <br>Tel: 011 283 2044/3854
                            <br>Physical Address: 12 Rivonia drive, Sandton
                        </p>
                    </form>                    
                </div>
            </div>
        </footer>
        
        
	<script src="../js/universal.js"></script>
	<script src="../js/viewmyprofile.js"></script>
	<script type="text/javascript" src="../js/mobile_menu.js"></script>
	<script type="text/javascript" src="../js/profilepicture.js"></script>
	<?php
}




if (isset($_POST['delete'])) {
    // get id value
    $user_id = $_SESSION['user_id'];
    $ad_id = $_POST['delete'];
 
    // delete the entry 
    $query = "DELETE FROM `adverts` WHERE `id`='".mysqli_real_escape_string($connection, $ad_id)."'"; 
    
	if($query_run = mysqli_query($connection, $query)){
		echo "deleted";
	}
}


if(isset($_POST['add_to_wishlist'])){
	$ad_id = $_POST['add_to_wishlist'];
	
	$query = "SELECT * FROM `wishlist` WHERE `session_user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' AND `ad_id`='".mysqli_real_escape_string($connection, $ad_id)."'";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
         
		//Add to wishlist
		if($query_num_rows===0){
			$query2 = "  INSERT INTO `wishlist` VALUES 
                                        (
                                        '',
                                        '".mysqli_real_escape_string($connection, $_SESSION['user_id'])."',
                                        '".mysqli_real_escape_string($connection, $ad_id)."'
                                        )
                                        ";
			if(mysqli_query($connection, $query2)){
				echo 'Added to Wishlist';
				exit();
			}
		}
	}
}
?>