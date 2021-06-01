var manageSubcategoriesTable;

$(document).ready(function() {
	// top nav bar 
	$('#navSubcategories').addClass('active');

	var categories_id = $("#categoryId").val();

	// manage product details data table
	manageSubcategoriesTable = $('#manageSubcategoriesTable').DataTable({
		"ajax": {
			"url": 'php_action/fetchSubcategories.php',
			"data":{
				"categories_id": categories_id
			}
		}
	});

	// add product modal btn clicked
	$("#addSubcategoryModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitSubcategoryForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		// submit product form
		$("#submitSubcategoryForm").unbind('submit').bind('submit', function() {

			// remove text-error 
			$(".text-danger").remove();
			// remove from-group error
			$(".form-group").removeClass('has-error').removeClass('has-success');

			// form validation
			var subcategoryName = $("#subcategoryName").val();
			var subcategoryStatus = $("#subcategoryStatus").val();

			if(subcategoryName == "") {
				$("#subcategoryName").after('<p class="text-danger">Subcategory name field is required</p>');
				$('#subcategory_name').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#subcategoryName").find('.text-danger').remove();
				// success out for form 
				$("#subcategoryName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(subcategoryStatus == "") {
				$("#subcategoryStatus").after('<p class="text-danger">Subcategory status field is required</p>');
				$('#subcategoryStatus').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#subcategoryStatus").find('.text-danger').remove();
				// success out for form 
				$("#subcategoryStatus").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(subcategoryName && subcategoryStatus) {
				// submit loading button
				$("#createSubcategoryBtn").button('loading');

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
							$("#createSubcategoryBtn").button('reset');
							
							$("#submitSubcategoryForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

							// shows a successful message after operation
							$('#add-subcategory-messages').html('<div class="alert alert-success">'+
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
				          	manageSubcategoriesTable.ajax.reload(null, true);

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

function editSubcategory(subcategoryId = null) {

	if(subcategoryId) {
		$("#subcategoryId").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedSubcategory.php',
			type: 'post',
			data: {subcategoryId: subcategoryId},
			dataType: 'json',
			success:function(response) {		
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				


				// product detail id 
				$(".editSubcategoryFooter").append('<input type="hidden" name="subcategoryId" id="subcategoryId" value="'+response.sub_category_id+'" />');				
				
				// subcategory name
				$("#editSubcategoryName").val(response.sub_category_name);
				// status
				$("#editSubcategoryStatus").val(response.active);

				// update the product data function
				$("#editSubcategoryForm").unbind('submit').bind('submit', function() {

					// form validation
					var subcategoryName = $("#editSubcategoryName").val();
					var subcategoryStatus = $("#editSubcategoryStatus").val();

					if(subcategoryName == "") {
						$("#editSubcategoryName").after('<p class="text-danger">Subcategory name field is required</p>');
						$('#editSubcategoryName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editSubcategoryName").find('.text-danger').remove();
						// success out for form 
						$("#editSubcategoryName").closest('.form-group').addClass('has-success');	  	
					}	// /else
					
					if(subcategoryStatus == "") {
						$("#editSubcategoryStatus").after('<p class="text-danger">Subcategory status field is required</p>');
						$('#editSubcategoryStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editSubcategoryStatus").find('.text-danger').remove();
						// success out for form 
						$("#editSubcategoryStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(subcategoryName && subcategoryStatus) {
						// submit loading button
						$("#editSubcategoryBtn").button('loading');

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
									$("#editSubcategoryBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

									// shows a successful message after operation
									$('#edit-subcategory-messages').html('<div class="alert alert-success">'+
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
							        manageSubcategoriesTable.ajax.reload(null, true);

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
function removeSubcategory(subcategoryId = null) {
	if(subcategoryId) {
		// remove product button clicked
		$("#removeSubcategoryBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeSubcategoryBtn").button('loading');
			$.ajax({
				url: 'php_action/removeSubcategory.php',
				type: 'post',
				data: {subcategoryId: subcategoryId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeSubcategoryBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeSubcategoryModal").modal('hide');

						// update the product details table
						manageSubcategoriesTable.ajax.reload(null, false);

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
						$(".removeSubcategoryMessages").html('<div class="alert alert-success">'+
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