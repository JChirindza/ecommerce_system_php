<?php require_once 'php_action/core.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sistema de Venda e Gestão de Stock</title>

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
	<link rel="stylesheet" type="text/css" href="assests/select2/css/select2.min.css">
	<script src="assests/select2/js/select2.min.js" defer></script>
	<!-- Select2 - Custom JS -->
	<script type="text/javascript" src="assests/select2/select2Custom.js"></script>
</head>
<body id="page-top">

	<!-- Navbar -->
	<?php require_once 'includes/navbar.php'; ?>

	<div class="d-flex" style="overflow-x: hidden;">

		<!-- Sidebar -->
		<?php require_once 'includes/sidebar.php'; ?>

		<!-- Page Content -->
		<div id="page-content-wrapper" class="bg-light">

			<div class="container-fluid">

				<!-- <div class="row border border-top-0 bg-white m-0 p-0">
					<div class="col-md-1">
						<button type="button" id="menu-toggle" class="btn d-inline-block d-lg ml-auto">
							<i class="fas fa-align-left"></i>
						</button>
					</div>


					<div class="col-md-2">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Home </a></li>	/	  
							<li class="active"> Product</li>
						</ol>
					</div>
				</div> -->