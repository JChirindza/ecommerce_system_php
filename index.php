<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	if ($_SESSION['userType'] == 1) {
		header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
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

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sistema de Vendas - Online</title>

	<!-- bootstrap CSS 4.5.3 -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- fontawesome JS 5.15.1 -->
	<script type="text/javascript" src="assests/font-awesome/js/all.min.js"></script>
	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/style.css">
	<!-- DataTables 1.10.22 -->
	<link rel="stylesheet" href="assests/plugins/datatables/css/jquery.dataTables.min.css">
	<!-- file input -->
	<link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
	<!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
	<!-- jquery ui 1.12.1 -->  
	<link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
	<script src="assests/jquery-ui/jquery-ui.min.js"></script>
	<!-- Select2 CDN -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
	<!-- Select2 - Custom JS -->
	<script type="text/javascript" src="assests/select2/select2Custom.js"></script>

	<style>
		.view-more {
			padding: .4rem;
		}

	</style>
</head>
<body id="page-top" class="bg-light">

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg border-bottom shadow-sm bg-dark " >
		<!-- Brand -->
		<div class="col-md-3">
			<a class="brand navbar-brand logo p-0 border" href="index.php">ComputersOnly</a>
		</div>
		<div class="input-group col-md-6 m-auto">
			<input type="text" class="col-sm-10" id="myInput" placeholder="Procurar..." name="procurar">
			<div class="input-group-append">
				<button type="button" class="btn btn-primary"><i class="fas fa-search fa-2x"></i></button>
			</div>
		</div>
		<div class="col-md-3 row">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
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
							<a class="nav-link text-white" href="sign-in.php"><i class="fas fa-sign-in-alt"></i> Login</a>
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
	<style type="text/css">
		.bottom-nav a{
			color: black;
		}

		.bottom-nav a:hover {
			color: blue;
		}
	</style>
	<div class="col-md-12 bg-white bottom-nav border-bottom">
		<div class="container row">
			<div class="email mr-4">
				<a class="" href="#"><i class="fas fa-envelope mr-2 ml-4"></i>customers@computersonly.co.mz</a> 
			</div>
			<div class="cell mr-4">
				<a class="" href="#"><i class="fas fa-phone-alt mr-2 ml-4"></i>+258 8000000000</a>
			</div>
			<div class="location mr-4">
				<a class="" href="#"><i class="fas fa-map-marker-alt mr-2 ml-4"></i> Store location</a>
			</div>
			<div class="my-orders ">
				<a class="" href="#"><i class="fas fa-truck mr-2 ml-4"></i>your orders</a>
			</div>
		</div>
	</div>

	<div class="d-flex" id="wrapper">
		<div class="container-fluid bg-light m-4">

			<div class="row">
				<div class="col-sm-3 bg-white p-3">
					<h4 class=""><i class="fas fa-list"></i> Categorias</h4>
					<div class="list-group list-group-flush border">
						<a id="navClient" href="#" class="list-group-item list-group-item-action border-0">Computadores</a>
						<a id="navReport" href="#" class="list-group-item list-group-item-action border-0">Hardware e pecas de Redes</a>
						<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0">Componentes de computadores</a>
					</div>
				</div>

				<div class="col-sm-6">
					<div id="demo" class="carousel slide border" data-ride="carousel">

						<!-- Indicators -->
						<ul class="carousel-indicators">
							<li data-target="#demo" data-slide-to="0" class="active"></li>
							<li data-target="#demo" data-slide-to="1"></li>
							<li data-target="#demo" data-slide-to="2"></li>
							<li data-target="#demo" data-slide-to="3"></li>
							<li data-target="#demo" data-slide-to="4"></li>
						</ul>

						<!-- The slideshow -->
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="assests/images/slide/s2.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="assests/images/slide/s3.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="assests/images/slide/s5.jpg" style="width:100%;height:250px;" alt="">
							</div>
						</div>

						<!-- Left and right controls -->
						<a class="carousel-control-prev" href="#demo" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</a>
						<a class="carousel-control-next" href="#demo" data-slide="next">
							<span class="carousel-control-next-icon"></span>
						</a>
					</div>					
				</div>

				<div class="col-sm-3 border bg-white p-3">
					<h4><i class="fas fa-list"></i> Categorias</h4>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-sm-12 bg-white p-3">
					<h4><i class="fas fa-list"></i> Computadores </h4>

					<!-- Filter Computers -->
					<div class="row filter_computers"></div>
				</div>
				<div class="col-sm-12 view-more">
					<a href="#">+ view more</a>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-sm-3 border bg-white p-3">
					<h4><i class="fas fa-list"></i> Categorias</h4>
					<div class="list-group list-group-flush">
						<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
						<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
						<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
					</div>
				</div>

				<div class="col-sm-3 border bg-white p-3">
					<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>

				</div>

				<div class="col-sm-3 border bg-white p-3">
					<h4><i class="fas fa-list"></i> Categorias</h4>

				</div>
				<div class="col-sm-3 border bg-white p-3">
					<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>
					<div class="list-group list-group-flush">
						<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
						<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
						<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
					</div>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-sm-12 bg-white p-3">
					<h4><i class="fas fa-network-wired"></i> Hardware e Pecas de Rede </h4>

					<!-- Filter Hardware and network parts -->
					<div class="row filter_hardware"></div>
				</div>
				<div class="col-sm-12 view-more">
					<a href="#">+ view more</a>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-sm-3 border bg-white p-3">
					<h4><i class="fas fa-list"></i> Categorias</h4>
					<div class="list-group list-group-flush">
						<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
						<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
						<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
					</div>
				</div>

				<div class="col-sm-3 border bg-white p-3">
					<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>

				</div>

				<div class="col-sm-3 border bg-white p-3">
					<h4><i class="fas fa-list"></i> Categorias</h4>

				</div>
				<div class="col-sm-3 border bg-white p-3">
					<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>
					<div class="list-group list-group-flush">
						<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
						<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
						<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
					</div>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-sm-12 bg-white p-3">
					<h4><i class="fas fa-network-wired"></i> Componentes de computador</h4>

					<!-- Computer components -->
					<div class="row filter_componets"></div>
				</div>
				<div class="col-sm-12 view-more border-top">
					<a href="#">+ view more</a>
				</div>
			</div>
		</div>
	</div>
</div>

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

<!-- ToolTip JS -->
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script>
	$(document).ready(function(){

		filter_computers();

		function filter_computers()
		{
			$('.filter_computers').html('<div id="loading" style="" ></div>');
			var action = 'filter_computers';
			var minimum_price = $('#hidden_minimum_price').val();
			var maximum_price = $('#hidden_maximum_price').val();
			var brand = get_filter('brand');
			
			$.ajax({
				url:"fetch_cart.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
				success:function(data){
					$('.filter_computers').html(data);
				}
			});
		}

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			return filter;
		}

		$('.common_selector').click(function(){
			filter_data();
		});

		$('#price_range').slider({
			range:true,
			min:1000,
			max:165000,
			values:[1000, 165000],
			step:500,
			stop:function(event, ui)
			{
				$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
				$('#hidden_minimum_price').val(ui.values[0]);
				$('#hidden_maximum_price').val(ui.values[1]);
				filter_data();
			}
		});

	});
</script>

<script>
	$(document).ready(function(){

		filter_hardware();

		function filter_hardware()
		{
			$('.filter_hardware').html('<div id="loading" style="" ></div>');
			var action = 'filter_hardware';
			var minimum_price = $('#hidden_minimum_price').val();
			var maximum_price = $('#hidden_maximum_price').val();
			var brand = get_filter('brand');
			var ram = get_filter('ram');
			var storage = get_filter('storage');
			$.ajax({
				url:"fetch_cart.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
				success:function(data){
					$('.filter_hardware').html(data);
				}
			});
		}

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			return filter;
		}

		$('.common_selector').click(function(){
			filter_data();
		});

		$('#price_range').slider({
			range:true,
			min:1000,
			max:165000,
			values:[1000, 165000],
			step:500,
			stop:function(event, ui)
			{
				$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
				$('#hidden_minimum_price').val(ui.values[0]);
				$('#hidden_maximum_price').val(ui.values[1]);
				filter_data();
			}
		});

	});
</script>

<script>
	$(document).ready(function(){

		filter_componets();

		function filter_componets()
		{
			$('.filter_componets').html('<div id="loading" style="" ></div>');
			var action = 'filter_componets';
			var minimum_price = $('#hidden_minimum_price').val();
			var maximum_price = $('#hidden_maximum_price').val();
			var brand = get_filter('brand');
			$.ajax({
				url:"fetch_cart.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
				success:function(data){
					$('.filter_componets').html(data);
				}
			});
		}

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			return filter;
		}

		$('.common_selector').click(function(){
			filter_data();
		});

		$('#price_range').slider({
			range:true,
			min:1000,
			max:165000,
			values:[1000, 165000],
			step:500,
			stop:function(event, ui)
			{
				$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
				$('#hidden_minimum_price').val(ui.values[0]);
				$('#hidden_maximum_price').val(ui.values[1]);
				filter_data();
			}
		});

	});
</script>

<!-- Fetch User Image -->
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

				$("#getUserImageNav").attr('src', 'users/'+response.user_image);

				$("#editUserImage").fileinput({		      
				});		

				

			} // /success function
		}); // /ajax to fetch product image
	}
</script>
<!-- Bootstrap core JavaScript -->
<!-- <script src="assests/jquery/jquery.min.js"></script> -->
<script src="assests/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>







