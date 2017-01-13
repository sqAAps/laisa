<?php
if( isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['message'])){
	$n = $_POST['fullName']; // HINT: use preg_replace() to filter the data
	$e = $_POST['email'];
	$m = nl2br($_POST['message']);
	$to = "info@sqaaps.co.za";	
	$from = $e;
	$subject = 'sqAAps Contact Form Message';
	$message = '<b>Name:</b> '.$n.' <br><b>Email:</b> '.$e.' <p>'.$m.'</p>';
	$headers = "From: $from\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	if( mail($to, $subject, $message, $headers) ){
		echo "success";
	} else {
		echo "The server failed to send the message. Please try again later.";
	}
}
?>