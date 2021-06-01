<?php require_once 'includes/header.php'; ?>
<?php  
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<div class="p-4">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			Nao tem permissao para aceder a esta pagina.
		</div>
		<div class="d-flex justify-content-center">
			<a href="../sign-in.php" class="btn btn-primary"><i class="fas fa-sign-in-alt pr-2"></i> Sign-in</a>
		</div>
	</div>
	<?php
	die();
}
?>
<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=carts">Carts</a></li>
				<?php if($_GET['c'] == 'cartItems') { ?>
					<li class="breadcrumb-item active">Cart items</li>
				<?php } ?>
			</ol>
		</div>

		<?php if($_GET['c'] == 'carts') { ?>
			<div class="card border-0 row">
				<div class="col-md-12 col-md-offset-1">
					<div class="process-wrap mt-4">
						<div class="process text-center active">
							<p><span><i class="fas fa-check"></i></span></p>
							<label>Cart items</label>
						</div>
						<div class="process text-center">
							<p  class="next"><span>02</span></p>
							<label>Checkout</label>
						</div>
						<div class="process text-center">
							<p><span>03</span></p>
							<label>Finalize</label>
						</div>
					</div>
				</div>
			</div>
		<?php } elseif($_GET['c'] == 'cartItems') { ?>
			<div class="card border-0 row">
				<div class="col-md-12 col-md-offset-1">
					<div class="process-wrap mt-4">
						<div class="process text-center active">
							<p><span><i class="fas fa-check"></i></span></p>
							<label>Cart items</label>
						</div>
						<div class="process text-center">
							<p class="next"><span><i class="fas fa-check"></i></span></p>
							<label>Checkout</label>
						</div>
						<div class="process text-center">
							<p><span>03</span></p>
							<label>Finalize</label>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		

		
		
		<div class="row mt-2 mt-md-4 mt-lg-4">
			<div class="col-sm-12 bg-white p-3 cart">
				<div class="card">
					<div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
						<?php if($_GET['c'] == 'carts') { // manage carts ?>
							<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cart-arrow-down"></i> Manage Carts</h6>
						<?php }elseif($_GET['c'] == 'cartItems'){ ?>
							<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cart-arrow-down"></i> Manage Cart Items</h6>
						<?php } ?>
						
					</div>
					<!-- Cart & cart items -->
					<?php if($_GET['c'] == 'carts') { // manage carts ?>
						<div class="card-body ">

							<div id="success-messages"></div>

							<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
								<table class="table border-bottom" id="manageCartsTable">
									<thead>
										<tr>		
											<th style="width:5%;">#</th>
											<th style="width:20%;">Created on</th>
											<th style="width:10%">Total Items</th>
											<th style="width:20%;">Payment Status</th>
											<th style="width:10%;">Option</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>

					<?php } else if($_GET['c'] == 'cartItems') { // cart ?> 

						<?php 
						$cartId = $_GET['i'];
						$sql = "SELECT * FROM cart WHERE cart_id = {$cartId}";
						$query = $connect->query($sql);
						$result = $query->fetch_assoc();
						?>
						<!-- <div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-list"></i> Manage Cart Items</h6>
							<label>Created on: <strong><?php echo $result['cart_date']; ?></strong></label>
						</div> -->

						<div class="card-body">

							<div id="success-messages"></div>

							<style type="text/css"> #manageCartItemTable th{ border-bottom: none; } </style>
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
								<hr>
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
									<div class="">
										<div class="row">
											<p><a href="home.php" class="btn btn-primary rounded-0"> Continue Shopping </a></p>
											<p><a href="checkout.php?i=<?php echo $cartId; ?>" class="btn btn-success rounded-0"> Checkout </a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>	
				</div>
			</div>
		</div>
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