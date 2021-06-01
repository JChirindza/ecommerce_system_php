<?php require_once 'includes/header.php'; ?>

<div class="row pt-4">
	<div class="col-md-12">
		<?php if($_GET['c'] == 'carts') { // gerir carts ?>

			<div class="card">
				<div class="card-header bg-white">
					<h6 class="m-0 font-weight-bold text-muted">Manage Cart</h6>
				</div>

				<div class="card-body ">

					<div id="success-messages"></div>

					<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
						<table class="table border-bottom" id="manageCartsTable">
							<thead>
								<tr>		
									<th style="width:5%;">#</th>
									<th style="width:10%;">User Image</th>
									<th style="width:25%;">User name</th>
									<th style="width:20%;">Created </th>
									<th style="width:10%">Total Items</th>
									<th style="width:20%;">Payment Status</th>
									<th style="width:10%;">Option</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>

		<?php } else if($_GET['c'] == 'cartItems') { // cart ?> 

			<?php 
			$cartId = $_GET['i'];
			$sql = "SELECT * FROM cart WHERE cart_id = {$cartId}";
			$query = $connect->query($sql);
			$result = $query->fetch_assoc();
			?>
			<div class="card">
				<div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-list"></i> Manage Cart Items</h6>
					<label>Created on: <strong><?php echo $result['cart_date']; ?></strong></label>
				</div>

				<div class="card-body ">

					<div id="success-messages"></div>

					<style type="text/css">
						#manageCartItemTable th{
							border-bottom: none;
						}
					</style>
					<input type="text" hidden id="cartId" name="cartId" value="<?php echo $cartId; ?>">
					<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
						<table class="table border-bottom" id="manageCartItemTable">
							<thead>
								<tr>			
									<th style="width:10%;">Image</th> 			
									<th style="width:40%;">Product Name</th>
									<th style="width:15%;">Price</th>
									<th style="width:15%;">Quantity</th>			  			
									<th style="width:15%;">Total</th>			  			
									<th style="width:5%;">Remove</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="d-flex justify-content-end">
						<div class=" col-md-push-1 text-center p-0 ">
							<div class="grand-total border pt-3">
								<p>
									<span>
										<strong class="text-muted">Total: </strong>
									</span>
									<!-- <span id="subTotal" class="font-weight-bold"><?php echo number_format($total,2,",","."); ?> Mt</span> -->
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>	
	</div>
</div>

<!-- remove cart -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCartModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> Remove Cart</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeCartMessages"></div>

				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeCartFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-danger" id="removeCartBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->

<!-- remove cart item -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCartItemModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> Remove Cart Item</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeCartItemMessages"></div>

				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeCartItemFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-danger" id="removeCartItemBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove cart item-->

<script src="custom/js/cart.js"></script>
<?php require_once 'includes/footer.php'; ?>