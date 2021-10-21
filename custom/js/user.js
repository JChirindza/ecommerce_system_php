var manageUserTable;

$(document).ready(function() {

	setUserCounter();

	// top nav bar 
	$('#navUser').addClass('active');
	// manage product data table
	manageUserTable = $('#manageUserTable').DataTable({
		'ajax': 'php_action/ctrl_user.php?action=read',
		'order': []
	});

	// add product modal btn clicked
	$("#addUserModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitUserForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$("#userImage").fileinput({
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
		$("#submitUserForm").unbind('submit').bind('submit', function() {
			// form validation
			var name = $("#userName").val();
			var surname = $("#userSurname").val();
			var useremail = $("#uemail").val();
			var upassword = $("#upassword").val();
			var userPermittion = $("#permittion").val();

			if(name == "") {
				$("#userName").after('<p class="text-danger">Name field is required</p>');
				$('#name').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#serName").find('.text-danger').remove();
				// success out for form 
				$("#serName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(surname == "") {
				$("#userSurname").after('<p class="text-danger"> Surname field is required</p>');
				$('#surname').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#userSurname").find('.text-danger').remove();
				// success out for form 
				$("#userSurname").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(useremail == "") {
				$("#uemail").after('<p class="text-danger">Email field is required</p>');
				$('#uemail').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#uemail").find('.text-danger').remove();
				// success out for form 
				$("#uemail").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(upassword == "") {
				$("#upassword").after('<p class="text-danger">Password field is required</p>');
				$('#upassword').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#upassword").find('.text-danger').remove();
				// success out for form 
				$("#upassword").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(userPermittion == "") {
				$("#permittion").after('<p class="text-danger">User access type field is required</p>');
				$('#permittion').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#permittion").find('.text-danger').remove();
				// success out for form 
				$("#permittion").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(name && surname && useremail && upassword && userPermittion) {
				// submit loading button
				$("#createUserBtn").button('loading');

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
							$("#createUserBtn").button('reset');
							
							$("#submitUserForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

							// shows a successful message after operation
							$('#add-user-messages').html('<div class="alert alert-success">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
								'</div>');

							// remove the mesages
							$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

							// reload userCount
				          	setUserCounter();

				          	// reload the manage student table
				          	manageUserTable.ajax.reload(null, true);

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

function editUser(userid = null) {

	if(userid) {
		$("#userid").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/ctrl_user.php?action=readSelected',
			type: 'post',
			data: {"userid": userid},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');		

				$("#getUserImage").attr('src', 'users/'+response.user_image);

				$("#editUserImage").fileinput({		      
				});		

				// user id 
				$(".editUserFooter").append('<input type="hidden" name="userid" id="userid" value="'+response.user_id+'" />');				
				$(".editUserPhotoFooter").append('<input type="hidden" name="userid" id="userid" value="'+response.user_id+'" />');				
				
				// name
				$("#editName").val(response.name);
				//  Surname
				$("#editSurname").val(response.surname);
				// user email
				$("#editEmail").val(response.email);
				// password
				// $("#editPassword").val(response.password);
				// status
				$("#editPermittion").val(response.permittion);
				// status
				$("#editUserStatus").val(response.active);
				
				// update the product data function
				$("#editUserForm").unbind('submit').bind('submit', function() {

					// form validation
					var userImage = $("#editUserImage").val();
					var name = $("#editName").val();
					var surname = $("#editSurname").val();
					var useremail = $("#editEmail").val();
					// var userpassword = $("#editPassword").val();
					var userImage = $("#editUserImage").val();
					var userStatus = $("#editUserStatus").val();


					if(name == "") {
						$("#editName").after('<p class="text-danger">Name field is required</p>');
						$('#editName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editName").find('.text-danger').remove();
						// success out for form 
						$("#editName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(surname == "") {
						$("#editSurname").after('<p class="text-danger">Surname field is required</p>');
						$('#editSurname').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editSurname").find('.text-danger').remove();
						// success out for form 
						$("#editSurname").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(useremail == "") {
						$("#editEmail").after('<p class="text-danger">Email field is required</p>');
						$('#editEmail').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editEmail").find('.text-danger').remove();
						// success out for form 
						$("#editEmail").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(userImage == "") {
						$("#userImage").closest('.center-block').after('<p class="text-danger">User Image field is required</p>');
						$('#productImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#userImage").find('.text-danger').remove();
						// success out for form 
						$("#userImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(userStatus == "") {
						$("#editUserStatus").after('<p class="text-danger">User Status field is required</p>');
						$('#editUserStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editUserStatus").find('.text-danger').remove();
						// success out for form 
						$("#editUserStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else


					if(name && surname && useremail && userStatus) {
						// submit loading button
						$("#editUserBtn").button('loading');

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
									$("#editUserBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

									// shows a successful message after operation
									$('#edit-user-messages').html('<div class="alert alert-success">'+
										'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
										'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
										'</div>');

									// remove the mesages
									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

									// reload setUserCounter
									setUserCounter();

							        // reload the manage student table
							        manageUserTable.ajax.reload(null, true);

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
				$("#updateUserImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var userImage = $("#editUserImage").val();					
					
					if(userImage == "") {
						$("#editUserImage").closest('.center-block').after('<p class="text-danger">User Image field is required</p>');
						$('#editUserImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editUserImage").find('.text-danger').remove();
						// success out for form 
						$("#editUserImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(userImage) {
						// submit loading button
						$("#editUserImageBtn").button('loading');

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
									$("#editUserImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

									// shows a successful message after operation
									$('#edit-userPhoto-messages').html('<div class="alert alert-success">'+
										'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
										'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
										'</div>');

									// remove the mesages
									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

						          	// reload the manage student table
						          	manageUserTable.ajax.reload(null, true);

						          	$(".fileinput-remove-button").click();

						          	$.ajax({
						          		url: 'php_action/ctrl_user.php?action=readImageUrl&i='+userid,
						          		type: 'post',
						          		success:function(response) {
						          			$("#getUserImage").attr('src', response);		
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
function removeUser(userid = null) {
	if(userid) {
		// remove product button clicked
		$("#removeProductBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeUserBtn").button('loading');
			$.ajax({
				url: 'php_action/ctrl_user.php?action=delete',
				type: 'post',
				data: {userid: userid},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeUserBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeUserModal").modal('hide');

						// update the product table
						manageUserTable.ajax.reload(null, false);

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

						// reload userCount
						setUserCounter();
					} else {

						// remove success messages
						$(".removeUserMessages").html('<div class="alert alert-success">'+
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
	} // /if userid
} // /remove product function

function setUserCounter() {

	$.ajax({
		url : 'php_action/ctrl_user.php?action=readCounters', 
		type: 'post',
		dataType: 'json',
		success:function(response) {	
			$('#totalUsers').text(response.totalUsers);
			$('#totalUsersActive').text(response.totalUsersActive);
			$('#totalEmployees').text(response.totalEmployees);
			$('#totalEmployeesActive').text(response.totalEmployeesActive);
			$('#totalClients').text(response.totalClients);
			$('#totalClientsActive').text(response.totalClientsActive);
		} // /success function
	});
}