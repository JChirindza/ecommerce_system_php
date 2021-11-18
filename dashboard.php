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

$orderSql = "SELECT * FROM orders WHERE order_status = 1 AND payment_status IN (1,2)"; // 1. Full payment 2. Advanced payment 
$orderQuery = $connect->query($orderSql);
$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

// ------------------- Total Earnings - this Year -----------------------
$thisYearRevenue = 0;
$sql = "SELECT SUM(paid) as totalThisYear FROM orders WHERE order_status = 1 AND payment_status IN (1,2) AND YEAR(order_date) = YEAR(CURRENT_TIMESTAMP)";
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

$userOrdersSql = "SELECT order_id, order_date, client_name, client_contact, grand_total, (SELECT COUNT(*) FROM order_item WHERE order_id = orders.order_id) as total_items FROM `orders` WHERE payment_status = 1 ORDER BY order_date DESC LIMIT 5";
$UserOrderQuery = $connect->query($userOrdersSql);
$userOrders = $UserOrderQuery->num_rows;

$clientwisesql = "SELECT chp.cart_has_paid_id, chp.dt_paid, 
users.name AS name, users.surname AS surname,
users.email,
clients.contact,
(SELECT COUNT(*) FROM cart_item_has_paid WHERE cart_item_has_paid.cart_has_paid_id = chp.cart_has_paid_id) AS total_items,
chp.grand_total
FROM `cart_has_paid` AS chp
INNER JOIN clients ON chp.client_id = clients.client_id 
INNER JOIN users ON users.user_id = clients.user_id";
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

<div class="row">

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
		<a href="products.php?p=manprod&qty=low" class="font-weight-bold text-xs font-weight-bold" style="text-decoration:none;color:black;">
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
</div>
<hr>
<div class="col-12 pt-2 mb-4 p-0">
	<div class="card">
		<div class="card-header bg-white text-xs font-weight-bold"> <i class="fas fa-calendar"></i> <?php echo $language['orders']; ?> <label class="badge badge-secondary"><?php echo $language['in-store']; ?></label></div>
		<div class="card-body">
			<div class="table-responsive table-hover">
				<table class="table" id="userWiseOrderTable">
					<thead>
						<tr>			  			
							<th style="width:20%;"><?php echo $language['order-date']; ?></th>
							<th style="width:25%;"><?php echo $language['client-name']; ?></th>
							<th style="width:15%;"><?php echo $language['contact']; ?></th>
							<th style="width:15%;"><?php echo $language['total-items']; ?></th>
							<th style="width:15%;"><?php echo $language['paid-amount']; ?></th>
							<th style="width: auto;"></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($orderResult = $UserOrderQuery->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $orderResult['order_date']?></td>
								<td><?php echo $orderResult['client_name']?></td>
								<td><?php echo $orderResult['client_contact']?></td>
								<td><?php echo $orderResult['total_items']?></td>
								<td><?php echo number_format($orderResult['grand_total'],2,",",".")?></td>
								<td class="d-flex justify-content-end"><a href="orders.php?p=editOrd&i=<?php echo $orderResult['order_id']; ?>" class="btn btn-sm btn-outline-success py-0"><i class="fas fa-eye"></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
</div> 
<hr>
<div class="col-12 pt-2 mb-4 p-0">
	<div class="card">
		<div class="card-header bg-white text-xs font-weight-bold"> <i class="fas fa-calendar"></i> <?php echo $language['requests']; ?> <label class="badge badge-secondary"><?php echo $language['online']; ?></label></div>
		<div class="card-body">
			<table class="table table-responsive table-hover" id="clientWiseOrderTable">
				<thead>
					<tr>			  			
						<th style="width:15%;"><?php echo $language['requested-on']; ?></th>
						<th style="width:25%;"><?php echo $language['client-name']; ?></th>
						<th style="width:25%;"><?php echo $language['email']; ?></th>
						<th style="width:10%;"><?php echo $language['contact']; ?></th>
						<th style="width:10%;"><?php echo $language['total-items']; ?></th>
						<th style="width:15%;"><?php echo $language['paid-amount']; ?></th>
						<th style="width: auto;"></th>
					</tr>
				</thead>
				<tbody>
					<?php while ($requestResult = $clientwiseQuery->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $requestResult['dt_paid']?></td>
							<td><?php echo $requestResult['name'].' '.$requestResult['surname']?></td>
							<td><?php echo $requestResult['email']?></td>
							<td><?php echo $requestResult['contact']?></td>
							<td><?php echo $requestResult['total_items']?></td>
							<td><?php echo number_format($requestResult['grand_total'],2,",",".")?></td>
							<td class="d-flex justify-content-end"><a class="btn btn-sm btn-outline-success py-0" href="request.php?r=respreq&i=<?php echo $requestResult['cart_has_paid_id'] ?>"><i class="fas fa-eye"></i></a></td>
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