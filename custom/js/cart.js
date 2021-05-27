var manageCartsTable;
var manageCartItemTable;

$(document).ready(function() {

	manageCartsTable = $('#manageCartsTable').DataTable({
		'ajax' : 'php_action/fetchCart.php',
		'cart': []
	}); // manage cart Data Table
	
	var cartId = $("#cartId").val();
	// manage cart item data table
	manageCartItemTable = $('#manageCartItemTable').DataTable({
		"ajax": {
			"url": 'php_action/fetchCartItem.php',
			"data":{
				"cartId": cartId
			}
		}
	});
}); // /document


// remove cart from server
function removeCart(cartId = null) {
	if(cartId) {
		$("#removeCartBtn").unbind('click').bind('click', function() {
			$("#removeCartBtn").button('loading');

			$.ajax({
				url: 'php_action/removeCart.php',
				type: 'post',
				data: {cartId : cartId},
				dataType: 'json',
				success:function(response) {
					$("#removeCartBtn").button('reset');

					if(response.success == true) {

						manageCartsTable.ajax.reload(null, false);
						// hide modal
						$("#removeCartModal").modal('hide');
						// success messages
						$("#success-messages").html('<div class="alert alert-success">'+
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
						// error messages
						$(".removeCartMessages").html('<div class="alert alert-warning">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else

				} // /success
			});  // /ajax function to remove the cart

		}); // /remove cart button clicked
		

	} else {
		alert('error! refresh the page again');
	}
}
// /remove cart from server

// remove cartItem from server
function removeCartItem(cartItemId = null) {
	if(cartItemId) {
		$("#removeCartItemBtn").unbind('click').bind('click', function() {
			$("#removeCartItemBtn").button('loading');

			$.ajax({
				url: 'php_action/removeCartItem.php',
				type: 'post',
				data: {cartItemId : cartItemId},
				dataType: 'json',
				success:function(response) {
					$("#removeCartItemBtn").button('reset');

					if(response.success == true) {

						manageCartItemTable.ajax.reload(null, false);
						// hide modal
						$("#removeCartItemModal").modal('hide');
						// success messages
						$("#success-messages").html('<div class="alert alert-success">'+
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
						// error messages
						$(".removeCartItemMessages").html('<div class="alert alert-warning">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else
				} // /success
			});  // /ajax function to remove the cart

		}); // /remove cartItem button clicked
	} else {
		alert('error! refresh the page again');
	}
}
// /remove cartItem from server