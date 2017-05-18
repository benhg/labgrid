<?php

include "jobs-config.php";

$jobs_connection = new mysqli(JOBHOST, JOBUSER, JOBPASSWORD, JOBDATABASE);
$log = fopen("jobs_connection_log.txt", "w");
fwrite($log, "Establishing connection to labgrid database...\n");
$result = $jobs_connection->query("SELECT DATABASE()");
$row = mysqli_fetch_assoc($result);
fwrite($log, print_r($row, true));
fclose($log);
