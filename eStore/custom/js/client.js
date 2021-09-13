$(document).ready(function() {

	// change client data
	$("#changeClientContactForm").unbind('submit').bind('submit', function() {
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var form = $(this);

		var contact = $("#contact").val();

		if(contact == "") {
			$("#contact").after('<p class="text-danger">Contact field is required</p>');
			$("#contact").closest('.form-group').addClass('has-error');
		} else {

			$("#contact").closest('.form-group').removeClass('has-error');
			$(".text-danger").remove();

			$(".text-danger").remove();
			$('.form-group').removeClass('has-error');

			$("#updateContactBtn").button('loading');

			$.ajax({
				url: 'php_action/ctrl_client.php?action=editContact',
				type: 'post',
				data: {"contact": contact},
				dataType: 'json',
				success:function(response) {

					$("#updateContactBtn").button('reset');
					// remove text-error 
					$(".text-danger").remove();
					// remove from-group error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					if(response.success == true)  {												

						// shows a successful message after operation
						$('.updateContactMessages').html('<div class="alert-sm alert-success rounded pl-2 pr-2">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          					

						// Reset client contact
						$('#client_payment_contact').text(contact);
					} else {
						// shows a successful message after operation
						$('.updateContactMessages').html('<div class="alert alert-warning">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-exclamation-sign"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          					
					}
				} // /success 
			}); // /ajax
		}

		return false;
	});

});