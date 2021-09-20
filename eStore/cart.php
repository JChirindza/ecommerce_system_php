<?php require_once 'includes/header.php'; ?>
<?php  
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<div class="p-4">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			<?php echo $language['access-403'] ?>.
		</div>
	</div>
	<div class="d-flex justify-content-center mt-5">
		

		<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="Sign-in for a better experience."><i class="fas fa-unlock"></i> <?php echo $language['sign-in'] ?></a></a>
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
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=carts"><?php echo $language['carts'] ?></a></li>
				<?php if($_GET['c'] == 'cartItems') { ?>
					<li class="breadcrumb-item active"><?php echo $language['cart-items'] ?></li>
				<?php } ?>
			</ol>
		</div>

		<?php if($_GET['c'] == 'carts') { ?>
			<div class="card border-0 row">
				<div class="col-md-12 col-md-offset-1">
					<div class="process-wrap mt-4">
						<div class="process text-center">
							<p><span>01</span></p>
							<label><?php echo $language['cart-items'] ?></label>
						</div>
						<div class="process text-center">
							<p><span>02</span></p>
							<label><?php echo $language['checkout'] ?></label>
						</div>
						<div class="process text-center">
							<p><span>03</span></p>
							<label><?php echo $language['finalize'] ?></label>
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
							<label><?php echo $language['cart-items'] ?></label>
						</div>
						<div class="process text-center">
							<p class="next"><span>02</span></p>
							<label><?php echo $language['checkout'] ?></label>
						</div>
						<div class="process text-center">
							<p><span>03</span></p>
							<label><?php echo $language['finalize'] ?></label>
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
							<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-carts'] ?></h6>
						<?php }elseif($_GET['c'] == 'cartItems'){ ?>
							<h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-cart-items'] ?></h6>
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
											<th style="width:10%;"></th>
											<th style="width:20%;"><?php echo $language['created-on'] ?></th>
											<th style="width:10%"><?php echo $language['total-items'] ?></th>
											<th style="width:20%;"><?php echo $language['payment-status'] ?></th>
											<th style="width:10%;"><?php echo $language['option'] ?></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>

					<?php } else if($_GET['c'] == 'cartItems') { // cart ?> 

						<div class="card-body">

							<div id="success-messages"></div>
							<div class="update-cart-item-messages"></div>
							<style type="text/css"> #manageCartItemTable th{ border-bottom: none; } </style>
							<input type="text" hidden id="cartId" name="cartId" value="<?php echo Sys_Secure($_GET['i']); ?>">
							<div id="update-cart-item-messages"></div>
							<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
								<table class="table border-bottom" id="manageCartItemTable">

									<thead>
										<tr>			
											<th style="width:10%;"><?php echo $language['image'] ?></th> 			
											<th style="width:40%;"><?php echo $language['product-name'] ?></th>
											<th style="width:15%;"><?php echo $language['price'] ?></th>
											<th style="width:15%;"><?php echo $language['quantity'] ?></th>			  			
											<th style="width:15%;"><?php echo $language['total'] ?></th>			  			
											<th style="width:5%;"><?php echo $language['remove'] ?></th>
										</tr>
									</thead>
								</table>
								<hr>
								<label class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Este carrinho ja foi paga. Nao pode ser modificado!</label>
							</div>

							<div class="d-flex justify-content-end">
								<div class=" col-md-push-1 text-center p-0 ">
									<div class="grand-total border pt-3">
										<p>
											<span>
												<strong class="text-muted"><?php echo $language['total'] ?>: </strong>
											</span>
											<span id="subTotalValue_cartItem" class="font-weight-bold"></span>
										</p>
									</div>
									<div class="row">
										<p><a href="home.php" class="btn btn-primary rounded-0"> <?php echo $language['continue-shopping'] ?> </a></p>
										<p><a href="checkout.php" class="btn btn-success rounded-0"> <?php echo $language['checkout'] ?> </a></p>
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
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-cart'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeCartMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeCartFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-danger" id="removeCartBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> <?php echo$language['remove'] ?></button>
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
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-cart-item'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeCartItemMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeCartItemFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-danger" id="removeCartItemBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> <?php echo$language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove cart item-->

<script src="custom/js/cart.js"></script>
<script type="text/javascript">
	// nav bar 
	$(".navCart").addClass('border-bottom');
</script>
<?php require_once 'includes/footer.php'; ?>