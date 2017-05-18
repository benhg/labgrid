<?php

include "../../php-security/security_functions.php";

sec_session_start();

delete_session_from_db($_SESSION['username'], $db_connection);

$_SESSION = array();

$parameters = session_get_cookie_params();

setcookie(session_name(),
		'', time() - 42000, 
		$parameters["path"], 
		$parameters["domain"],
		$parameters["secure"], 
		$parameters["httponly"]);

session_destroy();

header("Location: ../dashboard.php");
