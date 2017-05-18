<?php
include_once 'login.php';
include_once "../../php-security/db_connect.php";
include_once "../../php-security/security_functions.php";
include_once "../../php-security/jobs_connect.php";

// We use Google's supplied recaptcha code library
require_once "../../includes/recaptchalib.php";

$logfile = fopen("../logs/submit_log.txt", "w") or die("Fuck");
$secret_key = "6LeajhATAAAAAETdecYEOT9QSql6xeUvNw_e_GST";
$response = null;

$result = $jobs_connection->query("SELECT DATABASE()");
$row = mysqli_fetch_assoc($result);
fwrite($logfile, print_r($row, true));


function store_job_to_db($username, $db_connection, $jobs_connection, $logfile, $jobname, $description,$size) {	
	$existing_session = check_login($db_connection);
    fwrite($logfile, "Session checked\n");
    if ($existing_session) {
        update_session($username, $db_connection);
    }
	else{return false;}
    fwrite($logfile, "Session updated\n");
	fwrite($logfile,mysqli_error($db_connection)."\n");
    $sql = "INSERT INTO jobs (username, jobname, request_time, description, size) VALUES (?, ?, ?, ?, ?)";
    $stmt = $jobs_connection->prepare($sql);
	fwrite($logfile,mysqli_error($jobs_connection)."\n");
    $request_time = date("Y-m-d H:i:s");
    $hash = $_SESSION['login_session_id'];
    $jobname=$jobname;
    $username=$username;
    if ($stmt) {
        $stmt->bind_param('ssssi', $username, $jobname,  $request_time, $description, $size);
        $stmt->execute();
        fwrite($logfile, mysqli_error($jobs_connection)."\n");
        return true;
    }
    fwrite($logfile, "failed to add\n");
	return false;
}

function get_jobid($username, $db_connection,$jobs_connection,$logfile){
    $jobid=0;
    $existing_session=check_existing_session($username, $db_connection);
    if($existing_session){
        update_session($username, $db_connection);
    }
    $result = $jobs_connection->query("SELECT MAX(id) AS max_id FROM jobs");
    fwrite($logfile, "Job query returned: ".print_r($result, true)."\n");
	return mysqli_fetch_array ($result)["max_id"];
}

$reCAPTCHA = new ReCaptcha($secret_key);
if (isset($_POST['g-recaptcha-response'], $_POST['jobname'], $_POST['exe'], $_POST['uploaded_file'])) {
    $reponse = $reCAPTCHA->verifyResponse(
        $_SERVER['REMOTE_ADDR'],
        $_POST['g-recaptcha-response']
    );
	

	if ($response == null || !($response->success)) header("location:javascript://history.go(-1)");

    $jobname = $_POST['jobname'];
    $exe = $_POST['exe'];
    $file = $_POST['uploaded_file'];
    $filetype = pathinfo($_POST['exe'], PATHINFO_EXTENSION);
    $size=$_POST['size-input'];
    $description=$_POST['desc'];
	$argsfile = $jobname.".args";
}


$jobname = $_POST['jobname'];
$exe = $_POST['exe'];
$file = $_FILES['uploaded_file'];
$filetype = pathinfo($_POST['exe'], PATHINFO_EXTENSION);
$size=$_POST['size-input'];
$description=$_POST['desc'];
$argsfile = $jobname.".args";

if(is_null($argsfile)){
    $argsfile="None";
}



fwrite($logfile, "\n<---Begin submit_job.php output");
fwrite($logfile, print_r($_POST, true ));
fwrite($logfile, print_r($_FILES, true ));
fwrite($logfile, "Check login returned: ".check_login($db_connection)."\n");
if (check_login($db_connection)){
	$username = $_SESSION['username'];
	fwrite($logfile, print_r($_SESSION,true));
	fwrite($logfile, "MySQL jobs params: ".$username.$jobname.$request_time.$description.$size."\n");
   	fwrite($logfile, "Store job to db returned: ".store_job_to_db($_SESSION['username'], $db_connection, $jobs_connection, $logfile, $jobname, $description,$size)."\n");
	$jobid=get_jobid($_SESSION['username'],$db_connection, $jobs_connection,$logfile);
	if($jobid==0){
		#figure out somethig to do if jobid is fucked	
	}
	fwrite($logfile,"Got Job ID: ".$jobid."\n");
	include_once "./file_upload.php";
	fwrite($logfile,print_r($_FILES,true));
	exec("mkdir /var/lib/condor/dropbox/".$jobname."_".$jobid);
	exec("chmod -R 777 /var/lib/condor/dropbox/".$jobname."_".$jobid);
	exec("unzip -j ".$target_file." -d /var/lib/condor/dropbox/".$jobname."_".$jobid."/");
	exec("chmod -R 777 /var/lib/condor/dropbox/".$jobname."_".$jobid);
	exec("rm -r ".$target_file);
	fwrite($logfile, "----->DID NOT FAIL BEFORE PY SCRIPT<-----");
	exec("python /var/www/html/scripts/create_sub_file.py ".$jobname." ".$exe." ".$filetype." ".$argsfile." ".$jobid." ".$size);
}

fclose($logfile);


#header("Location: ./dashboard.php");
?>
