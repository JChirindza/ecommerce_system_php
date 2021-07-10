$(document).ready(function() {
	// main menu
	$("#navSetting").addClass('active');
	// sub manin
	$("#topNavSetting").addClass('active');

	// change username
	$("#changeUsernameForm").unbind('submit').bind('submit', function() {
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var form = $(this);

		var name = $("#name").val();
		var surname = $("#surname").val();

		if(name == "" || surname == "") {
			if(name == "") {
				$("#name").after('<p class="text-danger">Name field is required</p>');
				$("#name").closest('.form-group').addClass('has-error');
			}else{
				$("#name").closest('.form-group').removeClass('has-error');
				$(".text-danger").remove();
			}

			if(surname == "") {
				$("#surname").after('<p class="text-danger">Surname field is required</p>');
				$("#surname").closest('.form-group').addClass('has-error');
			}else{
				$("#surname").closest('.form-group').removeClass('has-error');
				$(".text-danger").remove();
			}
		} else {

			$(".text-danger").remove();
			$('.form-group').removeClass('has-error');

			$("#changeUsernameBtn").button('loading');

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {

					$("#changeUsernameBtn").button('reset');
					// remove text-error 
					$(".text-danger").remove();
					// remove from-group error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					if(response.success == true)  {												

						// shows a successful message after operation
						$('.changeUsernameMessages').html('<div class="alert alert-success">'+
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
						$('.changeUsernameMessages').html('<div class="alert alert-warning">'+
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

	// change email
	$("#changeEmailForm").unbind('submit').bind('submit', function() {
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var form = $(this);

		var email = $("#email").val();

		if(email == "") {
			$("#email").after('<p class="text-danger">Email field is required</p>');
			$("#email").closest('.form-group').addClass('has-error');
		} else {

			$(".text-danger").remove();
			$('.form-group').removeClass('has-error');

			$("#changeEmailBtn").button('loading');

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {

					$("#changeEmailBtn").button('reset');
					// remove text-error 
					$(".text-danger").remove();
					// remove from-group error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					if(response.success == true)  {												

						// shows a successful message after operation
						$('.changeEmailMessages').html('<div class="alert alert-success">'+
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
						$('.changeEmailMessages').html('<div class="alert alert-warning">'+
							'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							'<strong><i class="fas fa-exclamation"></i></strong> '+ response.messages +
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

	$("#changePasswordForm").unbind('submit').bind('submit', function() {

		var form = $(this);

		$(".text-danger").remove();

		var currentPassword = $("#password").val();
		var newPassword = $("#npassword").val();
		var conformPassword = $("#cpassword").val();

		if(currentPassword == "" || newPassword == "" || conformPassword == "") {
			if(currentPassword == "") {
				$("#password").after('<p class="text-danger">The Current Password field is required</p>');
				$("#password").closest('.form-group').addClass('has-error');
			} else {
				$("#password").closest('.form-group').removeClass('has-error');
				$(".text-danger").remove();
			}

			if(newPassword == "") {
				$("#npassword").after('<p class="text-danger">The New Password field is required</p>');
				$("#npassword").closest('.form-group').addClass('has-error');
			} else {
				$("#npassword").closest('.form-group').removeClass('has-error');
				$(".text-danger").remove();
			}

			if(conformPassword == "") {
				$("#cpassword").after('<p class="text-danger">The Conform Password field is required</p>');
				$("#cpassword").closest('.form-group').addClass('has-error');
			} else {
				$("#cpassword").closest('.form-group').removeClass('has-error');
				$(".text-danger").remove();
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					console.log(response);
					if(response.success == true) {
						$('.changePasswordMessages').html('<div class="alert alert-success">'+
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

						$('.changePasswordMessages').html('<div class="alert alert-warning">'+
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
				} // /success function
			}); // /ajax function

		} // /else


		return false;
	});

	// update the user image				
	// $("#updateUserImageForm").unbind('submit').bind('submit', function() {					
		var userid = $("#user_id").val();

		// userid = 2;
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

					// $("#getUserImage").attr('src', 'users/'+response.user_image);
					setUserImage(userid);	
					$("#editUserImage").fileinput({		      
					});		

					// user id 
					$(".editUserFooter").append('<input type="hidden" name="userid" id="userid" value="'+response.user_id+'" />');				
					$(".editUserPhotoFooter").append('<input type="hidden" name="userid" id="userid" value="'+response.user_id+'" />');				

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
											setUserImage(userid);
										}); // /.alert

							          	// reload the manage student table
							          	manageUserTable.ajax.reload(null, true);

							          	$(".fileinput-remove-button").click();

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
		}
	// }); // /update the product image
}); // /document

function setUserImage(userid = null){

	if(userid) {
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
				$("#getUserImageNav").attr('src', 'users/'+response.user_image);
			} // /success function
		}); // /ajax to fetch product image

		// reset the form text
		$("#updateUserImageForm")[0].reset();
	}
}