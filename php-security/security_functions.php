<?php

include_once "psl-config.php";
include_once "db_connect.php";

/**
 * Securely start a session [ replaces session_start() ]
 *
 * We only allow http connections to prevent Javascript based cookie attacks.
 * We only use cookies for sessions.
 * We regenerate the session id every time to prevent hijacking.
 */
function sec_session_start () {
	$sec_session_id = 'secure_session';
	$secure = SECURE;

	$httponly = true;

	if (ini_set('session.use_only_cookies', 1) === false) {
        header("Location: ../LICENSE.txt");
        exit();
	}
	
	$cookie_parameters = session_get_cookie_params();
	session_set_cookie_params(
		$cookie_parameters["lifetime"],
        	$cookie_parameters["path"], 
        	$cookie_parameters["domain"], 
        	$secure,
        	$httponly
	);

	session_name($sec_session_id);
	session_start();
	session_regenerate_id(true);
}

/**
 * Securely log in to site.
 *
 * We check whether we suspect a brute force password crack is being attempted.
 * We then authenticate the username/password combo with Jonathan's implementa-
 * tion of UChicago's LDAP server.
 * If the authentication is not successful, we log the username.
 * We check whether a given person is a member yet.  In the current state, they
 * are denied if they aren't in our database.
 * We store their session and then return true.
 *
 * @param $username
 * @param $password
 * @param $db_connection
 * @return bool
 * 
 * @todo Allow non-members to log in, prompt for preferences.
 */
function secure_login ($username, $password, $db_connection) {
    // Check for too many recent login attempts
    if (DEBUG_LOGGING) echo 'Checking brute forced attempts'.PHP_EOL;
    if (check_brute($username, $db_connection)) return false;

    // We pole Jonathan's page to test for correct user_id
    if (DEBUG_LOGGING) echo ' Making LDAP request.'.PHP_EOL;
    $result = LDAP_authenticate($username, $password);

    // The login attempt failed, note the username used.
    if (DEBUG_LOGGING) echo ' Received response, checking validity.'.PHP_EOL;
    if (!check_login_attempt($username, $result, $db_connection)) return false;

    if (DEBUG_LOGGING) echo 'Login succeeded.'.PHP_EOL;

    //$user_id = get_user_id($username, $db_connection);
    //if ($user_id == -1) return false;

    // Login attempt succeeded
    store_session_to_global($username, $user_id);

    if (DEBUG_LOGGING) echo 'Storing session on server.'.PHP_EOL;
    if (!store_session_to_db($username, $db_connection)) return false;

    return true;
}

/**
 * @param $db_connection
 * @return bool
 */
function check_login($db_connection) {
    // If there is no stored session data, user cannot be logged in
    if (!isset($_SESSION['username'], $_SESSION['login_session_id'])) {
        if (DEBUG_LOGGING) echo 'No session values found';
        return false;
    }

    // Time stamps must be in the past 2 hours
    $valid_time = time() - SESSION_TIMEOUT;
    if (!($stmt = $db_connection->prepare("SELECT hash FROM sessions WHERE username = ? AND time_stamp > ?"))) {
        if (DEBUG_LOGGING) echo 'Statement preparation failed.'.PHP_EOL.$db_connection->error;
        return false;
    }

    if (DEBUG_LOGGING) echo 'Checking sessions for '.$_SESSION['username'].', '.$valid_time.PHP_EOL;
    $stmt->bind_param('si', $_SESSION['username'], $valid_time);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($stored_login_hash);
        $stmt->fetch();
        //echo $_SESSION['login_session_id'].PHP_EOL;
        //echo $_SESSION['HTTP_USER_AGENT'].PHP_EOL;
        $login_check = hash('sha512', $_SESSION['username']);
        //echo "Checking hashes".PHP_EOL;
        //echo $login_check." ?= ".$stored_login_hash;
        return $login_check == $stored_login_hash;
    } else return false;
}

/**
 * @param $username
 * @param $db_connection
 * @return bool
 */
function check_brute($username, $db_connection) {
    $time_stamp = time();
    $valid_time = $time_stamp - SESSION_TIMEOUT;
    if ($stmt = $db_connection->prepare("SELECT time_stamp FROM login_attempts WHERE username = ? AND time_stamp > '$valid_time'")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        // If more than 5 failed login attempts within the session timeout, lock
        $lock = $stmt->num_rows > 5;
        if ($lock) {
            if (DEBUG_LOGGING) echo 'Login failed: attempting to retard brute force attacks...'.PHP_EOL;
            return true;
        } else return false;

    } else {
        if (DEBUG_LOGGING) echo 'Statement preparation failed.'.PHP_EOL;
        return true;
    }
}

/**
 * @param $username
 * @param $password
 * @return mixed
 */
function LDAP_authenticate($username, $password) {
    $url = 'https://sc.ucls.uchicago.edu/LDAP/index.php';
    $postData = array();
    $postData['username'] = $username;
    $postData['password'] = $password;
    $postData['submit'] ='submit';
	if (DEBUG_LOGGING) echo 'Initializing curl request. ';
    $ch = curl_init();
	if (DEBUG_LOGGING) echo 'Setting curl parameters. ';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	if (DEBUG_LOGGING) echo 'Executing curl. ';
    $result = curl_exec($ch);
    curl_close($ch);
	if (DEBUG_LOGGING) echo 'Returning. ';
    return $result;
}

/**
 * @param $username
 * @param $db_connection
 * @return int|string
 */
function get_user_id($username, $db_connection) {
    $user_id = '';
    if (!($stmt = $db_connection->prepare("SELECT id FROM members WHERE username = ? LIMIT 1"))) return -1;
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    if ($stmt->num_rows == 1) return $user_id;
    else return -1;
}

/**
 * @param $username
 * @param $user_id
 */
function store_session_to_global($username, $user_id) {
    if (DEBUG_LOGGING) echo 'Storing user data to session.'.PHP_EOL;
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
    $_SESSION['user_id'] = $user_id;

    //$username = preg_replace("/[^a-zA-Z0-9_\\-]+/", "", $username);
    $_SESSION['username'] = $username;
    $_SESSION['login_session_id'] = hash('sha512', $username);
}

/**
 * @param $username
 * @param $db_connection
 * @return bool
 */
function store_session_to_db($username, $db_connection) {
	$existing_session = check_existing_session($username, $db_connection);
	if ($existing_session) {
		update_session($username, $db_connection);
		return true;
	}
	
    $sql = "INSERT INTO sessions (username, hash, time_stamp) VALUES (?, ?, ?)";
    $stmt = $db_connection->prepare($sql);
    $time_stamp = time();
    $hash = $_SESSION['login_session_id'];
    if ($stmt) {
        $stmt->bind_param('ssi', $username, $hash, $time_stamp);
        $stmt->execute();
        return true;
    } else return false;
}

/**
 * Checks whether there is already a session in the database under a username.
 * 
 * @param $username
 * @param $db_connection
 * @return bool
 */
function check_existing_session($username, $db_connection) {
	$sql = "SELECT EXISTS(SELECT 1 FROM sessions WHERE username = ?)";
    $stmt = $db_connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($existing_session);
		$stmt->fetch();
		return $existing_session;
    }
}

/**
 * Updates an existing session's time stamp.
 * 
 * @param $username
 * @param $db_connection
 */
function update_session($username, $db_connection) {
	$sql = "UPDATE sessions SET time_stamp = ? WHERE username = ?";
	$time_stamp = time();
	$stmt = $db_connection->prepare($sql);
	if ($stmt) {
		$stmt->bind_param("is", $time_stamp, $username);
		$stmt->execute();
	}
}

/**
 * @param $username
 * @param $db_connection
 * @return bool
 */
function delete_session_from_db($username, $db_connection) {
    $sql = "DELETE FROM sessions WHERE username = ?";
    if (DEBUG_LOGGING) echo 'Preparing to remove session from database.'.PHP_EOL;
    if ($stmt = $db_connection->prepare($sql)) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        if (DEBUG_LOGGING) echo 'Deleted session from database.'.PHP_EOL;
        return true;
    } else {
        if (DEBUG_LOGGING) echo 'Statement preparation failed, cancelling logout.'.PHP_EOL;
        return false;
    }
}

/**
 * @param $username
 * @param $result
 * @param $db_connection
 * @return bool
 */
function check_login_attempt($username, $result, $db_connection) {
	$log = fopen("security_log.txt", "w");
	fwrite($log, $result);
	fclose($log);
    if (strpos($result, 'Invalid Credentials') !== false) {
        if (DEBUG_LOGGING) echo 'Authentication failed.' . PHP_EOL;
        $time_stamp = time();
        $stmt = $db_connection->prepare("INSERT INTO login_attempts (username, time_stamp) VALUES (?, ?);");
        $stmt->bind_param('si', $username, $time_stamp);
        $stmt->execute();
        return false;
    } else {
        $_SESSION['given-name'] = $result['givenname'];
        $_SESSION['surname'] = $result['sn'];
        return true;
    }
}
