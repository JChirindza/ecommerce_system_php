<?php require_once 'includes/header.php'; ?>

<?php

$user_id = Sys_Secure($_SESSION['userId']);
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

// ------------------- Total Earnings - this Year -----------------------
$thisYearRevenue = 0;
$sql = "SELECT SUM(paid) as totalThisYear FROM orders WHERE order_status = 1 AND YEAR(order_date) = YEAR(CURRENT_TIMESTAMP)";
$orderYearQuery = $connect->query($sql);
$orderYearResult = $orderYearQuery->fetch_assoc();
$thisYearRevenue = $orderYearResult['totalThisYear'];
// ----------------------------------------------------------------------

// ------------------- Total Earnings - this MONTH -----------------------
$thisMonthRevenue = 0;

$sql = "SELECT SUM(paid) as totalThisMonth FROM orders WHERE order_status = 1 AND YEAR(order_date) = YEAR(CURRENT_TIMESTAMP) AND MONTH(order_date) = MONTH(CURRENT_TIMESTAMP)";
$orderMonthQuery = $connect->query($sql);
$orderMonthResult = $orderMonthQuery->fetch_assoc();
$thisMonthRevenue = $orderMonthResult['totalThisMonth'];
// ----------------------------------------------------------------------


$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.name, users.surname, users.email, users.permittion, SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 AND users.type = 1 AND users.status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$clientwisesql = "SELECT users.name, users.surname, users.email, users.active , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 AND users.type = 2 AND users.status = 1 GROUP BY orders.user_id";
$clientwiseQuery = $connect->query($clientwisesql);
$clientwieseOrder = $clientwiseQuery->num_rows;

// ------------------- Pending Requests -----------------------
$pendingRequestSql = "SELECT * FROM requests WHERE active = 1";
$pendingRequestQuery = $connect->query($pendingRequestSql);
$countPendingRequests = $pendingRequestQuery->num_rows;

$connect->close();

?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}

	a .card:hover {
		background: #f8f9fa;
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
	<h1 class="text-muted"><?php echo $language['dashboard']; ?></h1>
	<a href="orders.php?p=manord" class="d-none d-sm-inline-block btn btn-sm btn-primary"><i class="fas fa-cogs fa-sm text-white-50"></i> <?php echo $language['manage-orders']; ?></a>
</div>

<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 3) { ?>
	<div class="row">

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $language['earnings']; ?> (<?php echo $language['total']; ?>)</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($totalRevenue) {
								echo number_format($totalRevenue,2,",",".");
							} else {
								echo '0';
							} ?> <label class="text-muted">Mt</label></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-coins fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Earnings (YEAR) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo $language['earnings']; ?> ( <label class="text-muted"><?php echo date('Y'); ?></label> )</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($thisYearRevenue) {
								echo number_format($thisYearRevenue,2,",",".");
							}else{
								echo '0';
							} ?> <label class="text-muted">Mt</label></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Earnings (Month) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1"><?php echo $language['earnings']; ?> ( <label class="text-muted"><?php echo date('M-Y'); ?></label> )</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($thisMonthRevenue) {
								echo number_format($thisMonthRevenue,2,",",".");
							}else{
								echo '0';
							} ?> <label class="text-muted">Mt</label></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Pending Requests Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><?php echo $language['pending-req']; ?></div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countPendingRequests; ?></div>
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
			<a href="products.php?p=manprod" class="text-xs font-weight-bold" style="text-decoration:none;color:black;">
				<div class="card card-success">
					<div class="card-body">
						<div class="d-sm-flex align-items-center justify-content-between">
							<label><?php echo $language['total']; ?> <?php echo $language['products']; ?></label>
							<span class="badge-secondary badge-pill"><?php echo $countProduct; ?></span>	
						</div>
					</div> 
				</div> 
			</a>
		</div> <!--/col-md-4-->

		<div class="col-md-4 pt-2 mb-4">
			<a href="products.php?p=manprod" class="font-weight-bold text-xs font-weight-bold" style="text-decoration:none;color:black;">
				<div class="card card-danger">
					<div class="card-body">

						<div class="d-sm-flex align-items-center justify-content-between">
							<label><?php echo $language['low-stock']; ?></label>
							<span class="badge-secondary badge-pill"><?php echo $countLowStock; ?></span>	
						</div>

					</div> 
				</div> 
			</a>
		</div> <!--/col-md-4-->
	<?php } ?>  

	<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 2) { ?>
		<div class="col-md-4 pt-2 mb-4">
			<a href="orders.php?p=manord"  class="text-xs font-weight-bold" style="text-decoration:none;color: black;">
				<div class="card">
					<div class="card-body">
						<div class="d-sm-flex align-items-center justify-content-between">
							<label><?php echo $language['total']; ?> <?php echo $language['orders']; ?></label>
							<span class="badge-secondary badge-pill font-weight-bold"><?php echo $countOrder; ?></span>
						</div>
					</div> 
				</div>
			</a>
		</div> <!--/col-md-4-->
	<?php } ?>  
</div>

<?php  if(isset($_SESSION['userId']) && $result['permittion'] != 2) { ?>
	<div class="col-12 pt-2 mb-4 p-0">
		<div class="card">
			<div class="card-header bg-white text-xs font-weight-bold"> <i class="fas fa-calendar"></i> <?php echo $language['users-orders']; ?> <label class="badge badge-secondary"><?php echo $language['employees']; ?></label></div>
			<div class="card-body">
				<table class="table table-responsive table-hover" id="userWiseOrderTable">
					<thead>
						<tr>			  			
							<th style="width:25%;"><?php echo $language['name']; ?></th>
							<th style="width:25%;"><?php echo $language['surname']; ?></th>
							<th style="width:25%;"><?php echo $language['email']; ?></th>
							<th style="width:10%;"><?php echo $language['type']; ?></th>
							<th style="width:15%;">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $orderResult['name']?></td>
								<td><?php echo $orderResult['surname']?></td>
								<td><?php echo $orderResult['email']?></td>
								<td><?php if($orderResult['permittion'] == 1){ ?>
									<label class="badge badge-success"><?php echo $language['admin']; ?></label>
								<?php }elseif ($orderResult['permittion'] == 2) { ?>
									<label class="badge badge-primary"><?php echo $language['manager']; ?></label>
								<?php }elseif ($orderResult['permittion'] == 3) { ?>
									<label class="badge badge-info"><?php echo $language['vendor']; ?></label>
								<?php } ?>
							</td>
							<td><?php echo number_format($orderResult['totalorder'],2,",",".")?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>	
	</div>
</div> 
<?php } ?>

<div class="col-12 pt-2 mb-4 p-0">
	<div class="card">
		<div class="card-header bg-white text-xs font-weight-bold"> <i class="fas fa-calendar"></i> <?php echo $language['users-req']; ?> <label class="badge badge-secondary"><?php echo $language['clients']; ?></label></div>
		<div class="card-body">
			<table class="table table-responsive table-hover" id="clientWiseOrderTable">
				<thead>
					<tr>			  			
						<th style="width:25%;"><?php echo $language['name']; ?></th>
						<th style="width:25%;"><?php echo $language['surname']; ?></th>
						<th style="width:25%;"><?php echo $language['email']; ?></th>
						<th style="width:25%;"><?php echo $language['status']; ?></th>
						<th style="width:25%;">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($orderResult = $clientwiseQuery->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $orderResult['name']?></td>
							<td><?php echo $orderResult['surname']?></td>
							<td><?php echo $orderResult['email']?></td>
							<td><?php if($orderResult['active'] == 1){ ?>
								<label class="badge badge-success"><?php echo $language['active']; ?></label>
							<?php }elseif ($orderResult['active'] == 2) { ?>
								<label class="badge badge-secondary"><?php echo $language['inactive']; ?></label>
							<?php } ?>
						</td>
						<td><?php echo number_format($orderResult['totalorder'],2,",",".")?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>	
</div>
</div>

<div class="row">
	<div class="col-md-4 pt-2 mb-4">
		<div class="card">
			<div class="card-header bg-white">
				<h1><i class="fas fa-calendar-alt"></i> <?php echo date('d'); ?></h1>
			</div>
			<div class="card-body">
				<p><?php echo date('l') .', '.date('d').' - '.date('M').' - '.date('Y'); ?></p>
			</div>
		</div> 
	</div>

	<div class="col-md-4 pt-2 mb-4">
		<div class="card">
			<div class="card-header bg-white">
				<h1><?php if($totalRevenue) {
					echo number_format($totalRevenue,2,",",".");
				} else {
					echo '0';
				} ?></h1>
			</div>

			<div class="card-body">
				<p> <?php echo $language['total-revenue']; ?></p>
			</div>
		</div> 
	</div>
</div>

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