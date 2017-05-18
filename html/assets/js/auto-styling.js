$(document).ready(function () {
	$(".side_tab").click(function () {
		$(".side_tab").removeClass("active");
		$(this).addClass("active");
	});
});

$(document).ready(function () {
	var email_regex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i

	$('#email-input').bind('input propertychange', function () {
		if (email_regex.test($(this).val())) {
			$(this).css({ 'border-color': 'green' });
			$('#contact-submit-button').prop("disabled", false);
		} else {
			$(this).css({ 'border-color': 'red' });
			$('#contact-submit-button').prop("disabled", true);
		}
	});
});

$(document).on('keyup', '#message-input', function (e) {
	this.style.overflow = 'hidden';
    var $old_height = this.style.height;
    this.style.height = 0;
    if (this.scrollHeight <= 100) {
        this.style.height = this.scrollHeight + 'px';
    } else {
        this.style.height = $old_height;
    }
});

function expand_text_area(id) {
	var $element = $('#'+id);
	
	$element.addEventListener('keyup', function () {
		this.style.overflow = 'hidden';
		var $old_height = this.style.height;
		this.style.height = 0;
		if (this.scrollHeight <= 100) {
			this.style.height = this.scrollHeight + 'px';
		} else {
			this.style.height = $old_height;
		}
	}, false);
}

$(document).ready(function () {
    var name_regex = /^\S*$/; 

    $('#jobname-input').bind('input propertychange', function () {
        if (name_regex.test($(this).val()) && $(this).val().length>0) {
            $(this).css({ 'border-color': 'green' });
            $('#job-submit-button').prop("disabled", false);
        } else {
            $(this).css({ 'border-color': 'red' });
            $('#job-submit-button').prop("disabled", true);
        }
    });
    console.log("third to last one is working");
});
$(document).ready(function () {
    var name_regex = /^\S*$/;
    $('#exe-input').bind('input propertychange', function () {
        if ($(this).val().length>0 && name_regex.test($(this).val())) {
            $(this).css({ 'border-color': 'green' });
            $('#job-submit-button').prop("disabled", false);
        } else {
            $(this).css({ 'border-color': 'red' });
            $('#job-submit-button').prop("disabled", true);
        }
    });
	console.log("second to last one is working");
});
$(document).ready(function () {   
    $('#desc-input').bind('input propertychange', function () {
        if ($(this).val().length>0) {
            $(this).css({ 'border-color': 'green' });
            $('#job-submit-button').prop("disabled", false);
        } else {
            $(this).css({ 'border-color': 'red' });
            $('#job-submit-button').prop("disabled", true);
        }
    });
    console.log("last one is working");
});

