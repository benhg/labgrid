<?php

include "stats_connect.php";

if ($mysqli->connect_error) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error; 
}

$result = $mysqli->query('SELECT id, username, jobname, request_time, size, description FROM jobs ORDER BY id DESC LIMIT 20;');

while($row = $result->fetch_array()) {

	echo '<tr>'.PHP_EOL;
    for ($i = 0; $i < count($row) && isset($row[$i]); $i += 1) {
    	echo '<td>'.$row[$i].'</td>'.PHP_EOL;
    }
    echo '</tr>'.PHP_EOL;
}
