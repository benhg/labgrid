<div class="modal fade" id="contact_modal" tabindex="-1" role="dialog" aria-labelledby="contact_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="contact_label">Contact Us</h4>
            </div>
            <div class="modal-body">
                <form id="contact-form" class="form-horizontal" action="scripts/contact.php" method="post">
                    <div class="form-group">
                        <label for="name-input" class="control-label col-lg-3">Your Name</label>
                        <div class="col-lg-8">
                            <input name="name" id="name-input" class="form-control" type="text" placeholder="First and Last">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-input" class="control-label col-lg-3">Email</label>
                        <div class="col-lg-8">
                            <input name="email" id="email-input" class="form-control" type="email" placeholder="jsmith@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-input" class="control-label col-lg-3">Message</label>
                        <div class="col-lg-8">
                            <textarea name="message" id="message-input" class="form-control" rows="1" placeholder="Message Body"></textarea>
                        </div>
                    </div>
					<div class="form-group">
						<label for="human-confirmation" class="control-label col-lg-3">Confirm</label>
						<div class="col-lg-8">
							<div id="human-confirmation"></div>
							
							</div>
					</div>
                    <div class="form-group">
                        <div class="col-sm-10 col-lg-offset-3">
                            <input id="contact-submit-button" type="submit" name="submit-button" class="btn btn-success" value="Send" disabled="true">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
