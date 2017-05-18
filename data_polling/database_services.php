<?php
include_once "stats_connect.php";


function query($connection, $statement) {
    $result = $connection->query($statement);
    $rows = array();
    while ($row = $result->fetch_array()) $rows[] = $row[0];
    return $rows;
}