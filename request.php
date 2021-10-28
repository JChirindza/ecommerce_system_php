<?php 
require_once 'includes/header.php'; 

if($_GET['r'] == 'manreq') { 
	echo "<div class='div-request div-hide'>manreq</div>";
} else if($_GET['r'] == 'respreq') { 
	echo "<div class='div-request div-hide'>respreq</div>";
} // /else manage requests


// GET User data
$user_id = Sys_Secure($_SESSION['userId']);
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

// ------------------- Pending Requests -----------------------
$sql = "SELECT * FROM requests WHERE active = 1";
$query = $connect->query($sql);
$countPendingRequests = $query->num_rows;

// Responded today
$sql = "SELECT * FROM requests WHERE active = 2 AND DATE(dt_responded) = CURRENT_DATE";
$query = $connect->query($sql);
$countRespondedToday = $query->num_rows;

// Requested today
$sql = "SELECT * FROM requests WHERE DATE(dt_requested) = CURRENT_DATE";
$query = $connect->query($sql);
$countRequestedToday = $query->num_rows;

$sql = "SELECT * FROM requests";
$query = $connect->query($sql);
$countTotalRequests = $query->num_rows;
?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
		<li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
		<li class="breadcrumb-item active"><?php echo $language['requests'] ?></li>
		<li class="breadcrumb-item active" aria-current="page">
			<?php if($_GET['r'] == 'manreq') {
				echo $language['manage-requests'];	
			} else if($_GET['r'] == 'respreq') {
				echo $language['respond-request'];
			} // /else manage requests ?>
		</li>
	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['requests'] ?></h1>
	<?php if($_GET['r'] == 'respreq') { ?>
		<a type="button" class="btn-primary btn-sm" href="request.php?r=manreq"><i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-requests'] ?> </a>
	<?php } ?>
</div>
<style type="text/css">

#productTable thead th{
	text-align: center;
}

.requestCount .active {
	border-bottom: 4px solid #007bff;
}

.requestCount .card:hover {
	border-bottom: 4px solid #007bff;
	cursor: pointer;
}

.requestCount label:hover {
	cursor: pointer;
}

</style>
<?php if($_GET['r'] == 'manreq') { ?>
	<div class="row requestCount">
		<div class="col-md-3 pt-2">
			<div class="card">
				<div class="card-body d-sm-flex align-items-center justify-content-between">
					<label><?php echo $language['pending-req']; ?></label>
					<span class="badge-warning badge-pill font-weight-bold"><?php echo $countPendingRequests; ?></span>
				</div> 
			</div> 
		</div> <!--/col-md-3 -->

		<div class="col-md-3 pt-2">
			<div class="card">
				<div class="card-body d-sm-flex align-items-center justify-content-between">
					<label><?php echo $language['responded-today']; ?></label>
					<span class="badge-success badge-pill font-weight-bold"><?php echo $countRespondedToday; ?></span>
				</div> 
			</div> 
		</div> <!--/col-md-3 -->

		<div class="col-md-3 pt-2">
			<div class="card">
				<div class="card-body d-sm-flex align-items-center justify-content-between">
					<label><?php echo $language['requested-today']; ?></label>
					<span class="badge-info badge-pill font-weight-bold"><?php echo $countRequestedToday; ?></span>
				</div> 
			</div> 
		</div> <!--/col-md-3 -->

		<div class="col-md-3 pt-2">
			<div class="card active">
				<div class="card-body d-sm-flex align-items-center justify-content-between">
					<label><?php echo $language['total-requests']; ?></label>
					<span class="badge-secondary badge-pill font-weight-bold"><?php echo $countTotalRequests; ?></span>
				</div> 
			</div> 
		</div> <!--/col-md-3 -->
	</div>
	<hr>
<?php } ?>
<div class="card shadow-sm mb-3">
	<div class="card-header bg-white">

		<?php if($_GET['r'] == 'manreq') { ?>
			<i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-requests'] ?>
		<?php } else if($_GET['r'] == 'respreq') { ?>
			<div class="d-flex justify-content-between">
				<label class="m-0"><i class="fas fa-edit"></i> <?php echo $language['respond-request'] ?></label>
				<label class="badge badge-warning badge-pill d-none" id="pending_req"><?php echo $language['pending-request'] ?></label>
				<label class="badge badge-success badge-pill d-none" id="req_responded"><?php echo $language['responded'] ?></label>
			</div>
		<?php } ?>

	</div>
	<div class="card-body">

		<?php if($_GET['r'] == 'manreq') { // manage requests ?>

			<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
				<table class="table table-hover" id="manageRequestTable">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo $language['requested-on'] ?></th>
							<th><?php echo $language['client-name'] ?></th>
							<th><?php echo $language['contact'] ?></th>
							<th><?php echo $language['total-items'] ?></th>
							<th><?php echo $language['payment-type'] ?></th>
							<th><?php echo $language['status'] ?></th>
							<th><?php echo $language['options'] ?></th>
						</tr>
					</thead>
				</table>
			</div>
			<?php // /else respond request
		} else if($_GET['r'] == 'respreq') { // get request ?>
			
			<?php 
			$cartHasPaidId;
			if (isset($_GET['i'])) {
				$cartHasPaidId = $_GET['i'];
			}

			$sql = "SELECT 
					    cart_has_paid.cart_has_paid_id,
					    cart_has_paid.dt_paid, 
					    users.name, 
					    users.surname, 
					    clients.contact,
					    cart_has_paid.sub_total,
					    cart_has_paid.vat,
					    cart_has_paid.total_amount,
					    cart_has_paid.discount,
					    cart_has_paid.grand_total,
					    cart_has_paid.payment_type,
					    (SELECT active 
								FROM requests 
								WHERE cart_has_paid_id = cart_has_paid.cart_has_paid_id) 
								AS active,
						(SELECT dt_requested 
								FROM requests 
								WHERE cart_has_paid_id = cart_has_paid.cart_has_paid_id) 
								AS dt_requested,
					    (SELECT dt_responded 
								FROM requests 
								WHERE cart_has_paid_id = cart_has_paid.cart_has_paid_id) 
								AS dt_responded
					FROM cart_has_paid
						INNER JOIN cart ON cart_has_paid.cart_id = cart.cart_id 
						INNER JOIN clients ON cart.user_id = clients.user_id 
						INNER JOIN users ON clients.user_id = users.user_id
					WHERE cart_has_paid_id = {$cartHasPaidId} ORDER BY cart_has_paid_id DESC";

			$result = $connect->query($sql);
			$data = $result->fetch_array();
			?>

			<div class="success-messages"></div> <!--/success-messages-->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="clientName" class="col-sm control-label"><?php echo $language['client-name'] ?>:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="clientName" name="clientName" placeholder="<?php echo $language['client-name'] ?>" autocomplete="off" value="<?php echo $data['name']." ".$data['surname']?>" disabled/>
						</div>
					</div> <!--/form-group-->
					<div class="form-group">
						<label for="clientContact" class="col-sm control-label">Client Contact:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="<?php echo $language['client-number'] ?>" autocomplete="off" value="<?php echo $data['contact']; ?>" disabled/>
						</div>
					</div> <!--/form-group-->	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm control-label"><?php echo $language['requested-on'] ?>:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" autocomplete="off" value="<?php echo $data['dt_requested'] ?>" disabled/>
						</div>
					</div> <!--/form-group-->

					<div class="form-group">
						<label class="col-sm control-label"><?php echo $language['responded-on'] ?>:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="respondedOn" id="respondedOn" disabled autocomplete="off" value="<?php echo $data['dt_responded'] ?>" />
						</div>
					</div> <!--/form-group-->
				</div>
			</div>
			<hr>
			<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2 mb-4">
				<table class="table table-hover" id="requestedItemTable">
					<thead>
						<tr>
							<th style="width:15%;"><?php echo $language['product-image'] ?></th>			  			
							<th style="width:40%;"><?php echo $language['product-name'] ?></th>
							<th style="width:10%;"><?php echo $language['quantity'] ?></th>
							<th style="width:10%;"><?php echo $language['price'] ?></th>			  			
							<th style="width:15%;"><?php echo $language['total'] ?></th>			  			
						</tr>
					</thead>
				</table>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="subTotal" class="col-sm-4 control-label"><?php echo $language['sub-amount'] ?>:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="subTotal" name="subTotal" disabled value="<?php echo number_format($data['sub_total'],2,",","."); ?>" />
						</div>
					</div> <!--/form-group-->			  
					<div class="form-group">
						<label for="vat" class="col-sm-4 control-label gst"><?php echo $language['vat']." ".number_format($data['vat'] * 100) ?> %:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vat" name="vat" disabled value="<?php echo number_format($data['sub_total'] * $data['vat'],2,",","."); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="totalAmount" class="col-sm-4 control-label"><?php echo $language['total-amount'] ?>:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled value="<?php echo number_format($data['total_amount'],2,",","."); ?>" />
						</div>
					</div> <!--/form-group-->			  

				</div> <!--/col-md-6-->

				<div class="col-md-6">
					<div class="form-group">
						<label for="discount" class="col-sm-4 control-label"><?php echo $language['discount'] ?>:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="discount" name="discount" autocomplete="off" value="<?php echo number_format($data['discount'],2,",","."); ?>" disabled/>
						</div>
					</div> <!--/form-group-->	

					<div class="form-group">
						<label for="grandTotal" class="col-sm-4 control-label"><?php echo $language['grand-total'] ?>:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-lg border-success" id="grandTotal" name="grandTotal" disabled value="<?php echo number_format($data['grand_total'],2,",",".") ?> MZN"  />
						</div>
					</div> <!--/form-group-->

					<div class="form-group">
						<label for="clientContact" class="col-sm-4 control-label"><?php echo $language['payment-type'] ?>:</label>
						<div class="col-sm-8">
							<select class="form-control" name="paymentType" id="paymentType" disabled>
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1" <?php if($data['payment_type'] == 1) {
									echo "selected";
								} ?>  >Mpesa</option>
								<option value="2" <?php if($data['payment_type'] == 2) {
									echo "selected";
								} ?> >Credit/Debit Card</option>
							</select>
						</div>
					</div> <!--/form-group-->							  
				</div> <!--/col-md-6-->
			</div>

			<div class="form-group editButtonFooter">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" name="cartHasPaidId" id="cartHasPaidId" value="<?php echo $_GET['i']; ?>" />
					<input type="hidden" name="responded" id="responded" value="<?php echo $data['active'] ?>">

					<button onclick="confirm_request(<?php echo $_GET['i']; ?>)" id="confirmRequestBtn" data-loading-text="Loading..." class="btn btn-success"><i class="fas fa-save"></i> <?php echo $language['confirm-request'] ?></button>
				</div>
			</div>
		<?php } // /get order else  ?>
	</div> <!--/card-->	
</div> <!--/card-->	

<script type="text/javascript">
	
	var responded = $('#responded').val();

	if (responded == 2) { // responded == 2 | confirmed
		$('#confirmRequestBtn').addClass('d-none');
		$('#req_responded').removeClass('d-none');
	}else{
		$('#respondedOn').val('Waiting for confirmation...');
		$('#pending_req').removeClass('d-none');
	}
</script>

<script src="custom/js/request.js"></script>

<?php require_once 'includes/footer.php'; ?>
