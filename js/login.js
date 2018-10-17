$(document).ready(function(){
	$("#login-form").validate({
		submitHandler : function(form) {
		    $('#submit_btn').attr('disabled','disabled');
			$('#submit_btn').button('loading');
			form.submit();
		},
		rules : {
			name : {
				required : true,
				name: true
			},
			pass : {
				required : true
			}
		},
		errorPlacement : function(error, element) {
			$(element).removeClass('has-success').addClass('has-error');
		},
		highlight : function(element) {
			$(element).removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			 $(element).removeClass('has-error').addClass('has-success');
		}
	});
	
	
});