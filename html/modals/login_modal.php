<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="login_label">Login</h4>
            </div>
            <div class="modal-body">
                <form id="user-login" action="scripts/login.php" method="post">
                    <div class="form-group">
                        <label for="user-name-input">LabNet ID</label>
                        <input name="username" id="user-name-input" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="password-input">Password</label>
                        <input name="password" id="password-input" class="form-control" type="password">
                    </div>
                    <button class="btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
