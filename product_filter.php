<?php 

require_once 'php_action/db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Product filter in php</title>

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
			<h2 align="center">Product Filters</h2>
			<div class="row">
				
				<div class="col-md-2">                				
					<div class="list-group">
						<h3>Price</h3>

						<?php 
							$sql = "SELECT Min(rate) as minPrice, Max(rate) as maxPrice FROM product";
							$query = $connect->query($sql);
							$result = $query->fetch_assoc();

							$minPrice = $result['minPrice'];
							$maxPrice = $result['maxPrice'];

						 ?>

						<input type="hidden" id="hidden_minimum_price" value="<?php $minPrice; ?>" />
						<input type="hidden" id="hidden_maximum_price" value="<?php $maxPrice; ?>" />
						<p id="price_show"><?php echo $minPrice ." - ". $maxPrice; ?></p>
						<div id="price_range"></div>
					</div>				
					<div class="list-group">
						<h3>Brand</h3>
						<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
							<?php

							$sql = "SELECT DISTINCT(brand_id) FROM product WHERE active = '1' ORDER BY product_id DESC";
							$query = $connect->query($sql);

							foreach($query as $row) { 

								$brandID = $row['brand_id'];

								$sql1 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
								$query1 = $connect->query($sql1);
								$result = $query1->fetch_assoc();
								?>
								<div class="list-group-item checkbox">
									<label>
										<input type="checkbox" class="common_selector brand" value="<?php echo $brandID; ?>" > <?php echo $result['brand_name']; ?>
									</label>
								</div>
								<?php 
							} ?>
						</div>
					</div>

				</div>

				<div class="col-md-10">
					<div class="row filter_data">

					</div>
				</div>
			</div>

		</div>
	</div>
	<style>
		#loading {
			text-align:center; 
			background: url('loader.gif') no-repeat center; 
			height: 150px;
		}
	</style>

	<script>
		$(document).ready(function(){

			filter_data();

			function filter_data() {
				$('.filter_data').html('<div id="loading" style="" ></div>');
				var action = 'fetch_data';
				var minimum_price = $('#hidden_minimum_price').val();
				var maximum_price = $('#hidden_maximum_price').val();
				var brand = get_filter('brand');
				
				$.ajax({
					url:"fetch_data.php",
					method:"POST",
					data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
					success:function(data){
						$('.filter_data').html(data);
					}
				});
			}

			function get_filter(class_name) {
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
				min:0,
				max:125000,
				values:[0, 125000],
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
