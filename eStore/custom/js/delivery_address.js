$(document).ready(function() {

	// Set Delivery Address
	SetDeliveryAddress();

	// create / update Delivery address btn clicked
	$("#updateAddressBtn").unbind('click').bind('click', function() {
		// submit productToCart form function
		$("#submitDeliveryAddressForm").unbind('submit').bind('submit', function() {
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');			

			// var country = $("#country").val();
			var province = $("#province").val();
			var address = $("#address").val();
			var referencePoint = $("#referencePoint").val();
			var postalCode = $("#postalCode").val();

			// if(country == "") {
			// 	$("#country").after('<p class="text-danger">Country field is required</p>');
			// 	$('#country').closest('.form-group').addClass('has-error');
			// } else {
			// 	// remov error text field
			// 	$("#country").find('.text-danger').remove();
			// 	// success out for form 
			// 	$("#country").closest('.form-group').addClass('has-success');	  	
			// }

			if(province == "") {
				$("#province").after('<p class="text-danger">Province field is required</p>');
				$('#province').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#province").find('.text-danger').remove();
				// success out for form 
				$("#province").closest('.form-group').addClass('has-success');	  	
			}

			if(address == "") {
				$("#address").after('<p class="text-danger">Address field is required</p>');
				$('#address').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#address").find('.text-danger').remove();
				// success out for form 
				$("#address").closest('.form-group').addClass('has-success');	  	
			}

			if(referencePoint == "") {
				$("#referencePoint").after('<p class="text-danger">Reference point field is required</p>');
				$('#referencePoint').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#referencePoint").find('.text-danger').remove();
				// success out for form 
				$("#referencePoint").closest('.form-group').addClass('has-success');	  	
			}

			if(postalCode == "") {
				$("#postalCode").after('<p class="text-danger">Postal code field is required</p>');
				$('#postalCode').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#postalCode").find('.text-danger').remove();
				// success out for form 
				$("#postalCode").closest('.form-group').addClass('has-success');	  	
			}
			
			if(province && address && referencePoint && postalCode) {
				var form = $(this);
				var formData = new FormData(this);
				// button loading
				$("#updateAddressBtn").button('loading');

				console.log("ccccccccc");
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {
						// button loading
						$("#updateAddressBtn").button('reset');

						if(response.success == true)  {			

							// shows a successful message after operation
							$('.updateDeliveryAddressMessages').html('<div class="alert-sm alert-success rounded pl-2 pr-2">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
								'</div>');

							// remove the mesages
							$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert	          					

						} else {

							// shows a successful message after operation
							$('.updateDeliveryAddressMessages').html('<div class="alert alert-warning">'+
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
			} // if

			return false;
		}); // /submit form
	}); // /update delivery address btn clicked
}); // document.ready fucntion

function SetDeliveryAddress() {
	$.ajax({
		url: 'php_action/ctrl_delivery_address.php?action=read',
		dataType: 'json',
		success:function(response) {
			// setting the delivery address data 
			$('#country').val(response.country);
			$('#province').val(response.province);
			$('#address').val(response.address);
			$('#referencePoint').val(response.reference_point);
			$('#postalCode').val(response.postal_code);
		} // /success
	}); // ajax function
}