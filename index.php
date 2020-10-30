<?php 
// require_once 'php_action/db_connect.php';

// $connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

session_start();

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Vendas - Online</title>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<!-- <link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css"> -->
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/fontawesome.min.css">

	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/style.css">

	<!-- DataTables -->
	<link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

	<!-- file input -->
	<link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

	<!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
	<!-- jquery ui -->  
	<link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
	<script src="assests/jquery-ui/jquery-ui.min.js"></script>

	<!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
	<style>
		/* Make the image fully responsive */
		.carousel-inner img {
			width: 100%;
			height: 100%;
		}

		.sidebar {
			margin: 0;
			padding: 0;
			background-color: #f1f1f1;
			position: fixed;
			overflow: auto;
		}

		.sidebar a {
			display: block;
			color: black;
			text-decoration: none;
		}

		.sidebar a.active {
			background-color: #4CAF50;
			color: white;
		}

		.sidebar a:hover:not(.active) {
			background-color: #555;
			color: white;
		}

	</style>
</head>
<body class="bg-light">
	
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<div class="col-lg-4 text-left">

			</div>


			<div class="input-group col-lg-4">
				<input type="text" class="col-sm-10" id="myInput" placeholder="Procurar..." name="procurar">
				<div class="input-group-append">
					<button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
			<div class="col-lg-4 collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="sign-in.php">Login</a>
					</li>
					<li class="nav-item">
						<a href="cart.php" class="nav-item nav-link active">
							<h6 class="px-5 cart">
								<i class="glyphicon glyphicon-shopping-cart"></i> Cart
								<?php

								if (isset($_SESSION['cart'])){
									$count = count($_SESSION['cart']);
									echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
								}else{
									echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
								}

								?>
							</h6>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container" style="margin-top: 40px;">
		<div class="row pt-5">
			<div class="col-lg col-lg-3 border" style="background-color: white;">
				<div class=" ">
					<a class="nav-link active" href="#">Computadores</a>
					<a class="nav-link" href="#">Hardware e pecas de Redes</a>
					<a class="nav-link" href="#">Componentes de computadores</a>
				</div>
			</div>
			<div class="col-lg col-lg-6">
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
			<div class="col-lg col-lg-3 border" style="background-color: white;">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
	</div>

	<div class="container" style="background-color: white; margin-top: 15px;">
		<div class="col-sm-8 py-2">
			<h4 class="text-muted">Computadores</h4>
		</div>
		
		<div class="row col-lg-12 filter_cellphones">
			
		</div>
	</div>

	<div class="container" style="background-color: white; margin-top: 15px; ">
		<div class="col-sm-8 py-2">
			<h4 class="text-muted">Hardware e peças de rede</h4>
		</div>
		
		<div class="row col-lg-12 filter_cellphones">
			
		</div>
	</div>

	<div class="container" style="background-color: white; margin-top: 15px;">
		<div class="col-sm-8 py-2">
			<h4 class="text-muted">Componentes de computador</h4>
		</div>
		
		<div class="row col-lg-12 filter_cellphones">
			
		</div>
	</div>

	<script>
		$(document).ready(function(){

			filter_cellphones();

			function filter_cellphones()
			{
				$('.filter_cellphones').html('<div id="loading" style="" ></div>');
				var action = 'filter_cellphones';
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
						$('.filter_cellphones').html(data);
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

</body>
</html>







