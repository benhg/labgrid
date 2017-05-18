<?php
// Color palette taken from UChicago for all graphs
include_once "color_palette.php";
// Database connection to collect stats
include_once "stats_connect.php";
// Useful database actions
include_once "database_services.php";

function write_graph_json_file($file_name, $file_data) {
    $fp = fopen("../html/assets/graph_jsons/".$file_name, "w");
    fwrite($fp, json_encode($file_data));
    fclose($fp);
}

function get_rgb($color) {
    list($r, $g, $b) = sscanf($color, "%02x%02x%02x");
    return array($r, $g, $b);
}

$file_names = array();

// Location distribution of computers
$rows = query($mysqli, 'SELECT location FROM ip_addresses;');
$location_count = array_count_values($rows);
shuffle($color_palette);
$color_selection = array_rand($color_palette, count($location_count));
$i = 0;
$graph = array("type"=>"pie", "data"=>array()); // This is a pie chart
foreach ($location_count as $key => $value) {
    $graph["data"][$i] = array("value"=>$value, "color"=>"#".$color_palette[$color_selection[$i]], "label"=>$key);
    $i += 1;
}
write_graph_json_file("location_data.json", $graph);
$file_names[count($file_names)] = "location_data.json";


// Job size distribution
$rows = query($mysqli, 'SELECT size FROM jobs WHERE status=0;');
$size_count = array_count_values($rows);
shuffle($color_palette);
$color_selection = array_rand($color_palette, count($size_count));
$i = 0;
$graph =  array("type"=>"pie", "data"=>array()); // This is a pie chart
foreach ($size_count as $key => $value) {
    $graph["data"][$i] = array("value"=>$value, "color"=>"#".$color_palette[$color_selection[$i]], "label"=>$key);
    $i += 1;
}
write_graph_json_file("size_data.json", $graph);
//$file_names[count($file_names)] = "size_data.json";
$file_names[] = "size_data.json";

// Time since job request sent over past 4 days
shuffle($color_palette);
$color = 0; // Color for graph
$completed_jobs = query($mysqli, 'SELECT * FROM completed_jobs;');
$current_jobs = query($mysqli, 'SELECT * FROM current_jobs;');
$graph = array("type"=>"line", "data"=>array());
$graph["data"]["labels"] = array("3", "2", "1", "Today");
$graph["data"]["datasets"] = array();
$graph["data"]["datasets"][0]["label"] = "Time Length Data";

$rgb = get_rgb($color_palette[$color]);
$graph["data"]["datasets"][0]["fillColor"] = "rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",0.2)"; // 20% Opacity fill

$graph["data"]["datasets"][0]["strokeColor"] = "#".$color_palette[$color]; // Normal raw color
$graph["data"]["datasets"][0]["data"] = array_map("floatval", array_merge($completed_jobs, $current_jobs));
//echo "\n".json_encode($graph)."\n";
write_graph_json_file("time_data.json", $graph);
$file_names[] = "time_data.json";


// Jobs completed by day
shuffle($color_palette);
$completed_jobs = query($mysqli, "SELECT COUNT(*) FROM jobs WHERE status=1 GROUP BY DATE(request_time);");
$graph = array("type"=>"line", "data"=>array());
$graph["data"]["labels"] = array("3", "2", "1", "Today");
$graph["data"]["datasets"] = array();
$graph["data"]["datasets"][0]["label"] = "Job Completion Data";
$rgb = get_rgb($color_palette[$color]);
$graph["data"]["datasets"][0]["fillColor"] = "rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",0.2)"; // 20% Opacity fill
$graph["data"]["datasets"][0]["strokeColor"] = "#".$color_palette[$color]; // Normal raw color
$graph["data"]["datasets"][0]["data"] = array_map("floatval", array_merge($completed_jobs, $current_jobs));
write_graph_json_file("completion_data.json", $graph);
$file_names[] = "completion_data.json";

// Return the file names to our javascript to actually generate the graphs
echo json_encode($file_names);
