<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include_once "../php-security/security_functions.php";
sec_session_start();
?>

<!DOCTYPE html >

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="labgrid">
	<meta name="author" content="labgrid">
	<link rel="icon" href="">

    <title>LabGrid Dashboard</title>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- JQuery and Styles -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="./assets/css/dashboard.css">
	<!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
	
	<!-- Graphing Library -->
	<script src="assets/js/Chart.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?onload=multipleRecaptchaRender&render=explicit' async defer></script>
    <script src="assets/js/multipleRecaptchaRender.js"></script>
</head>
<body>

<?php
include "./navbars/navigation_top.php";
include "./modals/login_modal.php";
include "./modals/submit_job_modal.php";
?>
<div class="container-fluid">
<div class="row">
        <?php
        include "./navbars/navigation_side.php";
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Current Usage</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-6 col-md-3 placeholder" id="computer_usage_chart_section">
                    <div><canvas id="graph0" class="computerUsageChart"></canvas></div>
                    <h4>Locations</h4>
                    <span class="text-muted">Where active jobs are run</span>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 placeholder">
                    <div><canvas id="graph1" class="computerUsageChart"></canvas></div>
                    <h4>Size</h4>
                    <span class="text-muted">Distribution of job sizes</span>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 placeholder">
                    <div><canvas id="graph2" class="computerUsageChart"></canvas></div>
                    <h4>Length</h4>
                    <span class="text-muted">Average time since request</span>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 placeholder">
                    <div><canvas id="graph3" class="computerUsageChart"></canvas></div>
                    <h4>Completed</h4>
                    <span class="text-muted">Jobs completed by day</span>
                </div>
            </div>

            <h2 class="sub-header" id="recent_jobs">Recent Jobs</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
						<th>Job Name</th>
                        <th>Time</th>
                        <th>Size</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php include "../data_polling/table_data.php"; ?>
					</tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<script>
    Chart.defaults.global.responsive = true;
    // Get JSON data
	var file_names = <?php include "../data_polling/graph_data.php"; ?>;
    console.log(file_names);
    for (var i = 0; i < file_names.length; i++) {
        (function () {
            const file_id = i;
            console.log("Accessing: " + file_names[file_id]);
            $.getJSON(
                "assets/graph_jsons/" + file_names[file_id],
                function (file) {
                    console.log("Rendering graph " + file_id);
                    console.log(file);
                    var graph = document.getElementById('graph' + file_id);
                    var chart = null;
                    switch (file['type']) {
                        case "pie":
                            console.log('It was a pie graph.');
                            chart = new Chart(graph.getContext('2d')).Pie(file['data']);
                            break;
                        case "line":
                            console.log('It was a line graph.');
                            chart = new Chart(graph.getContext('2d')).Line(file['data']);
                    }
                }
            );
        })();
    }
</script>

<script src="assets/js/auto-styling.js"></script>
<script>
	// $('form').each(function () { this.reset() });
	$('#contact-form').submit(function (e) {
		e.preventDefault();
		this.submit();
		setTimeout(function () {
			$('#contact-form')[0].reset();
		}, 100);
		$('#contact_modal').modal('hide');
	});
</script>
<?php include "../includes/analyticstracking.php"; ?>

</body>
</html>
