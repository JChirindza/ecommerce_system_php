<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId']) && isset($_SESSION['userType'])) {
	if($_SESSION['userType'] == 1) {
		header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');
	}

	// Get username
	$userID = $_SESSION['userId'];
	$sql = "SELECT * FROM users WHERE user_id = '$userID' ";
	$result = $connect->query($sql);
	if($result->num_rows > 0) { 
		while($row = $result->fetch_array()) {
			$username = $row[1];
			$user_image_url = $row[5];
 		} // /while 
	}// if num_rows
}


?>

<nav class="navbar navbar-expand-lg border-bottom shadow-sm bg-dark">
	<!-- Brand -->
	<div class="col-sm-2 col-md-4 col-lg-3">
		<a class="navbar-brand logo p-0 border" href="../index.php">ComputersOnly</a>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-6">
		<div class="input-group col-12 m-auto">
			<input type="text" class="col-10 rounded-left border-0" id="myInput" placeholder="Search..." name="search">
			<div class="col-2 p-0 input-group-append">
				<button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
			</div>
		</div>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-3 d-flex justify-content-end">
		<div class="row">
			<div class="col-9 collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link text-white" href="home.php">Home</a>
					</li>
					<?php if (isset($_SESSION['userId'])){ ?>
						<li class="nav-item">
							<a href="cart.php" class="nav-item nav-link ">
								<h6 class="px-5 cart text-white">
									<i class="fas fa-cart-arrow-down fa-2x"></i>

								</h6>
							</a>
						</li>
					<?php }else{ ?>
						<li class="nav-item">
							<a class="nav-link text-white" href="../sign-in.php">Login</a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<?php if (isset($_SESSION['userId'])){ ?>
				<div class="col-3">
					

					<div class="dropdown navbar-nav float-right">
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<img class="img-profile rounded-circle border border-info" src=""  style="width: 35px; height: 35px;">
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<div class="dropdown-header disabled text-center p-0 m-0 text-gray">Hello, <?php echo $username; ?></div>
										<div class="dropdown-divider mt-0 pt-0"></div>
										<a id="topNavSetting" class="dropdown-item" href="config.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Settings</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
	
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Do you really want to logout?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Select <label class="text-muted"><i class="fas fa-sign-out-alt"></i> Logout </label> if you want to end the session.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="../sign-out.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
			</div>
		</div>
	</div>
</div>

<!-- Login Modal-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>