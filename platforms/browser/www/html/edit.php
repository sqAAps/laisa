<?php
require '../connect.inc.php';
require '../core.inc.php';
global $connection;

function edit_my_ad($description,$departure,$destination,$amount,$ad_id,$date){
    global $connection;
    $user_id = $_SESSION['user_id'];
?> 
    <!DOCTYPE HTML>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href='../../index.css' rel='stylesheet' type="text/css">
            <link href='../../place_ad/post_ad.css' rel='stylesheet' type="text/css">
            <link href='../edit_my_ad.css' rel='stylesheet' type="text/css">
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        </head>
        
        <body>
            
            <!--            Navigation bar          -->
            <ul class="nav_head" id="nav_head">
                <!--    Logo    -->
                <li class="nav_items" id="index_logo">
                    <?php echo '<a href="http://localhost/projects/namela/index.php">' ?>
                        <img class="logo" id="logo" src="http://localhost/projects/namela/images/namela.png" />
                    <?php echo'</a>' ?>
                </li>
            
                <?php 
                if(isset($_SESSION['user_id'])){ 
                    ?>
                    <!--Upload-->
                    <li class="nav_items left_logout" id="upload">
                        <?php echo '<a href="http://localhost/projects/namela/Place_Ad/ad.php/'.getuserfield('firstName').'.'.getuserfield('surname').'">' ?>
                        <input class="post_ad" id="post_ad" type="button" value="Post?" />
                        <?php echo '</a>'?>
                    </li>
                    
                    <!--Profile-->
                    <li class="nav_items left_logout" id="profile">
                        <?php
                        $user_id = $_SESSION['user_id'];
                        //Check FOR USER PROFILE NAME                            
                        $images = glob("../images/users/".$user_id."*.{jpeg,jpg,png}", GLOB_BRACE);
                        foreach($images as $image)
                        $user_profile_picture_name = basename($image);
    
                        echo '<a  href="http://localhost/projects/namela/view_my_profile/viewmyprofile.php/'.getuserfield('firstName').'.'.getuserfield('surname').'"><img id="nav_image" src="http://localhost/projects/namela//images/users/'.$user_profile_picture_name.'"/></a>';
                        ?>
                        <a href="http://localhost/projects/namela/LogOut/signout.php">
                            <button id="logout" name="logout" type="submit">Log Out</button>
                        </a>
                    </li>
                    <?php 
                } ?>
            </ul>
            
            
            
            <section id="post_ad_section">
                <div class="container-fluid" id="post_container">
                    
                    <h2 class="post_ad_heading">Update Post</h2>
                    
                    <!--Advert Form-->
                    <form id="post_form" name="update_profile_form" action="" method="POST">
                
                        <!--Departure Field-->
                        <input id="autocomplete" name="departure" type="text" placeholder=" Enter your point of departure" maxlength="40" value="<?php echo $departure; ?>" required />
                        
                        <!--Destination Field-->
                        <input id="autocomplete2" name="destination" type="text" placeholder=" Enter destination point" maxlength="40" value="<?php echo $destination; ?>" required />
                        
                        <!--Basic information Field-->
                        <textarea id="description_input" name="description" rows="5" cols="50" placeholder="  Please write any additional information regarding the travel plan"><?php echo $description; ?></textarea>
                                                   
                        <!--Date of departure-->
                        <br>
                        <label id="date_label">Date:</label>
                        <input id="date_input" type="text" name="date" value="<?php if (isset($date)) { echo $date; }?>" placeholder="Date of departure" required />
                    
                        <!--Time of departure-->
                        <br>
                        <br>
                        <label id="time_label">Time: </label>
                        Between
                        <select name="time1">
                        <option id="time1" name="time1" value="00:00">00:00</option>
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
                        <option id="time1" name="time1" value="13:00">13:00</option>
                        <option id="time1" name="time1" value="14:00">14:00</option>
                        <option id="time1" name="time1" value="15:00">15:00</option>
                        <option id="time1" name="time1" value="16:00">16:00</option>
                        <option id="time1" name="time1" value="17:00">17:00</option>
                        <option id="time1" name="time1" value="18:00">18:00</option>
                        <option id="time1" name="time1" value="19:00">19:00</option>
                        <option id="time1" name="time1" value="20:00">10:00</option>
                        <option id="time1" name="time1" value="21:00">21:00</option>
                        <option id="time1" name="time1" name="time1" value="22:00">22:00</option>
                        <option id="time1" name="time1" value="23:00">23:00</option>
                        <option id="time1" name="time1" value="00:00">00:00</option>                        
                    </select>
                        <span> and </span>
                        <select name="time2">
                        <option id="time2" name="time2" value="00:00">00:00</option>
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
                        <option id="time2" name="time2" value="13:00">13:00</option>
                        <option id="time2" name="time2" value="14:00">14:00</option>
                        <option id="time2" name="time2" value="15:00">15:00</option>
                        <option id="time2" name="time2" value="16:00">16:00</option>
                        <option id="time2" name="time2" value="17:00">17:00</option>
                        <option id="time2" name="time2" value="18:00">18:00</option>
                        <option id="time2" name="time2" value="19:00">19:00</option>
                        <option id="time2" name="time2" value="20:00">20:00</option>
                        <option id="time2" name="time2" value="21:00">21:00</option>
                        <option id="time2" name="time2" value="22:00">22:00</option>
                        <option id="time2" name="time2" value="23:00">23:00</option>
                        <option id="time2" name="time2" value="00:00">00:00</option>                        
                    </select>
                        
                        <!--Amount-->
                        <input id="amount_input" name="amount" type="text" placeholder=" Enter the amount " value="<?php echo "R".$amount; ?>" required />
                        <input id="hide_ad_id" type="text" name="ad_id" value="<?php echo $ad_id; ?>">
                        
                        <button class="" id="post_ad" name="update_button" type="update_button">Submit</button>
                    </form>
                </div>
            </section>
            
            
            
            <!--            FOOTER          -->
            <footer>
                <div class="container-fluid">
                    <ul id="footer_info">
                        <li class="footer_items" id="about_us">
                            <a id="footer_links" href="http://localhost/projects/namela/about_us/about_us.php#company_info?">About Us</a>
                        </li>
                        <li class="footer_items" id="privacy">
                            <a id="footer_links" href="http://localhost/projects/namela/about_us/about_us.php#terms_info">Privacy & Terms</a>
                        </li>
                        <li class="footer_items" id="Careers">
                            <a id="footer_links" href="http://localhost/projects/namela/about_us/about_us.php#careers_info">Careers</a>
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

            <script src="http://localhost/projects/namela/js/index_ads.js"></script>
        </body>
    </html>
<?php
}

//If the form has been submitted has, process the form and save it to the database
if (isset($_POST['description'])&&
    isset($_POST['departure'])&&
    isset($_POST['destination'])&&
    isset($_POST['date'])&&
    isset($_POST['time1'])&&
    isset($_POST['time2'])&&
    isset($_POST['amount'])) {
    
    global $connection;
    
    /*Setting variables*/
    $description = htmlentities($_POST['description']);
    $departure = htmlentities($_POST['departure']);
    $destination = htmlentities($_POST['destination']);
    $date = htmlentities($_POST['date']);
                         
    $time1 = htmlentities($_POST['time1']);
    $time2 = htmlentities($_POST['time1']);
    $time = "Between $time1 and $time2 ";
    
    $amount = htmlentities($_POST['amount']);
                           
    $ad_id = $_POST['ad_id'];
    
    //checking user input with tabel data
    if (!empty($description)&&
        !empty($departure)&&
        !empty($destination)&&
        !empty($date)&&
        !empty($time)&&
        !empty($amount)) {
        
        // save the data to the database
        $query = "UPDATE `adverts` SET 
                        `description`='".mysqli_real_escape_string($connection, $description)."',
                        `departure`='".mysqli_real_escape_string($connection, $departure)."',
                        `destination`='".mysqli_real_escape_string($connection, $destination)."', 
                        `date`='".mysqli_real_escape_string($connection, $date)."', 
                        `time`='".mysqli_real_escape_string($connection, $time)."', 
                        `amount`='".mysqli_real_escape_string($connection, $amount)."'  
                    WHERE id='".mysqli_real_escape_string($connection, $ad_id)."'";
        $result = mysqli_query($connection, $query) or die(mysqli_error());
            
        header('Location:  ../../view_my_profile/viewmyprofile.php/'.getuserfield('firstName').'.'.getuserfield('surname').'');
    }
    else {
        echo 'All fields are required IN IF STATEMENT.';
    }
}

// if the form hasn't been submitted, get the data from the db and display the form
else {
    $user_id = $_SESSION['user_id'];
    $ad_id = $_POST['ad_id'];
    
    // query db
    $query = "SELECT * FROM `adverts` WHERE `id`='".mysqli_real_escape_string($connection, $ad_id)."'";
    $result = mysqli_query($connection, $query) or die(mysqli_error()); 
        
    //run database
    $rows = mysqli_fetch_array($result);
 
    // check that the 'id' matches up with a row in the databse
        if($rows) {
            // get data from db
            $user_id = $rows['user_id'];
            $description = $rows['description'];
            $departure = $rows['departure'];
            $destination = $rows['destination'];
            $date = $rows['date'];
            $time = $rows['time'];
            $amount = $rows['amount'];
            
            // show form
            edit_my_ad($description,$departure,$destination,$amount,$ad_id,$date);
        }
    }
?>