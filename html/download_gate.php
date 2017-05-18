<html>
<head>
    <!-- JQuery and Styles -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="col-sm-4 col-sm-offset-4">
        <h4 class="page-header">Welcome to the LabGrid Download Portal</h4>
        <div class="row">
            <div class="col-sm-4">Job ID:</div>
            <div class="col-sm-8"><?php echo $_GET['job_id']; ?></div>
        </div>
        <div class="row">
            <div class="col-sm-4">Job Name:</div>
            <div class="col-sm-8"><?php echo $_GET['job_name']; ?></div>
        </div>
    </div>
    <form id="user-login" action="./download.php" method="post" class="col-sm-4 col-sm-offset-4">
        <div class="form-group">
            <label for="user-name-input">LabNet ID</label>
            <input name="username" id="user-name-input" class="form-control" type="text">
        </div>
        <div class="form-group">
            <label for="password-input">Password</label>
            <input name="password" id="password-input" class="form-control" type="password">
        </div>
        <input name="job_id" id="job_id" type="hidden" value="<?php echo $_GET['job_id']; ?>" class="form-control">
        <input name="job_name" id="job_name" type="hidden" value="<?php echo $_GET['job_name']; ?>" class="form-control">
        <button class="btn">Submit</button>
    </form>
</body>
</html>
