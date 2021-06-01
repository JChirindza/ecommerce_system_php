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
				<li class="breadcrumb-item"><a href="cart.php?c=cart">Cart</a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=cartItems&i=<?php echo $_GET['i']; ?>">Cart items</a></li>
				<li class="breadcrumb-item active">Checkout</li>
			</ol>
		</div>

		<div class="card border-0 row">
			<div class="col-md-12 col-md-offset-1">
				<div class="process-wrap mt-4">
					<a href="cart.php?c=cartItems&i=<?php echo $_GET['i']; ?>">
						<div class="process text-center active">
							<p><span><i class="fas fa-check"></i></span></p>
							<label>Cart items</label>
						</a>
					</div>
					<div class="process text-center active">
						<p  class="next"><span><i class="fas fa-check"></i></span></span></p>
						<label>Checkout</label>
					</div>
					<div class="process text-center">
						<p><span>03</span></p>
						<label>Finalize</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-2 mt-md-4 mt-lg-4">
			<div class="checkout col-sm p-4 bg-white">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h4><i class="fas fa-list"></i> Checkout</h4>
				</div>
				<hr>
				<div class="row">

					<div class="cart-detail col-sm-12 col-md-8 col-lg-8 mb-3">
						<h5>Selected items</h5>
						<ul class="pl-4">
							<?php 
							$count = 0;
							$total = 0;

							$sql = "SELECT * FROM cart_item WHERE cart_id = {$_GET['i']}";
							$resultado = mysqli_query($connect, $sql);

							while ($dados = mysqli_fetch_array($resultado)) { 
								$sql2 = "SELECT * FROM product WHERE product_id = {$dados['product_id']} ";
								$query = $connect->query($sql2);
								$resultProduct = $query->fetch_assoc();
								$total += $resultProduct['rate'] * $dados['quantity']; 
								?>
								<li>
									<ul>
										<li><span class="text-muted" data-toggle="tooltip" title="<?php echo $resultProduct['product_name']; ?>"><?php echo $dados['quantity'].' x '.$resultProduct['product_name']; ?></span> <span data-toggle="tooltip" title="<?php echo $dados['quantity'].' x '.number_format($resultProduct['rate'],2,",","."); ?>"> <?php echo number_format($resultProduct['rate'] * $dados['quantity'],2,",","."); ?> Mt</span>
										</li>
									</ul>
								</li>
								<?php
							}
							?>
						</ul>
					</div>

					<div class="col-sm-12 col-md-4 col-lg-4">
						<h5 class="">Payment options <label class="badge badge-pill badge-secondary pl-4 pr-4">Finalize</label></h5>
						<label class="text-muted pl-3"><i class="fas fa-info-circle mr-2"></i>Choose one of the following options to finalize:</label>
						<div class="row pl-4 d-flex justify-content-start">
							<div class="btn btn-danger p-lg-3 m-lg-2 mpesa border rounded-lg" title="Vodacom Mpesa">
								<label class="font-weight-bold pl-4 pr-4"><i class="fas fa-mobile-alt fa-2x pr-md-2 pr-lg-2"></i>Mpesa</label>
							</div>
							<div class="btn btn-info p-lg-3 m-lg-2 paypal border rounded-lg" title="Paypal" >
								<label class="font-weight-bold pl-4 pr-4"><i class="fab fa-paypal fa-2x pr-md-2 pr-lg-2"></i>Paypal</label>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="d-flex justify-content-center">
					<div class=" col-md-push-1 text-center">
						<div class="grand-total border p-4">
							<span>
								<strong class="text-muted">Total: </strong>
							</span> 
							<span id="subTotal" class="font-weight-bold"><?php echo number_format($total, 2,",","."); ?> Mt</span>
						</div>
						<div class="">
							<p><a href="cart.php?c=cartItems&i=<?php echo $_GET['i']; ?>" class="btn btn-primary rounded-0"> <i class="fas fa-arrow-alt-circle-left mr-4"></i>Back to Cart </a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script src="custom/js/cart.js"></script> -->

<?php require_once 'includes/footer.php'; ?>