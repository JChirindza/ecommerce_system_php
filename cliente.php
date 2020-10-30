<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM clients";
$query = $connect->query($sql);
$countClients = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>


<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Clientes</h1>
	<button class="btn btn-primary btn-sm" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar cliente </button>
</div>

<div class="row">
	<div class="col-md-12">
		<!-- <ol class="breadcrumb navbar navbar-expand-lg navbar-light bg-light">
			<li><a href="dashboard.php">Pagina inicial</a></li>		  
			<li class="active">Usuário</li>
		</ol> -->
		<div class="row">
			<div class="col-md-4 pt-2">
				<div class="card ">
					<div class="card-body d-sm-flex align-items-center justify-content-between">
						<label>Total de clientes</label>
						<span class="badge-secondary badge-pill"><?php echo $countClients; ?></span>	
					</div> 
				</div> 
			</div> <!--/col-md-4-->
		</div>
		<hr>
		<div class="card">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-muted">Gerir clientes</h6>
			</div>

			<div class="card-body ">
				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary btn-sm" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar cliente </button>
				</div>
				<div class="table-responsive">
					<table class="table table-striped" id="manageUserTable">
						<thead>
							<tr>
								<th style="width:40%;">Nome do cliente</th>
								<th style="width:50%;">Email</th>
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
		<div class="modal-content">

			<form class="form-horizontal" id="submitUserForm" action="php_action/createUser.php" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body" style="max-height:450px; overflow:auto;">

					<div id="add-user-messages"></div>

					<div class="form-group">
						<label for="userName" class="col-sm-3 control-label">Nome do usuario: </label>
						
						<div class="col-sm-8">
							<input type="text" class="form-control" id="userName" placeholder="User Name" name="userName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->

					<div class="form-group">
						<label for="email" class="col-sm-3 control-label"> Email: </label>
						
						<div class="col-sm-8">
							<input type="text" class="form-control" id="email" placeholder="Email" name="email" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="upassword" class="col-sm-3 control-label">Password: </label>
						
						<div class="col-sm-8">
							<input type="password" class="form-control" id="upassword" placeholder="Password" name="upassword" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	        	 

				</div> <!-- /modal-body -->
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
					
					<button type="submit" class="btn btn-primary" id="createUserBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
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
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#userInfo" aria-controls="profile" role="tab" data-toggle="tab">Info. usuario</a></li>    
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">

						<!-- product image -->
						<div role="tabpanel" class="tab-pane active" id="userInfo">
							<form class="form-horizontal" id="editUserForm" action="php_action/editUser.php" method="POST">				    
								<br />

								<div id="edit-user-messages"></div>

								<div class="form-group">
									<label for="edituserName" class="col-sm-3 control-label">User Name: </label>
									
									<div class="col-sm-8">
										<input type="text" class="form-control" id="edituserName" placeholder="User Name" name="edituserName" autocomplete="off">
									</div>
								</div> <!-- /form-group-->

								<div class="form-group">
									<label for="editEmail" class="col-sm-3 control-label">Email: </label>
									
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editEmail" placeholder="Email" name="editEmail" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	 	    

								<div class="form-group">
									<label for="editPassword" class="col-sm-3 control-label">Password: </label>
									
									<div class="col-sm-8">
										<input type="password" class="form-control" id="editPassword" placeholder="Password" name="editPassword" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	        	 
								<div class="modal-footer editUserFooter">
									<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
									
									<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
								</div> <!-- /modal-footer -->				     
							</form> <!-- /.form -->				     	
						</div>    
						<!-- /product info -->
					</div>
				</div>
			</div> <!-- /modal-body -->
		</div>
		<!-- /modal-content -->
	</div>
	<!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeUserMessages"></div>
				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeProductFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
				<button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->


<script src="custom/js/client.js"></script>
<?php require_once 'includes/footer.php'; ?>


