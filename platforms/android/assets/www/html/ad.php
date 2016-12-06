<?php
require '../connect.inc.php';
require '../core.inc.php';
global $connection;

$user_id = $_SESSION['user_id'];

/*Check that each field exists and is submitted*/ 
if (isset($_POST['description'])&&
    isset($_POST['departure'])&&
    isset($_POST['destination'])&&
    isset($_POST['time1'])&&
    isset($_POST['am_pm1'])&&
    isset($_POST['time2'])&&
    isset($_POST['am_pm2'])&&
    isset($_POST['amount'])&&
    isset($_POST['type'])) {
     
    /*Setting variables*/
    $description = htmlentities($_POST['description']);
    $departure = htmlentities($_POST['departure']);
    $destination = htmlentities($_POST['destination']);
    
    if(isset($_POST['days']) && is_array($_POST['days'])){
        $date = implode(',', $_POST['days']);
    }
    else if(isset($_POST['date'])){
        $date = htmlentities($_POST['date']);
    }
    
    $time1 = htmlentities($_POST['time1']);
    $am_pm1 = htmlentities($_POST['am_pm1']);
    
    $time2 = htmlentities($_POST['time1']);
    $am_pm2 = htmlentities($_POST['am_pm2']);
    
    $time = "Between $time1 $am_pm1 and $time2 $am_pm2 ";
    
    $amount = htmlentities($_POST['amount']);
    $type = htmlentities($_POST['type']);
    
    //Make $user_id aceesible inthe function
    global $user_id;

    /*Start the registration process*/
  
    /*Registration*/
    /*Inserting User input into server data*/
    $query = "INSERT INTO `adverts` 
                    VALUES 
                    ('',
                    '".mysqli_real_escape_string($connection, $user_id)."',
                    '".mysqli_real_escape_string($connection, $description)."',
                    '".mysqli_real_escape_string($connection, $departure)."',
                    '".mysqli_real_escape_string($connection, $destination)."',
                    '".mysqli_real_escape_string($connection, $date)."',
                    '".mysqli_real_escape_string($connection, $time)."',
                    '".mysqli_real_escape_string($connection, $amount)."',
                    '".mysqli_real_escape_string($connection, $type)."'
                    )
                ";
        
    if(mysqli_query($connection, $query)) {
        header ('Location: ../../index.php');
        exit;
    } else{
        echo 'Sorry. We could not redister you at this time. Please Try again later';
    }        
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='../../index.css' rel='stylesheet' type="text/css">
        <link href='../post_ad.css' rel='stylesheet' type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        
        <!--            Navigation bar          -->
        <ul class="nav_head" id="nav_head">
                
            <!--    Logo    -->
            <li class="nav_items" id="index_logo">
                <?php echo '<a href="../../index.php">' ?>
                    <img class="logo" id="logo" src="../../images/namela.png" />
                <?php echo'</a>' ?>
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
                        <?php echo '<a href="../../messages/inbox.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">'?>
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
        
        
        
        <section id="post_ad_section">
            <div class="container-fluid" id="post_container">
                
                <h2 id="post_ad_heading">Post Travel plan</h2>
                <div id="one-time">Once-off Plan</div>
                <div id="recurring">Recurring</div>
                
                <!--Once-Off Form-->
                <form class="" id="post_form" name="post_form" action="" method="POST">
                    
                    <!--Departure Field-->
                    <input id="autocomplete" onFocus="geolocate()" name="departure" type="text" placeholder="  Enter your point of departure" maxlength="40" value="<?php if (isset($departure)) { echo $departure; }?>" onkeyup="fillinginfields()" required />
                    
                    <!--Destination Field-->
                    <input id="autocomplete2" onFocus="geolocate()" name="destination" type="text" placeholder="  Enter destination point" maxlength="40" value="<?php if (isset($destination)) { echo $destination; }?>" onkeyup="fillinginfields()" required />
                    
                    <!--Basic information Field-->
                    <textarea id="description_input" name="description" rows="5" cols="50" placeholder="  Please write any additional information regarding the travel plan" onkeyup="fillinginfields()"></textarea>
                        
                    <!--Type of ad-->
                    <ul id="type_list">
                        <li class="type_list_items">
                            <input id="radio_input" type="radio" name="type" value="o" checked>Offering Transport
                        </li>
                        <br>
                        <li class="type_list_items">
                            <input id="radio_input" type="radio" name="type" value="w">Looking for Transport
                        </li>
                    </ul>
                                                                                                                    
                    <!--Date of departure-->
                    <br>
                    <label id="date_label">Date: </label>                       
                    <input id="date_input" type="date" name="date" placeholder="Date of departure" required />
                    
                    <!--Time of departure-->
                    <br>
                    <br>
                    <label id="time_label">Time: </label>
                     Between
                    <select name="time1">
                        <option id="time1" name="time1" value="01:00">01:00</option>
                        <option id="time1" name="time1" value="02:00">02:00</option>
                        <option id="time1" name="time1" value="03:00">03:00</option>
                        <option id="time1" name="time1" value="04:00">04:00</option>
                        <option id="time1" name="time1" value="05:00">05:00</option>
                        <option id="time1" name="time1" value="06:00">06:00</option>
                        <option id="time1" name="time1" value="07:00">07:00</option>
                        <option id="time1" name="time1" value="08:00">08:00</option>
                        <option id="time1" name="time1" value="09:00">09:00</option>
                        <option id="time1" name="time1" value="10:00">10:00</option>
                        <option id="time1" name="time1" value="11:00">11:00</option>
                        <option id="time1" name="time1" value="12:00">12:00</option>                        
                    </select>
                    <select name="am_pm1">
                        <option id="am_pm1" name="am_pm1" value="AM">AM</option>
                        <option id="am_pm1" name="am_pm1" value="PM">PM</option>
                    </select>
                    <br>
                    <span> and </span>
                    <select name="time2">
                        <option id="time2" name="time2" value="01:00">01:00</option>
                        <option id="time2" name="time2" value="02:00">02:00</option>
                        <option id="time2" name="time2" value="03:00">03:00</option>
                        <option id="time2" name="time2" value="04:00">04:00</option>
                        <option id="time2" name="time2" value="05:00">05:00</option>
                        <option id="time2" name="time2" value="06:00">06:00</option>
                        <option id="time2" name="time2" value="07:00">07:00</option>
                        <option id="time2" name="time2" value="08:00">08:00</option>
                        <option id="time2" name="time2" value="09:00">09:00</option>
                        <option id="time2" name="time2" value="10:00">10:00</option>
                        <option id="time2" name="time2" value="11:00">11:00</option>
                        <option id="time2" name="time2" value="12:00">12:00</option>                        
                    </select>
                    <select name="am_pm2">
                        <option id="am_pm2" name="am_pm2" value="AM">AM</option>
                        <option id="am_pm2" name="am_pm2" value="PM">PM</option>
                    </select>
                        
                    <!--Amount-->
                    <input class="" id="amount_input" name="amount" type="text" placeholder=" Enter the amount " value="<?php if (isset($amount)) { echo $amount; }?>" onkeyup="fillinginfields()" required />
                    
                    
                    <div id="validate-status" >Please fill in ALL fields</div>
                    
                    <button class="" id="post_ad" name="post_ad" type="submit"0>Post Ad</button>
                </form>
                
                
                
                
                
                
                
                
                 <!--Recurring Form-->
                <form class="" id="recurring_form" name="post_form" action="" method="POST">
                    
                    <!--Departure Field-->
                    <input id="autocomplete" onFocus="geolocate()" name="departure" type="text" placeholder="  Enter your point of departure" maxlength="40" value="<?php if (isset($departure)) { echo $departure; }?>" onkeyup="fillinginfields()" required />
                    
                    <!--Destination Field-->
                    <input id="autocomplete2" onFocus="geolocate()" name="destination" type="text" placeholder="  Enter destination point" maxlength="40" value="<?php if (isset($destination)) { echo $destination; }?>" onkeyup="fillinginfields()" required />
                    
                    <!--Basic information Field-->
                    <textarea id="description_input" name="description" rows="5" cols="50" placeholder="  Please write any additional information regarding the travel plan" onkeyup="fillinginfields()"></textarea>
                        
                    <!--Type of ad-->
                    <ul id="type_list">
                        <li class="type_list_items">
                            <input id="radio_input" type="radio" name="type" value="o" checked>Offering Transport
                        </li>
                        <br>
                        <li class="type_list_items">
                            <input id="radio_input" type="radio" name="type" value="w">Looking for Transport
                        </li>
                    </ul>
                                                                                                                    
                    <!--Days of departure-->
                    <br>
                    <label id="days_label">Days: </label>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Sunday"> Sunday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Monday"> Monday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Tuesday"> Tuesday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Wednesday"> Wednesday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Thursday"> Thursday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Friday"> Friday</div>
                    <div id="days_input"><input type="checkbox" name="days[]" value="Saturday"> Saturday</div>
                    
                    <!--Time of departure-->
                    <br>
                    <br>
                    <label id="time_label">Time: </label>
                     Between
                    <select name="time1">
                        <option id="time1" name="time1" value="01:00">01:00</option>
                        <option id="time1" name="time1" value="02:00">02:00</option>
                        <option id="time1" name="time1" value="03:00">03:00</option>
                        <option id="time1" name="time1" value="04:00">04:00</option>
                        <option id="time1" name="time1" value="05:00">05:00</option>
                        <option id="time1" name="time1" value="06:00">06:00</option>
                        <option id="time1" name="time1" value="07:00">07:00</option>
                        <option id="time1" name="time1" value="08:00">08:00</option>
                        <option id="time1" name="time1" value="09:00">09:00</option>
                        <option id="time1" name="time1" value="10:00">10:00</option>
                        <option id="time1" name="time1" value="11:00">11:00</option>
                        <option id="time1" name="time1" value="12:00">12:00</option>                        
                    </select>
                    <select name="am_pm1">
                        <option id="am_pm1" name="am_pm1" value="AM">AM</option>
                        <option id="am_pm1" name="am_pm1" value="PM">PM</option>
                    </select>
                    <span> and </span>
                    <select name="time2">
                        <option id="time2" name="time2" value="01:00">01:00</option>
                        <option id="time2" name="time2" value="02:00">02:00</option>
                        <option id="time2" name="time2" value="03:00">03:00</option>
                        <option id="time2" name="time2" value="04:00">04:00</option>
                        <option id="time2" name="time2" value="05:00">05:00</option>
                        <option id="time2" name="time2" value="06:00">06:00</option>
                        <option id="time2" name="time2" value="07:00">07:00</option>
                        <option id="time2" name="time2" value="08:00">08:00</option>
                        <option id="time2" name="time2" value="09:00">09:00</option>
                        <option id="time2" name="time2" value="10:00">10:00</option>
                        <option id="time2" name="time2" value="11:00">11:00</option>
                        <option id="time2" name="time2" value="12:00">12:00</option>                        
                    </select>
                    <select name="am_pm2">
                        <option id="am_pm2" name="am_pm2" value="AM">AM</option>
                        <option id="am_pm2" name="am_pm2" value="PM">PM</option>
                    </select>
                        
                    <!--Amount-->
                    <input class="" id="amount_input" name="amount" type="text" placeholder=" Enter the amount " value="<?php if (isset($amount)) { echo $amount; }?>" onkeyup="fillinginfields()" required />
                    
                    
                    <div id="validate-status" >Please fill in ALL fields</div>
                    
                    <button class="" id="post_ad" name="post_ad" type="submit"0>Post Ad</button>
                </form>
            </div>
        </section>
        
        
        
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
                            <br>
                            Tel: 011 283 2044/3854
                            <br>
                            Physical Address: 12 Rivonia drive, Sandton
                        </p>
                    </form>                    
                </div>
            
            </div>    
        </footer>
        
        
        
         <!--<script type="text/javascript" src="../../js/ad.js"></script>
        <!--google maps API-->
        <script>
            // This example displays an address form, using the autocomplete feature
            // of the Google Places API to help users fill in the information.
            
            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

            var placeSearch, autocomplete, autocomplete2;
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };

            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                    {types: ['geocode']});

                // When the user selects an address from the dropdown, populate the address
                // fields in the form.
                autocomplete.addListener('place_changed', function() {
                    fillInAddress(autocomplete, "");
                });
          
                autocomplete2 = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
                    {types: ['geocode']});

                // When the user selects an address from the dropdown, populate the address
                // fields in the form.
                autocomplete.addListener('place_changed', function() {
                    fillInAddress(autocomplete2, "2");
                });
            }

            function fillInAddress(autocomplete, unique) {
                // Get the place details from the autocomplete object.
                var place = autocomplete.getPlace();

                for (var component in componentForm) {
                    if (!!document.getElementById(component + unique)) {
                        document.getElementById(component + unique).value = '';
                        document.getElementById(component + unique).disabled = false;
                    }
                }

                // Get each component of the address from the place details
                // and fill the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType] && document.getElementById(addressType + unique)) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType + unique).value = val;
                    }
                }
            }
            
            google.maps.event.addDomListener(window, "load", initAutocomplete);
            
            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });
                }
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUwakWff-5NOHsFTlxgWr4uSWb9Syjroo&libraries=places&callback=initAutocomplete"
        async defer></script>

        <script src="../../js/universal.js"></script>
        <script src="../../js/mobile_menu.js"></script>
        <script src="../../js/post_ad.js"></script>
    </body>
</html>