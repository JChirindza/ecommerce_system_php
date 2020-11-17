<?php require_once 'includes/header.php'; ?>

<?php

$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();


$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

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

$userwisesql = "SELECT users.name, users.surname , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<div class="border border-top-0 bg-white m-0 p-0" style="border-bottom-left-radius: .25rem; border-bottom-right-radius: .25rem;">
	<button type="button" id="menu-toggle" class="btn d-inline-block d-lg ml-auto">
		<i class="fas fa-align-left"></i>
	</button>
</div>

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="text-muted">Dashboard</h1>
	<a href="pedidos.php?p=manord" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Gerir pedidos</a>
</div>

<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 3) { ?>
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary h-100 py-2 shadow-sm ">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-calendar fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success h-100 py-2 shadow-sm ">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info h-100 py-2 shadow-sm ">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
						<div class="row no-gutters align-items-center">
							<div class="col-auto">
								<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
							</div>
							<div class="col">
								<div class="progress progress-sm mr-2">
									<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning h-100 py-2 shadow-sm ">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-comments fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?> 

<div class="row">

	<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 3) { ?>
		<div class="col-md-4 pt-2 mb-4">
			<div class="card card-success shadow-sm ">
				<div class="card-body">
					<a href="produto.php" class="text-xs font-weight-bold" style="text-decoration:none;color:black;">
						<div class="d-sm-flex align-items-center justify-content-between">
							<label>Total de Produtos</label>
							<span class="badge-secondary badge-pill"><?php echo $countProduct; ?></span>	
						</div>
					</a>
				</div> 
			</div> 
		</div> <!--/col-md-4-->

		<div class="col-md-4 pt-2 mb-4">
			<div class="card card-danger shadow-sm ">
				<div class="card-body">
					<a href="produto.php" class="font-weight-bold text-xs font-weight-bold" style="text-decoration:none;color:black;">
						<div class="d-sm-flex align-items-center justify-content-between">
							<label>Baixo Stock</label>
							<span class="badge-secondary badge-pill"><?php echo $countLowStock; ?></span>	
						</div>
					</a>
				</div> 
			</div> 
		</div> <!--/col-md-4-->
	<?php } ?>  

	<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 2) { ?>
		<div class="col-md-4 pt-2 mb-4">
			<div class="card shadow-sm ">
				<div class="card-body">
					<a href="pedidos.php?p=manord"  class="text-xs font-weight-bold" style="text-decoration:none;color: black;">
						<div class="d-sm-flex align-items-center justify-content-between">
							<label>Total de pedidos</label>
							<span class="badge-secondary badge-pill font-weight-bold"><?php echo $countOrder; ?></span>
						</div>
					</a>
				</div> 
			</div>
		</div> <!--/col-md-4-->
	<?php } ?>  
</div>

<div class="row">
	<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 2) { ?>
		<div class="col-md-12 pt-2 mb-4">
			<div class="card shadow-sm ">
				<div class="card-header"> <i class="fas fa-calendar"></i> Pedidos de Usuarios</div>
				<div class="card-body">
					<table class="table table-responsive" id="productTable">
						<thead>
							<tr>			  			
								<th style="width:30%;">Name</th>
								<th style="width:30%;">Apelido</th>
								<th style="width:20%;">Pedidos em (MZN)</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $orderResult['name']?></td>
									<td><?php echo $orderResult['surname']?></td>
									<td><?php echo $orderResult['totalorder']?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>
		</div> 
	<?php  }elseif (isset($_SESSION['userId']) && $result['permittion'] != 3) { ?> 
		<div class="col-md-12 pt-2 mb-4">
			<div class="card shadow-sm ">
				<div class="card-header"> <i class="fas fa-calendar"></i> Compras de Usuarios</div>
				<div class="card-body">
					<table class="table" id="productTable">
						<thead>
							<tr>			  			
								<th style="width:35%;">Nome</th>
								<th style="width:35%;">Apelido</th>
								<th style="width:30%;">Compras em (MZN)</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $orderResult['name']?></td>
									<td><?php echo $orderResult['surname']?></td>
									<td><?php echo $orderResult['totalorder']?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>
		</div> 
	<?php } ?>
	
	<div class="col-md-4  pt-2 mb-4">
		<div class="card shadow-sm ">
			<div class="card-header">
				<h1><?php echo date('d'); ?></h1>
			</div>
			<div class="card-body">
				<p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
			</div>
		</div> 
	</div>

	<div class="col-md-3 pt-2 mb-4">
		<div class="card shadow-sm ">
			<div class="card-header" style="background-color:#245580;">
				<h1><?php if($totalRevenue) {
					echo $totalRevenue;
				} else {
					echo '0';
				} ?></h1>
			</div>

			<div class="card-body">
				<p> INR Total Revenue</p>
			</div>
		</div> 
	</div>
</div> <!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
			$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
      	header: {
      		left: '',
      		center: 'title'
      	},
      	buttonText: {
      		today: 'today',
      		month: 'month'          
      	}        
      });


  });
</script>

<?php require_once 'includes/footer.php'; ?>