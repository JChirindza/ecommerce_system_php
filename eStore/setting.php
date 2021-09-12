<?php require_once 'includes/header.php'; ?>
<?php  
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<div class="p-4" style="height: 800px;">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			<?php echo $language['access-403'] ?>.
		</div>
		<div class="d-flex justify-content-center">
			<a href="../sign-in.php" class="btn btn-primary"><i class="fas fa-sign-in-alt pr-2"></i> <?php echo $language['sign-in'] ?></a>
		</div>
	</div>

	<?php
	require_once 'includes/footer.php';
	die();
}else{
	$user_id = Sys_Secure($_SESSION['userId']);
	$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
	$query = $connect->query($sql);
	$result = $query->fetch_assoc();
}

$connect->close();
?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['settings'] ?></li>
			</ol>
		</div>
		
		<div class="row mt-2 mt-md-0 mt-lg-0">
			<div class="col-sm-12 bg-white p-3 userSettings">
				<h4><i class="fas fa-list"></i> <?php echo $language['edit-profile'] ?></h4>
				<div class="col-md-12 p-0 mt-2">
					<!-- Nav tabs -->
					<div class="form-group ">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#menu1"><?php echo $language['edit-photo'] ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu2"><?php echo $language['edit-user-name'] ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu3"><?php echo $language['edit-email'] ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu4"><?php echo $language['edit-password'] ?></a>
							</li>
						</ul>
					</div>
					<!-- Tab panes -->
					<div class="tab-content border border-top-0" style="min-height: 350px;">
						<div id="menu1" class="tab-pane active" >
							<form action="php_action/ctrl_user.php?action=editImage" method="POST" id="updateUserImageForm" class="form-horizontal" enctype="multipart/form-data">

								<div id="edit-userPhoto-messages"></div>

								<div class="form-group">
									<label for="editUserImage" class="col-sm control-label"><?php echo $language['user-image'] ?>: </label>
									<div class="col-sm-8">							    				   
										<img src="" id="getUserImage" class="thumbnail border border-info" style="width:200px; height:200px;" />
									</div>
								</div> <!-- /form-group-->	     	           	       

								<div class="form-group">
									<label for="editUserImage" class="col-sm control-label"><?php echo $language['select-photo'] ?>: </label>
									<div class="col-sm-4">
										<!-- the avatar markup -->
										<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
										<div class="kv-avatar center-block">					        
											<input type="file" class="form-control" id="editUserImage" name="editUserImage" class="file-loading" style="width:auto;"/>
										</div>
									</div>
									<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" />
								</div> <!-- /form-group-->	     	           	       
							</form>
						</div>
						<div id="menu2" class="tab-pane fade" >
							<form action="php_action/ctrl_user.php?action=editUsername" method="post" class="form-horizontal col-sm-8" id="changeUsernameForm">
								<fieldset >

									<div class="changeUsernameMessages"></div>			

									<div class="form-group">
										<label for="name" class="col-sm control-label"><?php echo $language['name'] ?>:</label>
										<div class="col-sm-10 mb-3">
											<input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $language['name'] ?>" value="<?php echo $result['name']; ?>" required/>
										</div>

										<label for="surname" class="col-sm control-label"><?php echo $language['surname'] ?>:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="surname" name="surname" placeholder="<?php echo $language['surname'] ?>" value="<?php echo $result['surname']; ?>" required/>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
											<button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?> </button>
										</div>
									</div>
								</fieldset>
							</form>
						</div>

						<div id="menu3" class="tab-pane fade" >
							<form action="php_action/ctrl_user.php?action=editEmail" method="post" class="form-horizontal col-sm-8" id="changeEmailForm">
								<fieldset >

									<div class="changeEmailMessages"></div>			

									<div class="form-group">
										<label for="email" class="col-sm control-label"> <?php echo $language['email'] ?> :</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="email" name="email" placeholder=" <?php echo $language['email'] ?>" value="<?php echo $result['email']; ?>" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"/>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
											<button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeEmailBtn"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?> </button>
										</div>
									</div>
								</fieldset>
							</form>
						</div>

						<div id="menu4" class="tab-pane fade">
							<form action="php_action/ctrl_user.php?action=editPassword" method="post" class="form-horizontal col-sm-8" id="changePasswordForm">
								<fieldset>
									<div class="changePasswordMessages"></div>

									<div class="form-group">
										<label for="password" class="col-sm control-label"><?php echo $language['current-pass'] ?>:</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $language['current-pass'] ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label for="npassword" class="col-sm control-label"><?php echo $language['new-pass'] ?>:</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="npassword" name="npassword" placeholder="<?php echo $language['new-pass'] ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label for="cpassword" class="col-sm control-label"><?php echo $language['confirm-password'] ?>:</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="<?php echo $language['confirm-password'] ?>" required>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
											<button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?> </button>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div> <!-- /col-md-12 -->
			</div>
		</div>

		<div class="row mt-2 mt-md-3 mt-lg-4">
			<div class="col-sm-12 bg-white p-3 userSettings " id="delivery_address">
				<h4><i class="fas fa-info-circle"></i> <?php echo $language['delivery-address'] ?> </h4>
				<div class="col-md-12 p-0 mt-2">

					<div class="deliveryLocationMessages"></div>

					<form class="form-horizontal col-sm-8" id="submitDeliveryLocationForm" action="php_action/ctrl_request.php?action=<?php //echo $ref; ?>" method="POST" enctype="multipart/form-data">

						<div class="form-group">
							<label for="country" class="col-sm-6 control-label"><?php echo $language['country'] ?>: </label>

							<div class="col-sm-10">
								<select class="form-control" id="province" required>
									<option>~~<?php echo $language['select'] ?>~~</option>
									<option value="1"><?php echo $language['mozambique'] ?></option>
								</select>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="province" class="col-sm-6 control-label"><?php echo $language['province'] ?>: </label>

							<div class="col-sm-10">
								<select class="form-control" id="province" required>
									<option>~~<?php echo $language['select'] ?>~~</option>
									<option value="1">Maputo Cidade</option>
									<option value="2">Maputo Provincia (Matola)</option>
								</select>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="address" class="col-sm-6 control-label"><?php echo $language['address'] ?>: </label>

							<div class="col-sm-10">
								<input type="text" class="form-control" id="address" placeholder="<?php echo $language['address'] ?>" name="address" autocomplete="off" required>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="referencePoint" class="col-sm-6 control-label"><?php echo $language['reference-point'] ?>: </label>

							<div class="col-sm-10">
								<input type="text" class="form-control" id="referencePoint" placeholder="<?php echo $language['reference-point'] ?>" name="referencePoint" autocomplete="off" required>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="postalCode" class="col-sm-6 control-label"><?php echo $language['postal-code'] ?>: </label>

							<div class="col-sm-10">
								<input type="text" class="form-control" id="postalCode" placeholder="<?php echo $language['postal-code'] ?>" name="postalCode" autocomplete="off" required>
							</div>
						</div> <!-- /form-group-->
						<button type="submit" class="btn btn-success ml-3 rounded-0" id="createUserBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- / container-fluid -->
</div> <!-- / wrapper -->

<script src="custom/js/setting.js"></script>
<?php require_once 'includes/footer.php'; ?>