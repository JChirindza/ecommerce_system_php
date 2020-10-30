<?php 
// Get username
$userID = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = '$userID' ";
$result = $connect->query($sql);
if($result->num_rows > 0) { 
	while($row = $result->fetch_array()) {
		$username = $row[1];
 	} // /while 
}// if num_rows
?>
<nav class="navbar navbar-expand-lg border-bottom shadow-sm" >
	<!-- Brand -->
	<a class="col-md-6" href="dashboard.php">
		<div class="col-md-5  brand navbar-brand border logo p-0">
			<label class="text-dark m-0">ComputersOnly</label>
		</div>
	</a>
	<div class="col-md-6">
		<div class="dropdown navbar-nav float-right">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="img-profile rounded-circle border" src="assests/images/users/john.jpg" style="width: 35px; height: 35px;">
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="config.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Perfil</a>
							<a id="topNavSetting" class="dropdown-item" href="config.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Configurações</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Sair</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Deseja realmente sair?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Selecione <label class="text-muted"><i class="fas fa-sign-out-alt"></i> Sair </label> se deseja terminar a sessao.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="sign-out.php"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
			</div>
		</div>
	</div>
</div>