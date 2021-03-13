<?php require_once 'includes/header.php'; ?>

<?php 
	// $cartId = $_GET['i'];
$cartId = 1;
$sql = "SELECT * FROM cart WHERE cart_id = {$cartId}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=cart">Cart</a></li>
				<li class="breadcrumb-item active">Checkout</li>
			</ol>
		</div>

		<div class="card border-0 row">
			<div class="col-md-12 col-md-offset-1">
				<div class="process-wrap mt-4">
					<div class="process text-center active">
						<p><span><i class="fas fa-check"></i></span></p>
						<label>Carrinho de compras</label>
					</div>
					<div class="process text-center">
						<p  class="next"><span>02</span></p>
						<label>Pagamento</label>
					</div>
					<div class="process text-center">
						<p><span>03</span></p>
						<label>Finalizar</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2 mt-md-4 mt-lg-4">
			<div class="checkout col-sm p-4 bg-white">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h4><i class="fas fa-list"></i> Pagamento </h4>
				</div>
				
				<div class="row">
					
					<div class="cart-detail col-sm-12 col-md-7 col-lg-7">
						<h5>Total</h5>
						<ul>
							<?php 
							$count = 0;
							$total = 0;

							$sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId}";
							$resultado = mysqli_query($connect, $sql);

							while ($dados = mysqli_fetch_array($resultado)) { 

								$sql2 = "SELECT * FROM product WHERE product_id = {$dados['product_id']} ";
								$query = $connect->query($sql2);
								$resultProduct = $query->fetch_assoc();

								$total += $resultProduct['rate'] * $dados['quantity']; 
								
								echo '
								<li>
									<ul>
										<li><span class="text-muted" data-toggle="tooltip" title="'.$resultProduct['product_name'].'">'.$dados['quantity'].' x '.$resultProduct['product_name'].'</span> <span data-toggle="tooltip" title="'.$dados['quantity'].' x '.number_format($resultProduct['rate'],2,",",".").'"> '.number_format($resultProduct['rate'] * $dados['quantity'],2,",",".").' Mt</span>
										</li>
									</ul>
								</li>';
							}
							?>
						</ul>
					</div>

					<div class="col-sm-12 col-md-5 col-lg-5">
						<h5>Payment options</h5>
					</div>
				</div>
				
				<div class="d-flex justify-content-end">
					<div class=" col-md-push-1 text-center p-0 ">
						<div class="grand-total border pt-3">
							<p>
								<span>
									<strong class="text-muted">Total: </strong>
								</span> 
								<span id="subTotal" class="font-weight-bold"><?php echo number_format($total, 2,",","."); ?> Mt</span>
							</p>
						</div>
						<div class="">
							<div class="row">
								<p><a href="cart.php?c=cart" class="btn btn-primary rounded-0"> Back to Cart </a></p>
								<p><a href="#" class="btn btn-success rounded-0"> Finalize </a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script src="custom/js/cart.js"></script> -->

<?php require_once 'includes/footer.php'; ?></div>
</div>

<!-- <script src="custom/js/cart.js"></script> -->

<?php require_once 'includes/footer.php'; ?>