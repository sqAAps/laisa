<?php
require './core.inc.php';
require './connect.inc.php';
global $connection;

$user_id = $_POST['id'];

/*Check that each field exists and is submitted*/ 
if (isset($_POST['post'])) {
     
    /*Setting variables*/
    $departure = htmlentities($_POST['departure']);
    $destination = htmlentities($_POST['destination']);
    
	$date = htmlentities($_POST['date']);

    $time =  htmlentities($_POST['time']);
    
    $amount = htmlentities($_POST['amount']);
	
    $type = htmlentities($_POST['type']);
    
	if (isset($_POST['description'])){
		$description = htmlentities($_POST['description']);
	}
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
        echo "added";
        exit;
    } else{
        echo 'Sorry. We could not redister you at this time. Please Try again later';
    }        
}


if (isset($_POST['edit'])){
	$ad_id = $_POST['edit'];
	/*Setting variables*/
    $departure = htmlentities($_POST['departure']);
    $destination = htmlentities($_POST['destination']);
    
	$date = htmlentities($_POST['date']);

    $time =  htmlentities($_POST['time']);
    
    $amount = htmlentities($_POST['amount']);
	
    $type = htmlentities($_POST['type']);
	
	$description = htmlentities($_POST['description']);
    
	if (isset($_POST['description'])){
		$description = htmlentities($_POST['description']);
	}
    //Make $user_id aceesible inthe function
    global $user_id;

    /*Start the registration process*/
  
    /*Registration*/
    /*Inserting User input into server data*/
    $query = "UPDATE `adverts` SET
				`description`='".mysqli_real_escape_string($connection, $description)."',
				`departure`='".mysqli_real_escape_string($connection, $departure)."',
				`destination`='".mysqli_real_escape_string($connection, $destination)."', 
				`date`='".mysqli_real_escape_string($connection, $date)."', 
				`time`='".mysqli_real_escape_string($connection, $time)."', 
                 `amount`='".mysqli_real_escape_string($connection, $amount)."',
				 `type`='".mysqli_real_escape_string($connection, $type)."'
				 WHERE id='".mysqli_real_escape_string($connection, $ad_id)."'";
        
    if(mysqli_query($connection, $query)) {
        echo "edited";
        exit;
    } else{
        echo 'Sorry. We could not redister you at this time. Please Try again later';
    } 
}
?>