<?php

$username = $argv[1];
$job_id = $argv[2];
$job_name = $argv[3];


$headers = "From: LabGrid-Contact\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$to = $username.'@ucls.uchicago.edu';
$subject = 'LabGrid Data Output';
$email="LabGrid-Contact@ucls.uchicago.edu";



#$body = "From: $name\nEmail: $email\nMessage: $message";
$body = '<html><body>';
$body .= '<a href="http://labgrid.ucls.uchicago.edu/download_gate.php?job_id='.$job_id.'&job_name='.$job_name.'">Download your results</a>';
$body .= '</body></html>';
mail($to, $subject, $body, $headers);

#exec("rm -r /var/lib/dropbox/".
