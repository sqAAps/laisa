<?php    
require_once './core.inc.php';
require './connect.inc.php';
global $connection;



/*//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
                PROFILE POSTS
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////*/

    /*//////////////////////////////////////////////////////////////////////
            ONCE-OFF POSTS
    ///////////////////////////////////////////////////////////////////////*/
/*  all once-off posts*/
function view_my_ads($USERID){
    global $connection;
    if( isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
	//$ad_user_id = get_ad_user_id();
    $ad_user_id = $USERID;
    
    $welcome = '<h2 id="results_heading"> Offering Transport</h2>';
    
    $type = 'o';
    //Searching MY OFFERED ads
    $query = "SELECT * FROM `adverts` 
                WHERE `user_id`='".mysqli_real_escape_string($connection, $USERID)."'
                AND `type`='".mysqli_real_escape_string($connection, $type)."'
            ORDER BY `date`  ";
    
    
    for ($count = 1; $count <= 2; $count ++) {
        //Running the Query
        
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
    
            // N O 	R E S U L T S
            if($query_num_rows === 0){
				if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $USERID){
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
                    
                    //  Profile Picture
                    $images = glob("../images/users/".$USERID."*.{jpeg,jpg,png}", GLOB_BRACE);
                    foreach($images as $image){
                        $user_profile_picture_name = basename($image);
                    }
                    
                    //If the Session is the Ad owner, You can edit your adverts
                    if (isset($_SESSION['user_id']) && $user_id === $ad_user_id){
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
                                        <span id="more_information_text">More information:</span>
                                        <span id="post_more_information"><?php echo '" '.$description.' "'; ?></span>
                                    </p>
                                    
                                    <!--    Edit & Delete Advert-->
                                    <?php
                                    echo
                                    '<form id="hidden_ad_id_form" method="post">
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
                    }
                    else{
                        //User CANNOT edit OR delete these adverts
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
        
        $type = 'w';
        $query = "SELECT * FROM `adverts` 
                    WHERE `user_id`='".mysqli_real_escape_string($connection, $USERID)."' 
                    AND `type`='".mysqli_real_escape_string($connection, $type)."'
                ORDER BY `date`  ";
        $welcome = '<h2 id="results_heading">Seeking Transport</h2>';
    }
}


/*//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
                INDEX POSTS

/*/////////////ALL WANTED TRANSPORT POSTS////////////////////*/
function view_all_wanted_ads(){
    global $connection;
    //Logged in user ID
    $user_id = $_SESSION['user_id'];
    
    //Searching MY OFFERED ads
    $type = 'w';
    $query = "SELECT * FROM `adverts` WHERE `type`='".mysqli_real_escape_string($connection, $type)."' ORDER BY `date`  ";
    //Running the Query
    if ($query_run = mysqli_query($connection, $query)) {
        $query_num_rows = mysqli_num_rows($query_run);
        
        //Welcome
        ?>
        <html>
            <span class="offering_heading" id="offering_heading">
                <?php  echo '<h2 id="results_heading">Commuters looking for transport</h2>'; ?>
            </span>
        </html>
        <?php                 
    
        // User offered adverts are NOT found in the `offered` database
        if($query_num_rows==0){
            echo '<h3>No result(s) </h3>';
        } 
        //User offered adverts Are found in the `offered` databas
        //There might be more more than ONE result.
        else if ($query_num_rows>0) {
                
            //Search and echo all database results
            $i = 1;
            while ($rows = mysqli_fetch_array($query_run)) {
                $ad_id = $rows ['id'];
                $description = $rows ['description'];
                $departure = $rows ['departure'];
                $destination = $rows ['destination'];
                $date = $rows ['date'];
                $time = $rows ['time'];
                $amount = $rows ['amount'];
                    
                //get each ads owner
                $ad_user_id = $rows['user_id'];
                    
                //ad owbers details
                $query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."' ";
                if($query_run2 = mysqli_query($connection, $query2)){
                    $query_num_rows2 = mysqli_num_rows($query_run2);
                    
                    if ($query_num_rows2===1) {                            
                        while ($rows = mysqli_fetch_array($query_run2)) {
                            $id = $rows['id'];
                            $name =  $rows['name'];
                            $phoneNumber = $rows['phoneNumber'];
                            $email = $rows['email'];
                            $gender = $rows['gender'];
                        }
                    }    
                } 
                //IF this is the session_users AD, DON'T show it
                if($_SESSION['user_id'] !== $ad_user_id){
                        
                    //Check FOR USER PROFILE NAME                            
                    $images = glob("images/users/".$id."*.{jpeg,jpg,png}", GLOB_BRACE);
                    foreach($images as $image)
                    $user_profile_picture_name = basename($image);
                
                    $output = '<div id="container">
                                    <a href="http://localhost/projects/namela/view_my_profile/viewmyprofile.php/'.getusername($ad_user_id).'">
                                        <img id="profile_image_of_ad_user" src="images/users/'.$user_profile_picture_name.'" />
                                    </a>
                                
                                    <p id="left_container">
                                        <strong>Departure: </strong>'.$departure.' <strong>Destination: </strong> '.$destination
                                        .'<br><strong>Date:</strong> '.$date.' <strong><br>Time:</strong> '.$time
                                        .'<br><strong>Description:</strong> '.$description
                                        
                                    .'</p>
                                </div>';
                ?>
                 <div class="all_results" id="all_results">
                                
                            <div id="container">
                                <div id="lefty">
                                    
                                    <?php echo '<a href="http://localhost/projects/namela/view_my_profile/viewmyprofile.php/'.getusername($ad_user_id).'">
                                        <img id="profile_image_of_ad_user" src="images/users/'.$user_profile_picture_name.'" />
                                    </a>' ?>
                                            
                                    <img id="rating" src="images/icons/posts/rating.png" />
                                </div>
                                    
                                <div id="righty">
                                    
                                    <div id="righty_departure_and_destination">
                                        <img id="departure_destination_image" src="images/icons/posts/departure_destination.png" />
                                        
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
                            
                            </div>
                                
                                <!--    REQUEST TO BOOK SCRIPT-->    
                                <script type="text/javascript">                                     
                                    function request_to_book(id){
                                        var ad_id = id;

                                        $.post('index.php', {ad_id: ad_id, status:"request"});
                                    }                                    
                                </script>
                                
                               
                                <!--    ADD TO WISH LIST SCRIPT   -->    
                                <script type="text/javascript">                                                                                
                                    function add_to_wishlist(id){
                                        var ad_id = id;
                                        $.post('index.php', {ad_id: ad_id, status:"wishlist"});
                                    }
                                </script>
                            </div>

                <?php
                }
                $i ++;
            }
        }
    }
}




/*//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
                WISHLIST
////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////*/
function view_wishlist(){
    global $connection;
    $query = "SELECT * FROM `wishlist` WHERE `session_user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ";
    
    if ($query_run = mysqli_query($connection, $query)) {
        $query_num_rows = mysqli_num_rows($query_run);

        if($query_num_rows === 0){
            ?>
            <h2 id="no_result_head">No results</h2>
            <p id="no_reseult_news">
                Find posts you are interested in here by clicking "heart" on each of them.
            </p>
            <?php
        } 
                
        else if ($query_num_rows>0) {
            ?>
            <html>
                <span class="offering_heading" id="offering_heading">
                    <?php  echo '<h2 id="results_heading">Wish list</h2>'; ?>
                </span>
            </html>
            <?php
            
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
                                        $name= $rows['name'];
                                        $phoneNumber = $rows['phoneNumber'];
                                        $email = $rows['email'];
                                        $gender = $rows['gender'];
                                    }                        
                                }                    
                    }
                        }
                    }
                            
                    //Check FOR USER PROFILE NAME                            
                    $images = glob("../images/users/".$id."*.{jpeg,jpg,png}", GLOB_BRACE);
                    foreach($images as $image)
                        $user_profile_picture_name = basename($image);                                
                    
                    ?>
                    <div class="all_results" id="all_results">                                
                    <div id="container">
                        <div id="lefty">
                                    
                            <?php echo '<a href="
							viewmyprofile.php/'.getusername($ad_user_id).'">
                                        <img id="profile_image_of_ad_user" src="../images/users/'.$user_profile_picture_name.'" />
                            </a>' ?>
                                            
                            <img id="rating" src="../images/icons/posts/rating.png" />
                        </div>
                                    
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
                            <br>
                            <button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="send_message(<?php echo $ad_id; ?>)">
                                Send Message
                            </button>
                                    
                            <!--    ADD TO WISH LIST    -->
                            <button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
                                <img class="heart" id="<?php echo $ad_id; ?>heart1" src="../images/icons/posts/heart.png" />
                                <img class="addedwishlist" id="<?php echo $ad_id; ?>heart2" src="../images/icons/posts/added_to_wishlist.png" />
                            </button>
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
?>