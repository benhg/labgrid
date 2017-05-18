<?php

include_once "../../php-security/psl-config.php";
if (DEBUG_LOGGING) echo 'Got constants. ';
include_once "../../php-security/db_connect.php";
if (DEBUG_LOGGING) echo 'Established connection to database. ';
include_once "../../php-security/security_functions.php";
if (DEBUG_LOGGING) echo 'Loaded security functions.';

if (DEBUG_LOGGING) echo 'Beginning session';
sec_session_start();

if (isset($_POST['username'], $_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	if (DEBUG_LOGGING) echo 'Logging in';	
	if (secure_login($username, $password, $db_connection)) {
		header("Location: ../dashboard.php");
	}
}
header("Location: ../dashboard.php");
