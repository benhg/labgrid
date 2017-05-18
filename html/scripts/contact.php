<?php

// We use Google's supplied recaptcha code library
require_once "../../includes/recaptchalib.php";

$secret_key = "6LeajhATAAAAAETdecYEOT9QSql6xeUvNw_e_GST";
$response = null;
$reCAPTCHA = new ReCaptcha($secret_key);
if (isset($_POST['g-recaptcha-response'], $_POST['name'], $_POST['email'], $_POST['message'])) {
	$reponse = $reCAPTCHA->verifyResponse(
		$_SERVER['REMOTE_ADDR'],
		$_POST['g-recaptcha-response']
	);
	
	if ($response == null || !($response->success)) header("Location: ../dashboard.php");

	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	$from = 'From: LabGrid-Contact';
	$to = 'theodoreando99@gmail.com';
	$subject = 'Contact Request';
	$body = "From: $name\nEmail: $email\nMessage: $message";
	
	mail($to, $subject, $body, $from);
	mail('benjamin.h.glick@gmail.com', $subject, $body, $from);
	mail('lyoung@ucls.uchicago.edu', $subject, $body, $from);
}

header("Location: ../dashboard.php");

