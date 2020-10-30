<?php require_once 'includes/header.php'; ?>

<?php 

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

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Relatorios</h1>
</div>

<div class="row">
	<div class="col-md-6 mb-4">
		<div class="row">

			<div class="col-md-6 pt-2 mb-4">
				<div class="card shadow-sm ">
					<div class="card-body">
						<a href="#"  class="text-xs font-weight-bold" style="text-decoration:none;color:black;">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label>Total de pedidos</label>
								<span class="badge-secondary badge-pill font-weight-bold"><?php echo $countOrder; ?></span>
							</div>
						</a>
					</div> 
				</div>
			</div> <!--/col-md-4-->
			<div class="col-md-6 pt-2 mb-4">
				<div class="card card-danger shadow-sm ">
					<div class="card-body">
						<a href="#" class="font-weight-bold text-xs font-weight-bold" style="text-decoration:none;color:black;">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label>Mais pedidos</label>
								<span class="badge-secondary badge-pill"><?php echo $countLowStock; ?></span>	
							</div>
						</a>
					</div> 
				</div> 
			</div> <!--/col-md-4-->
		</div>
		<div class="card shadow-sm">

			<div class="card-header">
				<i class="fas fa-chart-area"></i> Relatorio de Pedidos
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="php_action/getOrderReport.php" method="post" id="getOrderReportForm">
					<div class="form-group">
						<label for="startDate" class="col-sm-4 control-label">Start Date</label>
						<div class="col-sm">
							<input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date" />
						</div>
					</div>
					<div class="form-group">
						<label for="endDate" class="col-sm-4 control-label">End Date</label>
						<div class="col-sm">
							<input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="fas fa-print"></i> Generate Report</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /col-dm-12 -->

	<div class="col-md-6 mb-4">
		<div class="row">

			<div class="col-md-6 pt-2 mb-4">
				<div class="card shadow-sm ">
					<div class="card-body">
						<a href="#"  class="text-xs font-weight-bold" style="text-decoration:none;color:black;">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label>Total de Compras</label>
								<span class="badge-secondary badge-pill font-weight-bold"><?php echo $countOrder; ?></span>
							</div>
						</a>
					</div> 
				</div>
			</div> <!--/col-md-4-->
			<div class="col-md-6 pt-2 mb-4">
				<div class="card card-danger shadow-sm ">
					<div class="card-body">
						<a href="#" class="font-weight-bold text-xs font-weight-bold" style="text-decoration:none;color:black;">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label>Mais pedidos</label>
								<span class="badge-secondary badge-pill"><?php echo $countLowStock; ?></span>	
							</div>
						</a>
					</div> 
				</div> 
			</div> <!--/col-md-4-->
		</div>
		<div class="card shadow-sm">
			<div class="card-header">
				<i class="fas fa-chart-area"></i> Relatorio de Compras
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="php_action/getOrderReport.php" method="post" id="getOrderReportForm">
					<div class="form-group">
						<label for="startDate" class="col-sm-4 control-label">Start Date</label>
						<div class="col-sm">
							<input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date" />
						</div>
					</div>
					<div class="form-group">
						<label for="endDate" class="col-sm-4 control-label">End Date</label>
						<div class="col-sm">
							<input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="fas fa-print"></i> Generate Report</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /col-dm-12 -->
</div>
<!-- /row -->

<script src="custom/js/report.js"></script>

<script type="text/javascript">
	$(function () {
		// top bar active
		$('#navReport').addClass('active');
	});
</script>

<?php require_once 'includes/footer.php'; ?>