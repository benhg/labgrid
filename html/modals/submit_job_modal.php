<div class="modal fade" id="submit_job_modal" tabindex="-1" role="dialog" aria-labelledby="submit_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="submit_label">Submit A Job</h4>
            </div>
            <div class="modal-body">
                <form id="submit-form" class="form-horizontal" action="./scripts/submit_job.php" method="post" enctype='multipart/form-data'>
                    <div class="form-group">
                    <link rel="stylesheet" href="../assets/css/submit.css">
                       <div class="helpnote" id="helpnote">Before you submit a job, please MAKE SURE you have read our help page <a href="help.php">Here.</a> Thanks!</div>
                        <label for="jobname-input" class="control-label col-lg-3">Job Name</label>
                        <div class="col-lg-8">
                            <input name="jobname" id="jobname-input" class="form-control" type="text" placeholder="mycooljob">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exe-input" class="control-label col-lg-3">Name of Executable</label>
                        <div class="col-lg-8">
                            <input name="exe" id="exe-input" class="form-control" type="exe" placeholder="mycooljob.py">
                        </div>
                    </div>
                    <div class="form-group">
						<label for="size-input" class="control-label col-lg-3">Size(number of simultaneous jobs)</label>
						<div class="col-lg-8">
							<select name="size-input" class="form-control" id="size-input" type="size">
								<?php
                                    for ($i=1; $i <11 ; $i++) {
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }
                                ?>
							</select>
						</div>
                    </div>
                     <div class="form-group">
                        <label for="desc-input" class="control-label col-lg-3">Description</label>
                        <div class="col-lg-8">
                            <input name="desc" id="desc-input" class="form-control" type="desc" placeholder="Adds Numbers">
                        </div>
                    </div>
                    <div class="form-group">  
	                    <label for="file-input" class="control-label col-lg-3">File Upload</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <input name="uploaded_file" type="file" class="btn col-lg-8"/>
                        <!--<input type="submit" value="file" />-->
                    </div>
                    <div class="form-group">
                        <label for="human-confirmation-1" class="control-label col-lg-3">Confirm</label>
                        <div class="col-lg-8">
                            <div id="human-confirmation-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-lg-offset-3">
                            <input id="job-submit-button" type="submit" name="submit-button" class="btn btn-success" value="Submit" disabled="true">
							<!--<script type="text/javascript">
								$(document).ready(function() {
									$('#reject').click(function() {
										$("#delete_dialog").dialog("close");
									});
								});
							</script>-->
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
