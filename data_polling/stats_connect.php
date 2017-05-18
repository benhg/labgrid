<?php
include "stats_connect_config.php";

$mysqli = mysqli_connect(STAT_HOST, STAT_USER, STAT_PASSWORD, STAT_DATABASE);
#echo $mysqli->ping();
