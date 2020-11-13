<?php 
// require_once 'php_action/core.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
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
		/* Make the image fully responsive */
		.carousel-inner img {
			width: 100%;
			height: 100%;
		}


		.product-entry {
			border: .1rem solid #dee2e6 !important;
			margin-bottom: 1.5rem;
			margin-top: 1rem;
		}

		.cart {
			text-align: center;
		}

		.product-entry .cart a {
			display: block;
			color: #000;
			padding: .5em;
			-webkit-transition: 0.5s;
			-o-transition: 0.5s;
			transition: 0.5s; 
		}

		.product-entry:hover .cart {
			display: block;
			background-color: #dee2e6;
		}

		.product-entry .cart a:hover {
			display: block;
			background: #FFC300;
			margin: 0px;
		}

		.product-name p {
			text-align: center;
			font-size: 16px;
			font-family: "Roboto", Arial, sans-serif, bold;
			font-weight: 400;
			font-weight: bolder;
			margin: 0 0 20px 0;
			overflow: hidden;
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
		}

		.product-name p a {
			color: #000;
		}

		.product-img {
			margin: .5rem;
		}

		.view-more {
			display: block;
			border-top: 1px solid #dee2e6 !important;
			background-color: white;
			text-align: center;
		}

		.view-more:hover {
			display: block;
			background-color: #dee2e6 !important;
		}

		.view-more:hover a{
			display: block;
			background-color: #dee2e6 !important;
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
					<li class="nav-item">
						<a class="nav-link text-white" href="sign-in.php"><i class="fas fa-sign-in-alt"></i> Login</a>
					</li>
					<li class="nav-item">
						<a href="cart.php" class="nav-item nav-link ">
							<h6 class="px-5 cart text-white">
								<i class="fas fa-cart-arrow-down fa-2x"></i>
								<?php

								if (isset($_SESSION['cart'])){
									$count = count($_SESSION['cart']);
									echo "<span id=\"cart_count\" class=\"badge badge-primary\">$count</span>";
								}else{
									echo "<span id=\"cart_count\" class=\"badge badge-warning\">0</span>";
								}

								?>
							</h6>
						</a>
					</li>
				</ul>
			</div>
			<div class="dropdown navbar-nav ">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="img-profile rounded-circle border border-light" src="assests/images/users/john.jpg" style="width: 35px; height: 35px;">
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
			var ram = get_filter('ram');
			var storage = get_filter('storage');
			$.ajax({
				url:"fetch_data.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, storage:storage},
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
			max:65000,
			values:[1000, 65000],
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
				url:"fetch_data.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, storage:storage},
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
			max:65000,
			values:[1000, 65000],
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
			var ram = get_filter('ram');
			var storage = get_filter('storage');
			$.ajax({
				url:"fetch_data.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, storage:storage},
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
			max:65000,
			values:[1000, 65000],
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
<!-- Bootstrap core JavaScript -->
<!-- <script src="assests/jquery/jquery.min.js"></script> -->
<script src="assests/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>







