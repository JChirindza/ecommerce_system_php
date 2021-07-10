var manageCartsTable;
var manageCartItemTable;

$(document).ready(function() {

	manageCartsTable = $('#manageCartsTable').DataTable({
		'ajax' : 'php_action/ctrl_cart.php?action=read',
		'cart': []
	}); // manage cart Data Table
	
	var cartId = $("#cartId").val();
	// manage cart item data table
	manageCartItemTable = $('#manageCartItemTable').DataTable({
		"ajax": {
			"url": 'php_action/ctrl_cart.php?action=readItems',
			"data":{
				"cartId": cartId
			}
		}
	});

	// submit productToCart form function
	$("#submitProductToCartForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var quantity = $("#quantity").val();

		if(quantity == "" && quantity <= 0) {
			$("#quantity").after('<p class="text-danger">Quantity field is required</p>');
			$('#quantity').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#quantity").find('.text-danger').remove();
			// success out for form 
			$("#quantity").closest('.form-group').addClass('has-success');	  	
		}
		
		if(quantity) {
			var form = $(this);
			// button loading
			$("#addToCartBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#addToCartBtn").button('reset');

					if(response.success == true) {
		  	  			// reset the form text
		  	  			$("#submitProductToCartForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');

						$('#add-to-cart-messages').html('<div class="alert-sm alert-success rounded pl-2 pr-2">'+
							'<button type="button" class="close btn btn-sm" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

				} // /success
			}); // /ajax	
		} // if

		return false;
	}); // /submit brand form function
}); // /document