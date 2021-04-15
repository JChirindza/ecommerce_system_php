<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM users WHERE type = 1 AND status = 1";
$query = $connect->query($sql);
$countUsers = $query->num_rows;

$connect->close();

?>
<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
	    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Users</li>
	    
  	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Usuários</h1>
	<button class="btn btn-primary btn-sm" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"> <i class="fas fa-plus"></i> Adicionar Usuario </button>
</div>

<div class="row">
	<div class="col-md-12">
		
		<div class="row">
			<div class="col-md-4 pt-2">
				<div class="card ">
					<div class="card-body d-sm-flex align-items-center justify-content-between">
						<label>Total de usuarios</label>
						<span class="badge-secondary badge-pill"><?php echo $countUsers; ?></span>	
					</div> 
				</div> 
			</div> <!--/col-md-4-->
		</div>
		<hr>
		<div class="card">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-muted">Gerir Usuários</h6>
			</div>

			<div class="card-body ">
				<div class="remove-messages"></div>

				<div class="table-responsive">
					<table class="table table-striped" id="manageUserTable">
						<thead>
							<tr>
								<th style="width:10%;">Foto</th>
								<th style="width:20%;">Nome</th>
								<th style="width:20%;">Apelido</th>
								<th style="width:30%;">Email</th>
								<th style="width:10%;">Status</th>
								<th style="width:10%;">Options</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add user -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content p-1">

			<form class="form-horizontal" id="submitUserForm" action="php_action/createUser.php" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				
				<div id="add-user-messages"></div>
				
				<div class="modal-body" style="max-height:450px; overflow:auto;">

					<div class="form-group">
						<label for="userName" class="col-sm-6 control-label">Nome do usuario: </label>
						
						<div class="col-sm-8">
							<input type="text" class="form-control" id="userName" placeholder="Name" name="userName" autocomplete="off" required>
						</div>
					</div> <!-- /form-group-->

					<div class="form-group">
						<label for="userSurname" class="col-sm-6 control-label">Apelido do usuario: </label>
						
						<div class="col-sm-8">
							<input type="text" class="form-control" id="userSurname" placeholder="Surname" name="userSurname" autocomplete="off" required>
						</div>
					</div> <!-- /form-group-->

					<div class="form-group">
						<label for="uemail" class="col-sm-3 control-label"> Email: </label>
						
						<div class="col-sm-8">
							<input type="text" class="form-control" id="uemail" placeholder="Email" name="uemail" autocomplete="off" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required>
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="upassword" class="col-sm-3 control-label">Password: </label>
						
						<div class="col-sm-8">
							<input type="password" class="form-control" id="upassword" placeholder="Password" name="upassword" autocomplete="off" required>
						</div>
					</div> <!-- /form-group-->	

					<div class="form-group">
						<label for="upassword" class="col-sm-4 control-label">Tipo de acesso: </label>
						
						<div class="col-sm-8">
							<select class="form-control" id="permittion" name="permittion" required>
								<option value="">~~SELECT~~</option>
								<option value="1">Administrador</option>
								<option value="2">Gestor</option>
								<option value="3">Vendedor</option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<!-- user type >>> 1 - Funcionario -->
					<input type="text" name="" hidden="true" id="type" value="1">
				</div> <!-- /modal-body -->
				
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
					
					<button type="submit" class="btn btn-success" id="createUserBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> Save Changes</button>
				</div> <!-- /modal-footer -->	      
			</form> <!-- /.form -->	     
		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- edit categories brand -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-edit"></i> Edit User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only">Loading...</span>
				</div>

				<div class="div-result">

					<!-- Nav tabs -->
					<div class="form-group ">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#menu1">Foto</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu2">Alterar Dados</a>
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
								
								<div class="modal-footer editUserPhotoFooter">
									<button type="button" class="btn btn-outline-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
								</div> <!-- /modal-footer -->
							</form>
						</div>
						<div id="menu2" class="tab-pane fade" >
							<form class="form-horizontal" id="editUserForm" action="php_action/editUser.php" method="POST">				    
								<div id="edit-user-messages"></div>

								<div class="form-group">
									<label for="editName" class="col-sm-3 control-label"> Nome: </label>
									
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editName" placeholder="Nome" name="editName" autocomplete="off" required>
									</div>
								</div> <!-- /form-group-->

								<div class="form-group">
									<label for="editSurname" class="col-sm-3 control-label"> Apelido: </label>
									
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editSurname" placeholder="Apelido" name="editSurname" autocomplete="off" required>
									</div>
								</div> <!-- /form-group-->

								<div class="form-group">
									<label for="editEmail" class="col-sm-3 control-label">Email: </label>
									
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editEmail" placeholder="Email" name="editEmail" autocomplete="off" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required>
									</div>
								</div> <!-- /form-group-->	 	    

								<!-- <div class="form-group">
									<label for="editPassword" class="col-sm-3 control-label">Password: </label>
									
									<div class="col-sm-8">
										<input type="password" class="form-control" id="editPassword" placeholder="Password" name="editPassword" autocomplete="off" required>
									</div>
								</div> --> <!-- /form-group-->	

								<div class="form-group">
									<label for="upassword" class="col-sm-4 control-label">Tipo de acesso: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editPermittion" name="editPermittion" required>
											<option value="">~~SELECT~~</option>
											<option value="1">Administrador</option>
											<option value="2">Gestor</option>
											<option value="3">Vendedor</option>
										</select>
									</div>
								</div> <!-- /form-group-->

								<div class="form-group">
									<label for="editUserStatus" class="col-sm-3 control-label">Status: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editUserStatus" name="editUserStatus" required>
											<option value="">~~SELECT~~</option>
											<option value="1">Activo</option>
											<option value="2">Inactivo</option>
										</select>
									</div>
								</div> <!-- /form-group-->        	 
								<div class="modal-footer editUserFooter">
									<button type="button" class="btn btn-outline-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
									
									<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> Save Changes</button>
								</div> <!-- /modal-footer -->				     
							</form> <!-- /.form -->	
						</div>

					</div>    
					<!-- /product info -->
				</div>
			</div>
		</div> <!-- /modal-body -->
	</div>
	<!-- /modal-content -->
</div>
<!-- /modal-dailog -->


<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> Remove User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeUserMessages"></div>
				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeProductFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

<script src="custom/js/user.js"></script>
<?php require_once 'includes/footer.php'; ?>


