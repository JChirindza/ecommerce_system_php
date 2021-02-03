<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();
?>
<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
	    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Settings</li>
  	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Settings</h1>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card mb-3">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-muted">Alterar Dados</h6>
			</div>

			<div class="card-body">
				<!-- Nav tabs -->
				<div class="form-group ">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#menu1">Alterar Foto</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#menu2">Alterar Nome do usuario</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#menu3">Alterar email</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#menu4">Alterar Senha</a>
						</li>
					</ul>
				</div>
				<!-- Tab panes -->
				<div class="tab-content border border-top-0">
					<div id="menu1" class="tab-pane active" >
						<form action="php_action/editUserImage.php" method="POST" id="updateUserImageForm" class="form-horizontal" enctype="multipart/form-data">

							<div id="edit-userPhoto-messages"></div>

							<div class="form-group">
								<label for="editUserImage" class="col-sm control-label">User Image: </label>
								<div class="col-sm-8">							    				   
									<img src="" id="getUserImage" class="thumbnail border border-info" style="width:200px; height:200px;" />
								</div>
							</div> <!-- /form-group-->	     	           	       

							<div class="form-group">
								<label for="editUserImage" class="col-sm control-label">Select Photo: </label>
								<div class="col-sm-8">
									<!-- the avatar markup -->
									<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
									<div class="kv-avatar center-block">					        
										<input type="file" class="form-control" id="editUserImage" placeholder="User Name" name="editUserImage" class="file-loading" style="width:auto;"/>
									</div>
								</div>
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" />
							</div> <!-- /form-group-->	     	           	       
						</form>
					</div>
					<div id="menu2" class="tab-pane fade" >
						<form action="php_action/changeUsername.php" method="post" class="form-horizontal col-sm-8" id="changeUsernameForm">
							<fieldset >

								<div class="changeUsernameMessages"></div>			

								<div class="form-group">
									<label for="name" class="col-sm control-label">Nome:</label>
									<div class="col-sm-10 mb-3">
										<input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="<?php echo $result['name']; ?>" required/>
									</div>

									<label for="surname" class="col-sm control-label">Apelido:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="surname" name="surname" placeholder="Apelido" value="<?php echo $result['surname']; ?>" required/>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
										<button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"> <i class="fas fa-save"></i> Save Changes </button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>

					<div id="menu3" class="tab-pane fade" >
						<form action="php_action/changeEmail.php" method="post" class="form-horizontal col-sm-8" id="changeEmailForm">
							<fieldset >

								<div class="changeEmailMessages"></div>			

								<div class="form-group">
									<label for="email" class="col-sm control-label">Email:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $result['email']; ?>" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"/>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
										<button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeEmailBtn"> <i class="fas fa-save"></i> Save Changes </button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>

					<div id="menu4" class="tab-pane fade">
						<form action="php_action/changePassword.php" method="post" class="form-horizontal col-sm-8" id="changePasswordForm">
							<fieldset>
								<div class="changePasswordMessages"></div>

								<div class="form-group">
									<label for="password" class="col-sm control-label">Current Password:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="password" name="password" placeholder="Current Password" required>
									</div>
								</div>

								<div class="form-group">
									<label for="npassword" class="col-sm control-label">New password:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password" required>
									</div>
								</div>

								<div class="form-group">
									<label for="cpassword" class="col-sm control-label">Confirm Password:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
										<button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Save Changes </button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- /card-body -->		
	</div> <!-- /card -->		
</div> <!-- /col-md-12 -->	
</div> <!-- /row-->


<script src="custom/js/setting.js"></script>
<script type="text/javascript">

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
			url: 'php_action/fetchSelectedUser.php',
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
						          		url: 'php_action/fetchUserImageUrl.php?i='+userid,
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
	}
</script>
<?php require_once 'includes/footer.php'; ?>