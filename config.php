<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();
?>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Configuracoes</h1>
</div>

<div class="row">
	<div class="col-md-12">
		<!-- <ol class="breadcrumb">
			<li><a href="dashboard.php">Home</a></li>		  
			<li class="active">Setting</li>
		</ol> -->

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
									<img src="" id="getUserImage" class="thumbnail" style="width:200px; height:200px;" />
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
							</div> <!-- /form-group-->	     	           	       
						</form>
						<!-- /form -->
					</div>
					<div id="menu2" class="tab-pane fade" >
						<form action="php_action/changeUsername.php" method="post" class="form-horizontal col-sm-8" id="changeUsernameForm">
							<fieldset >

								<div class="changeUsernameMessages"></div>			

								<div class="form-group">
									<label for="username" class="col-sm control-label">Username:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="username" name="username" placeholder="Usename" value="<?php echo $result['username']; ?>" required/>
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
										<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $result['email']; ?>" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required/>
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
<?php require_once 'includes/footer.php'; ?>