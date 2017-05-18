<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
                <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./index.php">LabGrid</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="dashboard.php">Dashboard</a></li>
				<li><a href="about.php">About</a></li>
                <li><a href="help.php">Help</a></li>
				<?php
				include_once "../php-security/db_connect.php";
				include_once "../php-security/security_functions.php";				
				if (check_login($db_connection)) { ?><li>
					<a href="#" data-toggle="dropdown" class="dropdown-toggle" id="account-info">Your Account</a>
					<ul class="dropdown-menu" aria-labelledby="account-info">
						<li><a href="#">Active Jobs</a></li>
						<li><a href="#">Settings</a></li>
						<li><a href="scripts/logout.php">Logout</a></li>
					</ul>
				</li>
				<li><a href="#" data-toggle="modal" data-target="#submit_job_modal">Submit A Job (Under Construction)</a></li>
				<?php
				} else {
					echo '<li><a href="#" data-toggle="modal" data-target="#login_modal">Login</a></li>';
				}
				?>
				<li><a href="#" data-toggle="modal" data-target="#contact_modal">Contact</a></li>
			</ul>
			<!--<form class="navbar-form navbar-right" id="foo">
                <input type="text" class="form-control" placeholder="Search...">
            </form>-->
		</div>
	</div>
</nav>
<?php include_once "modals/submit_job_modal.php"; ?>
<?php include_once "modals/login_modal.php"; ?>
<?php include_once "modals/contact_modal.php"; ?>
