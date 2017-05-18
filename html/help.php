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

<title>LabGrid Help</title>

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

<link rel="stylesheet" href="assets/css/help.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=multipleRecaptchaRender&render=explicit' async defer></script>
<script src="assets/js/multipleRecaptchaRender.js"></script>
<script src="assets/js/auto-styling.js"></script>
<script src="assets/js/bootstrap-lightbox.js"></script>
<script src="assets/js/bootstrap-lightbox.min.js"></script>
</head>
<body>
<?php include_once "navbars/navigation_top.php"; ?>
<div class="container-fluid">
        <div class="main">
            <h1 class="header">LabGrid Help</h1>
            <div class="row">
                <div class="col-md-6">
                        <h3 class="sub-header">The Basics</h3>
                        <p>LabGrid is designed to be easy to use. It takes no knowledge of command line interfaces or HTCondor to submit jobs to our pool. However, there are a few basic requirements. You can use LabGrid to run any executable that would run normally on Unix, even shell scripts.If you have architecture-specific jobs, such as compiled C code, it should be compiled for Ubuntu Linux. Additionally, if there are any arguments for your code defined out of your code, they should be put in a file called YOURJOBNAME.args, where YOURJOBNAME is what you put in the "Job Name" field on the submit menu. A separate instance of your code will be run with each line in the arguments file as the arguments for that instance. Once you have a job ready to run, zip it up, and you're ready to submit!</p>
               </div>
               <div class="col-md-6">
                        <h3 class="sub-header">File Structure Expected</h3>
                    <p>The LabGrid system expects only a single file to be submitted. It is required to be a zip archive, with all dependencies contained within. Enclosed directly in the zip archive, not in any subdirectories, must be a file matching the name you specify as the "executable" in the job submission page. If your code requires arguments defined outside of your code, for example if you have a number of datasets to run the same code on, you should put each set of user arguments in a file called JOBNAME.args, where JOBNAME refers to what you put into the "Job Name" section of the submit menu. The system will then queue one instance of your code with each line of the arguments file as that instance's argumets. The system expects a flat file tree, with your code and arguments put directly in the zip file, with no enclosing or enclosed folders.</p>
               </div>       
                <h2 id="pics" class="header">Other Things</h2>
             </div>
                <div class="row">
                        <div class="col-md-4">
                                <h3 class="sub-header">Job End Behaviour</h3>    
                                
                                <p>Under Construction. Eventually there will be a system in place where users will recieve an e-mail with a download link to their job's output file upon completion.</p>
                        </div>
                        <div class="col-md-4">
                                <h3 class="sub-header">List of Accepted Executable Types</h3> 
                             		<p>If you wish to suggest another type of executable file, use the contact form on the navbar.</p>
									<ul>
										<li>UNIX shell scripts (SH or BASH)</li>
										<li>Python Scripts (.py)</li>
										<li>Compiled Executables for UNIX (Ubuntu Linux--NO WINDOWS .exe FILES)</li>
										<li>Compiled C/C++ Code(compiled for Ubuntu Linux)</li>
										<li>Any UNIX executable</li>
									</ul>
                                
                        </div>
                        <div class="col-md-4">
                                <h3 class="sub-header">Annotated Picture of Submit Job Modal</h3>
                                <a href="#" data-toggle="modal" data-target="#submit_job_image_modal"><img src="../assets/img/submit_modal.png"></a>
                                <p>Click image to view full-size file.</p>
                        </div>
                </div>

        </div>
</div>
</body>
<?php include "../includes/analyticstracking.php"; ?>
<?php include_once "modals/submit_job_image_modal.php"; ?>"
</html>

