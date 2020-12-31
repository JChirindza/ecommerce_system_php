<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	if ($_SESSION['userType'] == 1) {
		header('location: ../SistemaDeVendas_ControleDeStock/dashboard.php');	
	}

	// Get username
	$userID = $_SESSION['userId'];
	$sql = "SELECT * FROM users WHERE user_id = '$userID' ";
	$result = $connect->query($sql);
	if($result->num_rows > 0) { 
		while($row = $result->fetch_array()) {
			$username = $row[1];
 		} // /while 
	}// if num_rows
}


?>

<nav class="navbar navbar-expand-lg border-bottom shadow-sm bg-dark " >
	<!-- Brand -->
	<div class="col-md-3">
		<a class="brand navbar-brand logo p-0 border" href="../index.php">ComputersOnly</a>
	</div>
	<div class="input-group col-md-6 m-auto">
		<input type="text" class="col-sm-10 rounded-left border-0" id="myInput" placeholder="Procurar..." name="procurar">
		<div class="input-group-append">
			<button type="button" class="btn btn-primary"><i class="fas fa-search fa-2x"></i></button>
		</div>
	</div>
	<div class="col-md-3 row">	
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link text-white" href="home.php">Home</a>
				</li>
				<?php if(isset($_SESSION['userId'])){ ?>
					<li class="nav-item">
						<a href="cart.php" class="nav-item nav-link ">
							<h6 class="px-5 cart text-white">
								<i class="fas fa-cart-arrow-down fa-2x"></i>
								<?php
								if (isset($_SESSION['cartItem'])){
									$count = count($_SESSION['cart']);
									echo "<span id=\"cart_count\" class=\"badge badge-warning\">$count</span>";
								}else{
									echo "<span id=\"cart_count\" class=\"badge badge-secondary\">0</span>";
								}
								?>
							</h6>
						</a>
					</li>
				<?php } else { ?>
					<li class="nav-item">
						<a class="nav-link text-white" href="../sign-in.php">Login</a>
					</li>
				<?php } ?>
				
				
			</ul>
		</div>

		<?php if(isset($_SESSION['userId'])){ ?>
			<div class="dropdown navbar-nav float-right">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="img-profile rounded-circle border border-info" id="getUserImageNav"  style="width: 35px; height: 35px;">
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<div class="dropdown-header disabled text-center p-0 m-0 text-gray">Ola, <?php echo $username; ?></div>
								<div class="dropdown-divider mt-0 pt-0"></div>
								<a id="topNavSetting" class="dropdown-item" href="config.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Configurações</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Sair</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		<?php } ?>
		
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
				<a class="btn btn-primary" href="../sign-out.php"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
			</div>
		</div>
	</div>
</div>

<!-- Login Modal-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<?php require_once '../loginForm.php'; ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var userid = <?php echo $userID; ?>;
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
			url: '../php_action/fetchSelectedUser.php',
			type: 'post',
			data: {"userid": userid},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');		

				$("#getUserImageNav").attr('src', 'users/'+response.user_image);

				$("#editUserImage").fileinput({		      
				});		

				

			} // /success function
		}); // /ajax to fetch product image
	}
</script>