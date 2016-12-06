<?php
require '../connect.inc.php';
require '../core.inc.php';
require '../View/view.php';
global $connection;

// Checking if the logged in User and the
//Logged in User
if( isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
//User that owns the ad
$ad_user_id = get_ad_user_id();
//  FUNCTION
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
                $firstName = $rows['firstName'];
                $surname = $rows['surname'];
                $phoneNumber = $rows['phoneNumber'];
                $occupation = $rows['occupation'];
                $email = $rows['email'];
                $gender = $rows['gender'];
                $description = $rows['description'];
            
                //number of RECCOMMENDATIONS
                $query2 = "SELECT * FROM `friends` WHERE `friend_two`='".mysqli_real_escape_string($connection, $USERID)."' ";
                if ($query_run2 = mysqli_query($connection, $query2)) {
                    $query_num_rows2 = mysqli_num_rows($query_run2);
                    //If Session user is reccommended           
                    if($query_num_rows2 !== 0){
                        $i = 0;
                        
                        while ($rows = mysqli_fetch_array($query_run2)) {
                            //assigning a variable to each friend
                            $friend_one = $rows['friend_one'];
                            //creating an array
                            $user_friends = array();
                            //Inserting values in aay
                            $user_friends[$i] = $friend_one;
                            $i ++;
                        }
                        $reccomendations = $i; //Counter of entries inserted
                    }
                    else{
                        $reccomendations = 0;
                    }
                }
                
                ?>
                <div id="account">
                <div class="container-fluid">
                        
                    <div id="account_details">
                        <h2 id="profile_name">
                            <?php echo $firstName.' '.$surname; ?>
                        </h2>
                        
                        <p id="account_personal_details">
                            <?php echo $phoneNumber.' '.$email.' <strong>'.$gender.'</strong>'; ?>
                        </p>
                        
                        <div id="occupation">
                            <?php echo '<strong>Occupation: </strong>'.$occupation; ?>
                        </div>
                        
                        <div id="profile_add_information">
                            
                            <img id="account_rating" src="../../images/icons/account/rating.svg" />
                            
                            <div id="recommendations">
                                <?php echo '<p id="recommendation_head">
                                                Recommendations
                                            </p>
                                            <p id="recommendation_number">            <strong>'.$reccomendations.'</strong>
                                            </p>'; 
                                ?>
                            </div>
                        </div>
                           
                        
                    </div>
                    
                    <div id="account_status">
                        <?php
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $USERID){
                            $query = "SELECT * FROM `friends` WHERE `friend_one`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' AND `friend_two`='".mysqli_real_escape_string($connection, $USERID)."'";
                            $query_run = mysqli_query($connection, $query);
                            
                            //  FOLLOW Button
                            if(mysqli_num_rows($query_run)!==1){ 
                                ?>
                                <div id="first_follow">
                                    <input class="js_values" id="user_id" name="user_id" value='<?php echo $_SESSION['user_id']; ?>'>
                                    <input class="js_values" id="ad_user_id" name="ad_user_id" value='<?php echo $USERID; ?>'>
                                    <input class="" id="e_follow" name="follow" type="button" value=' Recommend <?php echousername($USERID); ?>?' />
                                    <span id="follow_text"></span>
                                </div>
            
                                <div id="second_unfollow">
                                    <input class="js_values" id="user_id" name="user_id" value='<?php echo  $_SESSION['user_id']; ?>'>
                                    <input class="js_values" id="ad_user_id" name="ad_user_id" value='<?php echo $USERID; ?>'>
                                    <input class="js_values" id="ad_user_id_name" name="user_id_name" value='<?php echo getusername($USERID) ?>'>
                                    <input class="" id="e_unfollow" name="unfollow" type="button" value=' You recommend <?php echousername($USERID); ?>' />
                                    <span id="unfollow_text"></span>
                                </div>
            
                                <script type="text/javascript" src="../../js/follow.js"></script>
                                <?php
                            }
                                
                            //  UN-Follow Button
                            else {
                                ?>
                                <div id="first_unfollow">
                                    <input class="js_values" id="user_id" name="user_id" value='<?php echo  $_SESSION['user_id']; ?>'>
                                    <input class="js_values" id="ad_user_id" name="ad_user_id" value='<?php echo $USERID; ?>'>
                                    <input class="js_values" id="ad_user_id_name" name="user_id_name" value='<?php echo getusername($USERID) ?>'>
                                    <input class="" id="u_unfollow" name="unfollow" type="button" value='You recommend <?php echousername($USERID); ?>' />
                                    <span id="unfollow_text"></span>
                                </div>
            
                                <div id="second_follow">
                                    <input class="js_values" id="user_id" name="user_id" value='<?php echo  $_SESSION['user_id']; ?>'>
                                    <input class="js_values" id="ad_user_id" name="ad_user_id" value='<?php echo $USERID; ?>'>
                                    <input class="" id="u_follow" name="follow" type="button" value='Recommend <?php echousername($USERID); ?>?' />
                                    <span id="follow_text"></span>
                                </div>
                                
                                <script type="text/javascript" src="../../js/follow.js"></script>
                                    <?php
                            }  
                        }
                            ?>
                    </div>
                    
                    <p id="account_description">
                        <?php echo $description; ?>
                    </p>
                    
                        <?php
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $USERID){
                            
                            echo '<a href="../../edit/edit_my_profile.php/'.getusername($USERID).'.'.getusersurname($USERID).'"><button class="" id="edit" type="button" >Edit Profile</button></a>'; 
                        }
                        ?>
                </div>
            </div>
                <?php
            }
        } 
    }
}
?>

<!DOCTYPE>
<html>
    <title>Namela</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='../../index.css' rel='stylesheet' type="text/css">
        <link href='../../signin.css' rel='stylesheet' type="text/css">
        <link href='../viewmyprofile.css' rel='stylesheet' type="text/css">
        <link rel="stylesheet" href="../../API/335bootstrap.css">
        <script src="../../API/335bootstrap.js"></script>
        <script src="../../API/1.7jquery.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
    </head>
        
    <body id="dabody">
        
        <!--            Navigation bar          -->
        <ul class="nav_head" id="nav_head">
                
            <!--    Logo    -->
            <li class="nav_items" id="index_logo">
                <?php echo '<a href="../../index.php">' ?>
                    <img class="logo" id="logo" src="../../images/namela.png" />
                <?php echo'</a>' ?>
            </li>
                
            <!--    Posts    -->
            <li class="nav_items" id="index_all_posts">
                <span id="all_posts">Posts</span>
            </li>
                
            <!--Upload-->
            <li class="nav_items left_logout" id="upload">
                <?php echo '<a href="../../Place_Ad/ad.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">' ?>
                    <input class="post_ad" id="post_ad" type="button" value="Post?" />
                <?php echo '</a>'?>
            </li>
                
            <!--Profile-->
            <li class="nav_items left_logout" id="profile">
                <?php
                //Check FOR USER PROFILE NAME                            
                $images = glob("../images/users/".$user_id."*.{jpeg,jpg,png}", GLOB_BRACE);
                foreach($images as $image){
                    $user_profile_picture_name = basename($image);
                }
                if(!isset($user_profile_background_name)){
                    $user_profile_background_name = "defaults.svg";
                }
                echo '<img id="nav_image" src="../../images/users/'.$user_profile_picture_name.'"/>';
                ?>
                <img id="more" src="../../images/icons/arrows.png" />
            </li>
        </ul>
        <!--Mobile Navigation bar-->
        <div class="mobile_nav_head" id="nav_head">
            <div class="container-fluid">
                <img id="profile_menu" src="../../images/icons/mobile_navigation/profile_menu.svg">
                <img id="close_menu1" src="../../images/icons/mobile_navigation/close_menu.svg">
                    
                <a href="../../index.php">
                    <img id="mobile_logo" src="../../images/icons/mobile_navigation/logo.svg" />
                </a>
                        
                <img id="search_menu" src="../../images/icons/mobile_navigation/search_menu.svg">
                <img id="close_menu2" src="../../images/icons/mobile_navigation/close_menu.svg">
            </div>
        </div>                
        <!--Profile Menu-->
        <div id="profile_menu_button">
            <div class="container-fluid">
                        
                <div id="user_account_header">
                    <?php 
                    if (loggedin()) {
                        echo '<a href="../../view_my_profile/viewmyprofile.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">
                            <img id="profile_picture" src="../../images/users/'.$user_profile_picture_name.'"/>';
                            ?>
                            <span id="session_username"><?php echo getuserfield('firstName');?></span>
                            <?php
                        echo '</a>';
                    }
                    else{
                        ?>
                        <span id="session_username">
                            <a id="session_username" href="../../LogIn/signin.php">
                                Log in
                            </a>
                        </span>
                        <?php
                    }
                    ?>
                </div>  
                        
                <ul id="profile_menu_ul">
                    <?php 
                    if (loggedin()) {
                        ?>
                        <li id="profile_menu_li">
                            <?php echo '<a href="../../Place_Ad/ad.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">' ?>
                                <img id="profile_menu_li_img" src="../../images/icons/profile_menu/add_post.svg"/>                                
                                <span id="profile_menu_li_head">Add Post</span>
                            <?php echo '</a>'?>
                        </li>
                        <?php
                    }
                    ?> 
                        
                    <li id="profile_menu_li">
                        <img id="profile_menu_li_img" src="../../images/icons/profile_menu/friends.svg"/>
                        <span id="profile_menu_li_head">Invite Friends</span>
                    </li>
                            
                    <li id="profile_menu_li">
                        <img id="profile_menu_li_img" src="../../images/icons/profile_menu/inbox.svg"/>
                        <span id="profile_menu_li_head">Inbox</span>
                    </li>
                            
                    <li id="profile_menu_li">
                        <?php echo '<a href="../../wish_list/wish_list.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">' ?>
                            <img id="profile_menu_li_img" src="../../images/icons/profile_menu/wishlist.svg"/>
                            <span id="profile_menu_li_head">Wish List</span>
                        <?php echo '</a>'?>
                    </li>
                                
                    <li id="profile_menu_li">
                        <img id="profile_menu_li_img" src="../../images/icons/profile_menu/profile.svg"/>
                        <span id="profile_menu_li_head">My Account</span>
                    </li>
                            
                    <li id="profile_menu_li">
                        <img id="profile_menu_li_img" src="../../images/icons/profile_menu/settings.svg"/>
                        <span id="profile_menu_li_head">Settings</span>
                    </li>
                </ul>
                    
                <?php 
                if (loggedin()) {                        
                    ?>
                    <div id="logout_div">
                        <a href="../../LogOut/signout.php">
                            <span id="logout_span">Logout</span>
                        </a>
                    </div>
                    <?php
                }
                ?>  
                        
            </div>
        </div>
        <!-- Search Menu-->
        <div id="search_menu_button">
            <div class="container-fluid" id="search_menu_container">
                        
                <h4 id="search_menu_header">Search</h4>
                        
                <form id="mobile_search_menu_form" name="mobile_search_menu_form" action="" method="POST">
                                                        
                    <!-- Departure Field -->
                    <input id="search_menu_departure" name="departure" type="text" placeholder=" Departure" required />                            
                            
                    <!-- Destination Field -->
                    <input id="search_menu_destination" name="destination" type="text" placeholder=" Destination" />
                                                    
                    <br>                                            
                    <input id="search_menu_offering_transport" type="radio" name="type" value="o" checked>
                        <span id="span_search_menu_offering_looking">ransport</span>
                    </input>
                        
                    <br>
                    <input id="search_menu_offering_transport" type="radio" name="type" value="w" >
                        <span id="span_search_menu_offering_looking"> Commuters/Passgeners</span>
                    </input>
                            
                    <p id="validate-status">Please fill in ALL fields</p>
                            
                    <!-- Form submit button -->
                    <button id="search_menu_search" name="search_menu_search" type="submit">Sign In</button>
                </form>
                        
            </div>
        </div>
          
        
        
        <!--            Section bar         -->    
        <section id="profile_contents">
            
            <!--//////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////
            USER Profile
            //////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////-->    
            <div class="" id="user_profile">
                
                <?php
                /*//////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////
                BACKGROUND Picture
                //////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////*/
                $images = glob("../images/users/user_background/".$ad_user_id."*.{jpeg,jpg,png}", GLOB_BRACE);
                foreach($images as $image){
                    $user_profile_background_name = basename($image);
                }
                if(!isset($user_profile_background_name)){
                    $user_profile_background_name = "defaults.svg";
                }
                ?>
                <img id="profile_background" src="../../images/users/user_background/<?php echo $user_profile_background_name; ?>">
                <?php
                
                
                /*
                //////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////
                Profile Picture
                //////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////
                */
                $images = glob("../images/users/".$ad_user_id."*.{jpeg,jpg,png}", GLOB_BRACE);
                foreach($images as $image){
                    $user_profile_picture_name = basename($image);
                }
                if(!isset($user_profile_background_name)){
                    $user_profile_background_name = "defaults.svg";
                }
                ?>                            
                <img id="profile_image" src="../../images/users/<?php echo $user_profile_picture_name; ?>" />
                <?php
                
                
                /*////////////////////////////Session User Profile///////////////////////////////////////////*/
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $ad_user_id){
                    ?>
                    <!--background Picture UPLOAD Form-->
                    <form id="background_form" method="post" enctype="multipart/form-data" action="../../upload/upload_background.php">
                        <input class="" id="file" name="file" type="file" />
                        <input  id="ad_user_id" name="ad_user_id" type="hidden" value='<?php echo $ad_user_id; ?>'>
                        <input class="" id="file_submit" name="file_submit" type="submit" value="Upload Background Picture" />                  
                    </form>
                    
                    <!--PROFILE Picture UPLOAD Form-->
                    <form id="form" method="post" enctype="multipart/form-data" action="../../upload/upload_image.php">
                        <input class="" id="file" name="file" type="file" />
                        <input  id="ad_user_id" name="ad_user_id" type="hidden" value='<?php echo $ad_user_id; ?>'>
                        <input class="" id="file_submit" name="file_submit" type="submit" value="Upload Profile Picture" />                  
                    </form>                            
                    <?php
                    
                    //PROFILE DETAILS
                    $profile = view_my_profile($_SESSION['user_id']);
                }
                
                /*////////////////////////////Other User Profile/////////////////////////////////////////////*/
                else{
                    $profile = view_my_profile($ad_user_id);
                }
                ?>
            </div>
            
            <!--    Review  |   Once-Off    |   Recurring   -->
            <div id="review_posts">
                <h1 id="reviews">
                    <img id="review_img" src="../../images/icons/account/reviews.svg" />
                    <span id="reviews_span">Reviews</span>
                </h1>
                <h1 id="posts">
                    <img id="posts_img" src="../../images/icons/account/posts.svg" />
                    <span id="posts_span">Once-Off</span>
                </h1>
                <h1 id="recurring_posts">
                    <img id="recurring_posts_img" src="../../images/icons/account/recurring.svg" />
                    <span id="recurring_span">Recurring</span>
                </h1>
            </div>
            
            <!--    Print Search Results    -->
            <?php
            $output = '';
            if(isset($_POST['departure'])&&isset($_POST['destination'])&&isset($_POST['type'])){
                    $departure = htmlentities($_POST['departure']);
                    $destination = htmlentities($_POST['destination']);
                    $transport = htmlentities($_POST['type']);
    
                    if(!empty($departure)&&!empty($destination)) {
                        
                        if($transport==='o'){     
                            ?>
                            <html>
                                <?php  echo '<h2 class="search_results_heading" id="results_heading">Offered transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>"</h2>'; ?>
                            </html>
                            <?php
                        }
                        
                        else {
                            ?>
                            <html>
                                <span class="offering_heading" id="offering_heading">
                                    <?php     echo '<h2 class="search_results_heading" id="results_heading">Commuters looking for transport from "<strong>'.$departure.'</strong>" to "<strong>'.$destination.'</strong>"</h2>'; ?>
                                </span>
                            </html>
                            <?php
                        }
                        
                        //query database
                        $query1 = "SELECT * FROM `adverts` WHERE `departure` LIKE '%".mysqli_real_escape_string($connection, $connection, $departure)."%' AND `destination` LIKE '%".mysqli_real_escape_string($connection, $destination)."%' AND `type`='".mysqli_real_escape_string($connection, $transport)."'"; 
                        //Running the Query
                        
                        if ($query_run = mysqli_query($connection, $query1)) {
                                $query_num_rows = mysqli_num_rows($query_run);   
                                // User input (departure & destination) is NOT found in the `offered` database
                                if($query_num_rows==0){
                                    echo '<h2 id="results_heading">No result(s)</h2>';
                                }          
                                //User input (departure & destination) Are found in the `offered` database
                                //There might be more more than ONE result.
                                else if ($query_num_rows>0) {   
                                    //Search and echo all database results
                                    $i = 1;   
                                    while ($rows = mysqli_fetch_array($query_run)) {
                                        $description = $rows['description'];
                                        $departure = $rows ['departure'];
                                        $destination = $rows ['destination'];
                                        $date = $rows['date'];           
                                        $time = $rows['time'];      
                                        $amount = $rows['amount'];
                        
                                        $ad_user_id = $rows['user_id'];                 
                                        //Select the ad owners information
                                        $query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."'";  
                                        if ($query_run2 = mysqli_query($connection, $query2)) {
                                            $query_num_rows2 = mysqli_num_rows($query_run2);
                                            if($query_num_rows==1) {
                                                while ($rows = mysqli_fetch_array($query_run2)) {
                                                    $ad_user_firstName =  $rows['firstName'];
                                                    $ad_user_surname = $rows['surname'];
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
                                                    <?php 
                                                    echo '<a ../../view_my_profile/viewmyprofile.php/'.getusername($ad_user_id).'.'.getusersurname($ad_user_id).'">
                                                        <img id="profile_image_of_ad_user" src="../..images/users/'.$user_profile_picture_name.'" />
                                                    </a>' 
                                                    ?>                                            
                                    
                                                     <img id="rating" src="../../images/icons/posts/rating.svg" />
                                                 </div>
                                    
                                                 <div id="righty">                                    
                                                     
                                                     <div id="righty_departure_and_destination">
                                                         <img id="departure_destination_image" src="../../images/icons/posts/departure_destination.svg" />
                                        
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
                                                     <button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="request_to_book(<?php echo $ad_id; ?>)">
                                                         Request to book
                                                     </button>
                                    
                                                     <!--    ADD TO WISH LIST    -->
                                                     <button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
                                                         <img class="heart" id="<?php echo $ad_id; ?>heart1" src="../../images/icons/posts/heart.svg" />
                                                         <img class="addedwishlist" id="<?php echo $ad_id; ?>heart2" src="../../images/icons/posts/added_to_wishlist.svg" />
                                                     </button>
                                                     
                            
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
                                        </div>
                                        <?php
                                        $i ++;
                                    }
                                }
                            }
                    }
                    
                    
                    
                    else if(!empty($departure)) {
                        if($transport==='o'){     
                            ?>
                            <html>
                                <span class="offering_heading" id="offering_heading">
                                    <?php  echo '<h2 class="search_results_heading" id="results_heading">Offered transport from "<strong>'.$departure.'</strong>"</h2>'; ?>
                                </span>
                            </html>
                            <?php
                            
                             
                        }
                        
                        else {
                            ?>
                            <html>
                                <span class="offering_heading" id="offering_heading">
                                    <?php     echo '<h2 class="search_results_heading" id="results_heading">Commuters looking for transport from "<strong>'.$departure.'</strong>"</h2>'; ?>
                                </span>
                            </html>
                            <?php
                        }
                        
                        //query database     
                        $query1 = "SELECT * FROM `adverts` WHERE `departure` LIKE '%".mysqli_real_escape_string($connection, $departure)."%' AND `type`='".mysqli_real_escape_string($connection, $transport)."'"; 
                        if ($query_run = mysqli_query($connection, $query1)) {
                                $query_num_rows = mysqli_num_rows($query_run);   
                                // User input (departure & destination) is NOT found in the `offered` database
                                if($query_num_rows==0){
                                    echo '<h2 id="results_heading">No result(s)</h2>';
                                }          
                                //User input (departure & destination) Are found in the `offered` database
                                //There might be more more than ONE result.
                                else if ($query_num_rows>0) {   
                                    //Search and echo all database results
                                    $i = 1;   
                                    while ($rows = mysqli_fetch_array($query_run)) {
                                        $description = $rows['description'];
                                        $departure = $rows ['departure'];
                                        $destination = $rows ['destination'];
                                        $date = $rows['date'];           
                                        $time = $rows['time'];      
                                        $amount = $rows['amount'];
                        
                                        $ad_user_id = $rows['user_id'];                 
                                        //Select the ad owners information
                                        $query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $ad_user_id)."'";  
                                        if ($query_run2 = mysqli_query($connection, $query2)) {
                                            $query_num_rows2 = mysqli_num_rows($query_run2);
                                            if($query_num_rows==1) {
                                                while ($rows = mysqli_fetch_array($query_run2)) {
                                                    $ad_user_firstName =  $rows['firstName'];
                                                    $ad_user_surname = $rows['surname'];
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
                                                    <?php 
                                                    echo '<a href="../../view_my_profile/viewmyprofile.php/'.getusername($ad_user_id).'.'.getusersurname($ad_user_id).'">
                                                        <img id="profile_image_of_ad_user" src="../../images/users/'.$user_profile_picture_name.'" />
                                                    </a>' 
                                                    ?>                                            
                                    
                                                     <img id="rating" src="../../images/icons/posts/rating.svg" />
                                                 </div>
                                    
                                                 <div id="righty">                                    
                                                     
                                                     <div id="righty_departure_and_destination">
                                                         <img id="departure_destination_image" src="../../images/icons/posts/departure_destination.svg" />
                                        
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
                                                     <button type="button" id="<?php echo $ad_id; ?>" class="request_to_book" onclick="request_to_book(<?php echo $ad_id; ?>)">
                                                         Request to book
                                                     </button>
                                    
                                                     <!--    ADD TO WISH LIST    -->
                                                     <button type="button" id="<?php echo $ad_id; ?>" class="add_to_wishlist" onclick="add_to_wishlist(<?php echo $ad_id; ?>)">
                                                         <img class="heart" id="<?php echo $ad_id; ?>heart1" src="../../images/icons/posts/heart.svg" />
                                                         <img class="addedwishlist" id="<?php echo $ad_id; ?>heart2" src="../../images/icons/posts/added_to_wishlist.svg" />
                                                     </button>
                                                     
                            
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
            
            
            <div id="content_container">
            
                <!--    ALL     |       Commuters     |       Transport  -->
                <div class="ad_types" id="ad_types">
                    <div id="index_all_ads">
                        All
                    </div>
                    <div id="index_wanted_ads">
                        Commuting
                    <img id="people" src="../../images/People.png" />
                    </div>
                    <div id="index_offered_ads">
                        Driving
                        <img id="car" src="../../images/Car.png" />
                    </div>
                </div>
                
                <?php
                //If the logged-in user is the ad owner
                if (isset($_SESSION['user_id']) && $user_id===$ad_user_id){
                    ?>
                    <!--View All Ads-->
                    <div class="view_all_ads" id="view_all_ads">
                        <?php   view_my_ads($user_id); ?>
                    </div>
                
                    <!--View All Wanted Ads-->
                    <div class="view_all_wanted_ads" id="view_all_wanted_ads">
                        <?php view_my_wanted_ads($user_id); ?>
                    </div>
                
                    <!--View All My Offered Ads-->
                    <div class="view_all_offered_ads" id="view_all_offered_ads">
                        <?php view_my_offered_ads($user_id); ?>
                    </div>
                    <?php
                }
                else{
                    ?>                
                    <!--View All Ads-->
                    <div class="view_all_ads" id="view_all_ads">
                        <?php $my_ads = view_my_ads($ad_user_id); ?>
                    </div>
                
                    <!--View All Wanted Ads-->
                    <div class="view_all_wanted_ads" id="view_all_wanted_ads">
                        <?php $my_wanted_ads = view_my_wanted_ads($ad_user_id); ?>
                    </div>
                
                    <!--View All My Offered Ads-->
                    <div class="view_all_offered_ads" id="view_all_offered_ads">
                        <?php $my_offered_ads = view_my_offered_ads($ad_user_id); ?>
                    </div>
                    <?php
                }
                ?>
            
                <!--    REVIEWS -->
                <div id="reviews">
                    <h2 id="no-reviews">No reviews</h2>
                    <p id="reviews-statement">Reviews from other users that have travelled with <?php getusername($ad_user_id); ?> are placed displayed here.</p>
                </div>
                
                <!--    Recurring   Posts-->
                <div id="reccuring_ad_types">
                    <div id="reccuring_commuting">
                        Commuting
                    <img id="recurring_people" src="../../images/People.png" />
                    </div>
                    <div id="reccuring_driving">
                        Driving
                        <img id="recurring_car" src="../../images/Car.png" />
                    </div>
                </div>
                
                <div id="recurring-posts">
                    <?php
                    //If the logged-in user is the ad owner
                    if (isset($_SESSION['user_id']) && $user_id===$ad_user_id){
                        ?>
                        <div id="view_commuting_recurring_ads">
                            <?php  view_commuting_recurring_ads($user_id); ?>
                        </div>
                        <div id="view_driving_recurring_ads">
                            <?php  view_driving_recurring_ads($user_id); ?>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <div class="view_commuting_recurring_ads" id="view_all_ads">
                            <?php view_commuting_recurring_ads($ad_user_id); ?>
                        </div>
                        <div id="view_driving_recurring_ads">
                            <?php  view_driving_recurring_ads($ad_user_id); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                
                
            </div>
            
        </section>
            
        
        <!--            ASIDE bar         -- > 
        <aside class="friend_box" id="friend_box">
            <div class="container-fluid">
                
                <!--Show Sign-In Form if NOT signed in-- >
                < ?php 
                if (!loggedin()) {
                    if (isset($_POST['email']) && isset($_POST['password'])) {
                        $password = htmlentities($_POST['password']);   
                        $email = htmlentities($_POST['email']);
    
                        $password = md5($password);
    
                        $query = "SELECT `id` FROM `users` WHERE `email`='".mysqli_real_escape_string($connection, $email)."' AND `password`='".mysqli_real_escape_string($connection, $password)."'";
        
                        if ($query_run = mysqli_query($connection, $query)) {
                            $query_num_rows = mysqli_num_rows($query_run);
            
                            if($query_num_rows==0) {
                                header ('Location: ../../login/signin.php');
                            }
                            
                            else if ($query_num_rows==1) {
                                $user_id = mysql_result($query_run, 0, 'id');
                                $_SESSION['user_id'] = $user_id;
                                ?>
                                <script type="text/javascript">
                                    document.getElementById('submit').disabled = false;
                    
                                    document.getElementById("validate-status").style.display = "none";
                                    document.getElementById('submit').disabled = false;
                                    document.getElementById('submit').style.color = "white";
                                    document.getElementById('submit').style.backgroundColor = "green";
                                    document.getElementById('submit').style.border = "2px solid green";
                    
                                    window.location.reload();
                                </script>
                                < ?php

                            }   
                        }
                        else {
                            header ('Location: ../../login/signin.php');
                        }
                    }    
                    
                    else {
                        ?>                    
                        <h2 id="index_h2_sign_in">Sign In</h2>                    
                    
                        <!-- Sign in Form -- >
                        <form class="" id="signin_form" name="signin_form" action="" method="POST">
                        
                            <!-- Email Field -- >
                            <input class="" id="email" name="email" type="email" placeholder=" Email Address" value="< ?php if (isset($email)) { echo $email; }?>" maxlength="40" onkeyup="fillinginfields()" required />
                            
                            
                            <!-- Password Field -- >
                            <input class="" id="password" name="password" type="password" placeholder=" Password" onkeyup="fillinginfields()" required />
                            <span>
                                <input class="" id="remember_me" name="remember_me" type="checkbox" /> Remember me
                            </span>
                            
                            <p id="validate-status">Please fill in ALL fields</p>
                            
                            <!-- Form submit button -- > 
                            <button class="button" id="submit" name="submit" type="submit">Sign In</button>
                        </form>
                
                        <!--    REGISTER    -- >
                        <a href="../../register/register.php">
                            <button id="register" name="register" type="submit">Register</button>
                        </a>
                        < ?php          
                    }
                }
                ?>
            
                
            
                <!--    Serch for TRAVEL PLAN   -- >
                <h2 class="search_title" id="search_title">Search</h2>                    
                <form class="search_form" id="search_form" method="POST">
                    <!-- Departure Input-- >
                    <input class="departure_input search_input" id="departure_input" type="text" name="departure" value="< ?php if(isset($departure)){ echo $departure;}?>" placeholder="Departure" size="15" required />
        
                    <!--Desination Input-- >
                    <input class="destination_input search_input" id="destination_input" type="text" name="destination" value="< ?php if(isset($destination)){ echo $destination;}?>" placeholder="Destination" size="15" />
                    
                    <br>
                    <input type="radio" name="type" value="o" checked> Offering Transport
                    <br>
                    <input type="radio" name="type" value="w" > Looking for Transport
        
                    <!--Search Button-- >
                    <button class="" id="search" type="search" name="search" value="Search"> Search</button>    
                </form>
                
            
            
                <!--    Mutual Friends  -- >
                < ?php
                if(isset($_SESSION['user_id'])){
                    if ($user_id!==$ad_user_id){
                        //Logged in User
                        $user_id = $_SESSION['user_id'];
                        //User that owns the ad
                        $ad_user_id = get_ad_user_id();
                        //Queary that select Session user($user_id)'s friends
                        $query = "SELECT * FROM `friends` WHERE `friend_one`='".mysqli_real_escape_string($connection, $user_id)."'";
                    
                        if($query_run = mysqli_query($connection, $query)) {
                            $query_num_rows = mysqli_num_rows($query_run);
                            //If Session user does not have any friends
                        
                            if($query_num_rows !== 0){
                                $i = 0;
                                while ($rows = mysqli_fetch_array($query_run)) {
                                    //assigning a variable to each friend
                                    $friend_two = $rows['friend_two'];
                                    //creating an array
                                    $user_friends = array();
                                    //Inserting values in aay
                                    $user_friends[$i] = $friend_two;
                                    $i ++;
                                }
                            
                                //Queary that select the Profile users($ad_user_id)'s friends
                                $query2 = "SELECT * FROM `friends` WHERE `friend_one`='".mysqli_real_escape_string($connection, $ad_user_id)."'";
                                if($query_run2 = mysqli_query($connection, $query2)) {
                                    $query_num_rows2 = mysqli_num_rows($query_run2);
                                    
                                    //If Session user does not have any friends
                                    if($query_num_rows2 !== 0){
                                        $i = 0;
                                        while ($rows2 = mysqli_fetch_array($query_run2)) {
                                            //assigning a variable to each friend
                                            $friend_two = $rows2['friend_two'];
                                            //creating an array 
                                            $ad_user_friends = array();
                                            //Inserting values in aay
                                            $ad_user_friends[$i] = $friend_two;                                
                                            $i ++;
                                        }
                                    
                                        //Intersection of both arrays
                                        $intersection = array_intersect($user_friends,$ad_user_friends);
                                        $result = array_values($intersection);
                                    
                                        echo '<h4><strong>You have '.sizeof($result).' mutual recommendations</strong></h4>';
                                        ?>
                                    
                                        <div id="mutual">
                                            < ?php
                                            for ($count = 0; $count < sizeof($result); $count++){
                                                $value = $result[$count];
                                                $query3 = "SELECT * FROM `users` where `id`='".mysqli_real_escape_string($connection, $value)."'";
                                            
                                                if($query_run3 = mysqli_query($connection, $query3)){
                                                    $query_num_rows3 = mysqli_num_rows($query_run3);
                                                
                                                    if ($query_num_rows3===1) {
                                                        $id = mysql_result($query_run3, 0, 'id');
                                                        $firstName = mysql_result($query_run3, 0, 'firstName');
                                                        $surname = mysql_result($query_run3, 0, 'surname');
                                                    }
                                                }
                                                $output = '<a href=" ../../view_my_profile/viewmyprofile.php?user_id='.$user_id.'&ad_user_id='.$id.'">'.$firstName.' '.$surname.'</a><br>';
                                                $i = $count+1;
                                                echo "<strong>".$i.".</strong> ".$output;
                                            }
                                            ?>
                                        </div>
                                        < ?php   
                                    }
                                
                                    else{
                                        echo'<h4><strong>No mutual friends</strong></h4>'; 
                                    }                        
                                }
                            }
                            else{
                                echo'<h4><strong>No mutual friends</strong></h4>'; 
                            }
                            
                        }
                    
                        else{
                            echo'<h4><strong>No mutual friends</strong></h4>'; 
                        }
                    }
                }
                ?>
            
            
                
                <!--    Seach for friends   -- >                                    
                <h4 id="search_friends_label" for="Search">Search for Friends </h4>
                <!--Seach Form-- >
                <form method="POST">                        
                    <!-- Departure Input-- >
                    <input class="" id="name" type="text" name="name" size="15" required placeholder="  Friends name" />
                    
                    <!--Search Button-- >
                    <input class="" id="look" type="submit" name="look" value="Look for friends" />
                </form>
                
                
                
                <!-- Print User Search Results-- >
                < ?php
                $output = '';
                if( isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                }
                if(isset($_POST['name'])){
                    $name = htmlentities($_POST['name']);
        
                    if(!empty($name)) {
                        echo '<h3>User Results(s) <br> \'<strong>'.$name.'</strong>\'</h3>';

                        //Select the ad owners information
                        $query = "SELECT * FROM `users` WHERE CONCAT(firstName, ' ', surname) LIKE '".mysqli_real_escape_string($connection, $name)."' OR `surname` LIKE '".mysqli_real_escape_string($connection, $name)."' OR `firstName` LIKE '".mysqli_real_escape_string($connection, $name)."'";
                    
                        //Running the Query
                        if ($query_run = mysqli_query($connection, $query)) { 
                            $query_num_rows = mysqli_num_rows($query_run);
                    
                            // User input (departure & destination) is NOT found in the `offered` database
                            if($query_num_rows==0){
                                echo '<h3>No results for the search: \''.$name.'\'</h3>';
                            } 
                            //There might be more more than ONE result.
                            else if ($query_num_rows>0) {
                                //Search and echo all database results
                                $i = 1;
                                while ($rows = mysqli_fetch_array($query_run)) {
                                    $found_user_id = $rows['id'];
                                    $found_user_firstName = $rows['firstName'];
                                    $found_user_surname = $rows['surname'];
                                    $found_user_phoneNumber = $rows['phoneNumber'];
                                    $found_user_email = $rows['email'];
                                    $found_user_gender = $rows['gender'];
                        
                                    $output = '<br><strong>'.$i.'.</strong><a href="../../view_my_profile/viewmyprofile.php?user_id='.$user_id.'&ad_user_id='.$found_user_id.'"> '.$found_user_firstName.' '.$found_user_surname.'</a> '.$found_user_gender.'<p></p>'.$found_user_phoneNumber.' '.$found_user_email.'<br>';
                                    echo $output;
                                    $i ++;
                                }
                            }
                        }
                }
                else{
                    echo 'All fields are required.';
                }
            }
                ?>
                
            </div>
        </aside>-->
        
        
        
        <!--            FOOTER          -->
        <footer>
            <div class="container-fluid">
                    
                <ul id="footer_info">
                    <li class="footer_items" id="about_us">
                        <a id="footer_links" href="../../about_us/about_us.php#company_info?">About Us</a>
                    </li>
                    <li class="footer_items" id="privacy">
                        <a id="footer_links" href="../../about_us/about_us.php#terms_info">Privacy & Terms</a>
                    </li>
                    <li class="footer_items" id="Careers">
                        <a id="footer_links" href="../../about_us/about_us.php#careers_info">Careers</a>
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
        
        
        <script src="../../js/universal.js"></script>
        <script src="../../js/viewmyprofile.js"></script>
        <script type="text/javascript" src="../../js/mobile_menu.js"></script>
        <script type="text/javascript" src="../../js/profilepicture.js"></script>
    </body>
</html>