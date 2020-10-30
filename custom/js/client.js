var manageClientTable;

$(document).ready(function() {
	// top nav bar 
	$('#navClient').addClass('active');
	// manage product data table
	manageClientTable = $('#manageClientTable').DataTable({
		'ajax': 'php_action/fetchClient.php',
		'order': []
	});

	// add product modal btn clicked
	$("#addClientModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitClientForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$("#clientImage").fileinput({
	      overwriteInitial: true,
		    maxFileSize: 2500,
		    showClose: false,
		    showCaption: false,
		    browseLabel: '',
		    removeLabel: '',
		    browseIcon: '<i class="fas fa-folder-open"></i>',
		    removeIcon: '<i class="fas fa-times"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-1',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	  		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
			});   

		// submit product form
		$("#submitClientForm").unbind('submit').bind('submit', function() {
			// form validation
			var name = $("#clientName").val();
			var surname = $("#clientSurname").val();
			var contact = $("#clientContact").val();

			if(name == "") {
				$("#clientName").after('<p class="text-danger">Client name field is required</p>');
				$('#clientName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#clientName").find('.text-danger').remove();
				// success out for form 
				$("#clientName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(surname == "") {
				$("#clientSurname").after('<p class="text-danger">Surname field is required</p>');
				$('#clientSurname').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#clientSurname").find('.text-danger').remove();
				// success out for form 
				$("#clientSurname").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(contact == "") {
				$("#clientContact").after('<p class="text-danger">Contact field is required</p>');
				$('#clientContact').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#clientContact").find('.text-danger').remove();
				// success out for form 
				$("#clientContact").closest('.form-group').addClass('has-success');	  	
			}	// /else

			
				// /else

			if(name && surname && contact) {
				// submit loading button
				$("#createClientBtn").button('loading');

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
							$("#createClientBtn").button('reset');
							
							$("#submitClientForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																	
							// shows a successful message after operation
							$('#add-client-messages').html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="fas fa-check"></i></strong> '+ response.messages +
		          '</div>');

							// remove the mesages
		          $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

		          // reload the manage student table
							manageClientTable.ajax.reload(null, true);

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

function editClient(clientid = null) {

	if(clientid) {
		$("#clientid").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedClient.php',
			type: 'post',
			data: {"clientid": clientid},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				

			

				// client id 
				$(".editClientFooter").append('<input type="hidden" name="clientid" id="clientid" value="'+response.client_id+'" />');				
				$(".editClientPhotoFooter").append('<input type="hidden" name="clientid" id="clientid" value="'+response.client_id+'" />');				
				
				// name
				$("#editName").val(response.name);
				// surname
				$("#editSurname").val(response.surname);
				// contact
				$("#editContact").val(response.contact);
				
				// update the product data function
				$("#editClientForm").unbind('submit').bind('submit', function() {

					// form validation
					var name = $("#editName").val();
					var surname = $("#editSurname").val();
					var contact = $("#editContact").val();
								

					if(name == "") {
						$("#editName").after('<p class="text-danger">Client Name field is required</p>');
						$('#editName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editName").find('.text-danger').remove();
						// success out for form 
						$("#editName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(surname == "") {
						$("#editSurname").after('<p class="text-danger">client surname field is required</p>');
						$('#editSurname').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editSurname").find('.text-danger').remove();
						// success out for form 
						$("#editSurname").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(contact == "") {
						$("#editContact").after('<p class="text-danger">Client contact field is required</p>');
						$('#editContact').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editContact").find('.text-danger').remove();
						// success out for form 
						$("#editContact").closest('.form-group').addClass('has-success');	  	
					}	// /else
					

					if(name && surname && contact) {
						// submit loading button
						$("#editClientBtn").button('loading');

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
									$("#editClientBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-client-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="fas fa-check"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageClientTable.ajax.reload(null, true);

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // update the product data function

				// update the product image				
				$("#updateClientImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var clientImage = $("#editClientImage").val();					
					
					if(clientImage == "") {
						$("#editClientImage").closest('.center-block').after('<p class="text-danger">Client Image field is required</p>');
						$('#editClientImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editClientImage").find('.text-danger').remove();
						// success out for form 
						$("#editClientImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(clientImage) {
						// submit loading button
						$("#editClientImageBtn").button('loading');

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
									$("#editClientImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-productPhoto-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="fas fa-check"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageClientTable.ajax.reload(null, true);

									$(".fileinput-remove-button").click();

									$.ajax({
										url: 'php_action/fetchClientImageUrl.php?i='+clientid,
										type: 'post',
										success:function(response) {
										$("#getClientImage").attr('src', response);		
										}
									});																		

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // /update the product image

			} // /success function
		}); // /ajax to fetch product image

				
	} else {
		alert('error please refresh the page');
	}
} // /edit product function

// remove product 
function removeClient(clientid = null) {
	if(clientid) {
		// remove product button clicked
		$("#removeClientBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeClientBtn").button('loading');
			$.ajax({
				url: 'php_action/removeClient.php',
				type: 'post',
				data: {clientid: clientid},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeClientBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeClientModal").modal('hide');

						// update the product table
						manageClientTable.ajax.reload(null, false);

						// remove success messages
						$(".remove-messages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="fas fa-check"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} else {

						// remove success messages
						$(".removeClientMessages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="fas fa-check"></i></strong> '+ response.messages +
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
	} // /if clientid
} // /remove product function

function clearForm(oForm) {
	// var frm_elements = oForm.elements;									
	// console.log(frm_elements);
	// 	for(i=0;i<frm_elements.length;i++) {
	// 		field_type = frm_elements[i].type.toLowerCase();									
	// 		switch (field_type) {
	// 	    case "text":
	// 	    case "password":
	// 	    case "textarea":
	// 	    case "hidden":
	// 	    case "select-one":	    
	// 	      frm_elements[i].value = "";
	// 	      break;
	// 	    case "radio":
	// 	    case "checkbox":	    
	// 	      if (frm_elements[i].checked)
	// 	      {
	// 	          frm_elements[i].checked = false;
	// 	      }
	// 	      break;
	// 	    case "file": 
	// 	    	if(frm_elements[i].options) {
	// 	    		frm_elements[i].options= false;
	// 	    	}
	// 	    default:
	// 	        break;
	//     } // /switch
	// 	} // for
}