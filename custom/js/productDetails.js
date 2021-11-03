var manageProductDetailsTable;

$(document).ready(function() {
	// top nav bar 
	$('#navProduct').addClass('active');

	var product_id = $("#productId").val();

	// Set product data
	setProductInfo(product_id);

	// manage product details data table
	manageProductDetailsTable = $('#manageProductDetailsTable').DataTable({
		"ajax": {
			"url": 'php_action/ctrl_productDetail.php?action=read',
			"data":{
				"product_id": product_id
			}
		}
	});

	// add product modal btn clicked
	$("#addProductDetailsModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitProductDetailsForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');


		// submit product form
		$("#submitProductDetailsForm").unbind('submit').bind('submit', function() {

			// remove text-error 
			$(".text-danger").remove();
			// remove from-group error
			$(".form-group").removeClass('has-error').removeClass('has-success');

			// form validation
			var productDetail = $("#productDetail").val();
			var productDescription = $("#detailDescription").val();
			var productDetailStatus = $("#productDetailStatus").val();


			if(productDetail == "") {
				$("#productDetail").after('<p class="text-danger">Product detail field is required</p>');
				$('#productDetail').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productDetail").find('.text-danger').remove();
				// success out for form 
				$("#productDetail").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productDescription == "") {
				$("#detailDescription").after('<p class="text-danger">Product detail descriprion field is required</p>');
				$('#detailDescription').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#detailDescription").find('.text-danger').remove();
				// success out for form 
				$("#detailDescription").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productDetailStatus == "") {
				$("#productDetailStatus").after('<p class="text-danger">Product detail status field is required</p>');
				$('#productDetailStatus').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productDetailStatus").find('.text-danger').remove();
				// success out for form 
				$("#productDetailStatus").closest('.form-group').addClass('has-success');	  	
			}	// /else



			if(productDetail && productDescription && productDetailStatus) {
				// submit loading button
				$("#createProductDetailBtn").button('loading');

				var form = $(this);
				var formData = new FormData(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {

						if(response.success == true) {
							// submit loading button
							$("#createProductDetailBtn").button('reset');
							
							$("#submitProductDetailsForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

							// shows a successful message after operation
							$('#add-product-detail-messages').html('<div class="alert alert-success">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
								'</div>');

							// remove the mesages
							$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

				          	// reload the manage product details table
				          	manageProductDetailsTable.ajax.reload(null, true);

							// remove text-error 
							$(".text-danger").remove();
							// remove from-group error
							$(".form-group").removeClass('has-error').removeClass('has-success');

						} // /if response.success
						
					} // /success function
				}); // /ajax function
			}	 // /if validation is ok 					

			return false;
		}); // /submit product form

	}); // /add product modal btn clicked


	// remove product 	

}); // document.ready fucntion

function editProductDetail(productDetailId = null) {

	if(productDetailId) {
		$("#productDetailId").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/ctrl_productDetail.php?action=readSelected',
			type: 'post',
			data: {productDetailId: productDetailId},
			dataType: 'json',
			success:function(response) {		
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				


				// product detail id 
				$(".editProductDetailFooter").append('<input type="hidden" name="productDetailId" id="productDetailId" value="'+response.id+'" />');				
				
				// product detail
				$("#editProductDetail").val(response.detail);
				// detail description
				$("#editDetailDescription").val(response.description);
				// status
				$("#editDetailStatus").val(response.active);

				// update the product data function
				$("#editProductDetailForm").unbind('submit').bind('submit', function() {

					// form validation
					var productDetail = $("#editProductDetail").val();
					var detailDescription = $("#editDetailDescription").val();
					var detailStatus = $("#editDetailStatus").val();


					if(productDetail == "") {
						$("#editProductDetail").after('<p class="text-danger">Product detail field is required</p>');
						$('#editProductDetail').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductDetail").find('.text-danger').remove();
						// success out for form 
						$("#editProductDetail").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(detailDescription == "") {
						$("#editDetailDescription").after('<p class="text-danger">Detail description field is required</p>');
						$('#editDetailDescription').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editDetailDescription").find('.text-danger').remove();
						// success out for form 
						$("#editDetailDescription").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(detailStatus == "") {
						$("#editDetailStatus").after('<p class="text-danger">Detail status field is required</p>');
						$('#editDetailStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editDetailStatus").find('.text-danger').remove();
						// success out for form 
						$("#editDetailStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productDetail && detailDescription && detailStatus) {
						// submit loading button
						$("#editProductDetailBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								console.log(response);
								if(response.success == true) {
									// submit loading button
									$("#editProductDetailBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

									// shows a successful message after operation
									$('#edit-product-detail-messages').html('<div class="alert alert-success">'+
										'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
										'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
										'</div>');

									// remove the mesages
									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

						          	// reload the manage product table
						          	manageProductDetailsTable.ajax.reload(null, true);

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // update the product detail data function

			} // /success function
		}); // /ajax to fetch product image


} else {
	alert('error please refresh the page');
}
} // /edit product function

// remove product 
function removeProductDetail(productDetailId = null) {
	if(productDetailId) {
		// remove product button clicked
		$("#removeProductDetailBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeProductDetailBtn").button('loading');
			$.ajax({
				url: 'php_action/ctrl_productDetail.php?action=delete',
				type: 'post',
				data: {productDetailId: productDetailId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeProductDetailBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeProductDetailModal").modal('hide');

						// update the product details table
						manageProductDetailsTable.ajax.reload(null, false);

						// remove success messages
						$(".remove-messages").html('<div class="alert alert-success">'+
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

						// remove success messages
						$(".removeProductDetailMessages").html('<div class="alert alert-success">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
							'</div>');

						// remove the mesages
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} // /error
				} // /success function
			}); // /ajax fucntion to remove the product
			return false;
		}); // /remove product btn clicked
	} // /if productDetailId
} // /remove product detail function

function setProductInfo(product_id = null) {
	if(product_id) {
		$.ajax({
			url : 'php_action/ctrl_product.php?action=readProductInfo', 
			type: 'post',
			data: {product_id: product_id},
			dataType: 'json',
			success:function(response) {	
				$('#product_name').text(response.product_name).attr('title', response.product_name);
				$('#product_description').val(response.product_description);
				$('#product_img').attr('src', 'stock/'+response.product_image);
				$('#product_brand').val(response.brand_name);
				$('#product_category').val(response.categories_name);
				$('#product_quantity').val(response.quantity);
				$('#product_rate').val(response.rate);

				if (response.active == 1) {
					$('.product_activ').html('<input type="text" readonly class="form-control border-0 text-success font-weight-bold" id="status" name="status" autocomplete="off" value="Available">');
				}else if (response.active == 2) {
					$('.product_activ').html('<input type="text" readonly class="form-control border-0 text-danger font-weight-bold" id="status" name="status" autocomplete="off" value="Not available">');
				}
			} // /success function
		});
	}

	
}