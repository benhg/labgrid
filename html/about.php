<!DOCTYPE html >
<?php
include_once "../php-security/security_functions.php";
sec_session_start();
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE-edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="labgrid">
<meta name="author" content"labgrid">
<link rel="icon" href="">

<title>About LabGrid</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->


<!-- JQuery and Styles -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/css/about.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="assets/js/auto-styling.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=multipleRecaptchaRender&render=explicit' async defer></script>
<script src="assets/js/multipleRecaptchaRender.js"></script>
<style>
</style>
</head>
<body>
<?php include_once "navbars/navigation_top.php"; ?>
<div class="container-fluid">
        <div class="main">
            <h1 class="page-header">About LabGrid</h1>
            <div class="row">
                <div class="col-md-6">
                        <h2 class="sub-header">The Idea</h2>
                        <p>LabGrid is an open-source distributed computing project.  The goal is to take the often idle computers at the University of Chicago Laboratory School and link them into a single computing cluster, which can execute high-throughput programs and jobs, as a resource for the school.  Students and faculty will be welcome to submit jobs through our web interface(under construction). Students and faculty are allowed to submit any code that they would like run on a high-performance system, provided that A) the code follows the guidelines set forth on the <a href="help.php">Help</a> page, and B) the code is not malware.  Additionally, this cluster will eventually serve as a school resource, allowing for a number of changes to courses that are not possible with current school technology, for example: Statistical analysis for AP stats using large, real-world datasets, Computer Science curriculum relating to distributed systems and networking, computational Physics and Biology, and pretty much anything else students and faculty can think of!</p>
               </div>
               <div class="col-md-6">
                        <h2 class="sub-header">How It Works </h2>
                        <p>Using HTCondor, the computers are linked to a secure private network through the internet.  One computer is the central manager, controlling the flow of jobs.  The computers do not run jobs constantly, rather small clusters are created elastically and dynamically as needed.  Each computer is configured to only run jobs when idle, monitoring keyboard and mouse input to determine when it is available. Execution is also capped on each computer in the pool, ensuring that users of school-owned computers are able to use their computers as normal, even though there are LabGrid jobs running in the background.</p>
               </div>       
             </div>
             <h2 id="team" class="page-header">Meet the Team</h2>
                    <div class="row">
                        <div class="col-md-4">
                                <h3 id=picname class="sub-header">Theodore Ando</h3>    
                                <img class="img-responsive center-block" src="assets/img/dore.jpg">
                                <p> Theodore Ando is a senior at the University of Chicago Laboratory High School. Some of his main interests include Ping Pong, Computational Linguistics, Borderlands 2, Pascale Boonstra, and high-quality coffee. He was hand made (and homemade) with love in San Francisco, and except for the San Francisco part, his code is the same way. </p>
                        </div>
                        <div class="col-md-4">
                                <h3 id=picname class="sub-header">Ben Glick</h3> 
                                <img class="img-responsive center-block" src="assets/img/ben.jpg">  
                                <p>Ben is a senior at the University of Chicago Laboratory High School. He enjoys European soccer, electronics, and being smitten. In the fall he will be attending Lewis & Clark in Portland, and is excited to be able to experience as much pretentious organic coffee as possible. When he is not toasting, he fills his free time with judo and loudly complaining about car engines.</p>
                        </div>
                        <div class="col-md-4">
                                <h3 id=picname class="sub-header">Logan Young</h3>
                                <img class="img-responsive center-block" src="assets/img/gan.jpg">  
                                <p>Logan Young is a senior of the University of Chicago Laboratory High School. In his free time he enjoys being a casual in Super Smash Bros Melee for the Nintendo GameCube. Narwhal wrangling is a hidden passion of his. On the weekends he appreciates indie music and procrastination.</p>
                        </div>
                </div>

        </div>
</div>
</body>
<?php include "../includes/analyticstracking.php"; ?>
</html>

