var manageCartsTable;
var manageCartItemTable;

$(document).ready(function() {

	manageCartsTable = $('#manageCartsTable').DataTable({
		'ajax' : 'php_action/ctrl_cart.php?action=readCart',
		'cart': []
	}); // manage cart Data Table
	
	var cartId = $("#cartId").val();
	setCartTotal();
	// manage cart item data table
	manageCartItemTable = $('#manageCartItemTable').DataTable({
		"ajax": {
			"url": 'php_action/ctrl_cart.php?action=readItems',
			"data":{
				"cartId": cartId
			}
		}
	});

	// add To cart btn clicked
	$("#addToCartBtn").unbind('click').bind('click', function() {
		// submit productToCart form function
		$("#submitProductToCartForm").unbind('submit').bind('submit', function() {
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');			

			var quantity = $("#quantity").val();
			var product_id = $("#product_id").val();

			if(quantity == "" && quantity <= 0) {
				$("#quantity").after('<p class="text-danger">Quantity field is required</p>');
				$('#quantity').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quantity").find('.text-danger').remove();
				// success out for form 
				$("#quantity").closest('.form-group').addClass('has-success');	  	
			}
			
			if(quantity && product_id) {
				var form = $(this);
				var formData = new FormData(this);
				// button loading
				$("#addToCartBtn").button('loading');

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
						$("#addToCartBtn").button('reset');

						if(response.success == true) {
			  	  			// reset the form text
			  	  			$("#submitProductToCartForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

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
			}); // /submit form
	}); // /add product to cart btn clicked
}); // document.ready fucntion


function addProductToCart(productId = null){
	if (productId) {
		var quantity = $("#quantity").val();
		console.log("Available: " + quantity);
		$.ajax({
			url: 'php_action/ctrl_cart.php?action=addToCart',
			type: 'post',
			data: {productId : productId, quantity : quantity},
			dataType: 'json',
			success:function(response) {
				$("#addToCartBtn").button('reset');

				if(response.success == true) {

						// success messages
						$('#add-to-cart-messages_'+productId+'').html('<div class="alert-sm alert-success rounded pl-2 pr-2">'+
							'<button type="button" class="close btn btn-sm" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');
						setCartItemQuantity();
						// remove the mesages
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});

						}); // /.alert	          

					} else {
						// error messages
						$('#add-to-cart-messages_'+productId+'').html('<div class="alert-sm alert-warning rounded pl-2 pr-2">'+
							'<button type="button" class="close btn btn-sm" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else

				} // /success
			});  // /ajax function to remove the cart

		

	} else {
		alert('error! refresh the page again');
	}
}


// update product quantity
function updateItemQuantity(productId = null, row = null){
	
	if (productId && row) {

		var quantity = Number($("#quantity"+row).val());

		$.ajax({
			url: 'php_action/ctrl_cart.php?action=updateQuantity',
			type: 'post',
			data: {productId : productId, quantity: quantity},
			dataType: 'json',
			success:function(response) {
				if(response.success == true) {
						// reload the cart item table 
						manageCartItemTable.ajax.reload(null, true);	
						setCartItemQuantity();
						// success messages
						$('#update-cart-item-messages_'+row+'').html('<div class="alert-sm alert-success rounded pl-2 pr-2">'+
							'<button type="button" class="close btn btn-sm" data-dismiss="alert">&times;</button>'+
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
						$('#update-cart-item-messages_'+row+' ').html('<div class="alert-sm alert-warning rounded pl-2 pr-2">'+
							'<button type="button" class="close btn btn-sm" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else

				} // /success
			});  // /ajax function to remove the cart
	} else {
		alert('error! refresh the page again');
	}
}


// remove cart from server
function removeCart(cartId = null) {
	if(cartId) {
		$("#removeCartBtn").unbind('click').bind('click', function() {
			$("#removeCartBtn").button('loading');

			$.ajax({
				url: 'php_action/ctrl_cart.php?action=deleteCart',
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
				url: 'php_action/ctrl_cart.php?action=deleteItem',
				type: 'post',
				data: {cartItemId : cartItemId},
				dataType: 'json',
				success:function(response) {
					$("#removeCartItemBtn").button('reset');

					if(response.success == true) {
						setCartItemQuantity();   
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

// Pay cart
function pay() {

}


// set cart total Value
function setCartTotal(){
	
	var cartId = $("#cartId").val();

	$.ajax({
		url: 'php_action/ctrl_cart.php?action=readTotalCart',
		type: 'post',
		data: {cartId : cartId},
		dataType: 'json',
		success:function(response) {
			if (Number(response.totalValue)) {
				$('#subTotalValue_cartItem').text(response.totalValue+' Mt'); //table cart item total
			}else{
				$('#subTotalValue_cartItem').text('0.00 Mt'); //table cart item total
			}
		} // /success function
	}); // /ajax to fetch product image
}

// set cart item quantity
function setCartItemQuantity(){
	$.ajax({
		url: 'php_action/ctrl_cart.php?action=readItemQuant',
		type: 'post',
		dataType: 'json',
		success:function(response) {	
			if (Number(response.totalQuantity)) {
				$('#cart_count_items').text(response.totalQuantity); // navbarCartQuantity
			}else{
				$('#cart_count_items').text('0'); // navbarCartQuantity
			}

			// $('#cart_count_items').text(''+response.totalQuantity); // navbarCartQuantity
		} // /success function
	}); // /ajax to fetch product image
	setCartTotal();
}
