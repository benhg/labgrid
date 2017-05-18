<?php

include_once "../data_polling/stats_connect.php";

include_once "../php-security/psl-config.php";
include_once "../php-security/db_connect.php";
include_once "../php-security/security_functions.php";
sec_session_start();
#print_r($_POST);
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (DEBUG_LOGGING) echo 'Logging in';
    if (!secure_login($username, $password, $db_connection)) {
        #header("Location: ../download_gate.php?job_id=".$_POST['job_id']."&job_name=".$_POST['job_name']);
    }
} else {
    #header("Location: ../download_gate.php?job_id=".$_POST['job_id']."&job_name=".$_POST['job_name']);
}
#echo "Preparing statement!";
$stmt = $mysqli->prepare("SELECT username, id FROM jobs WHERE condor_id=?");
#echo "Binding params!";
$stmt->bind_param('s', $_POST['job_id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_username, $id);
$stmt->fetch();
if ($job_username == $_POST['username']) {
    $filename = "/var/lib/condor/dropbox/".$_POST['job_name']."_".$id."/".$_POST['job_name'].".out";
    #echo basename($filename);
    #echo filesize($filename);
    header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\"");
    header("Content-Length: " . filesize($filename));
    header("Content-Type: application/octet-stream;");
    readfile($filename);
    
    exec("rm -rf /var/lib/condor/dropbox/".$_POST['job_name']."_".$id);
}

