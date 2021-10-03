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
				<li class="breadcrumb-item"><a href="cart.php?c=cartItems&i=<?php echo $cartId; ?>"><?php echo $language['cart-items'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['checkout'] ?></li>
			</ol>
		</div>

		<div class="card border-0 row">
			<div class="col-md-12 col-md-offset-1">
				<div class="process-wrap mt-4">
					<div class="process text-center active">
						<a href="cart.php?c=cartItems&i=<?php echo $cartId; ?>">
							<p><span><i class="fas fa-check"></i></span></p>
							<label><?php echo $language['cart-items'] ?></label>
						</a>
					</div>
					<div class="process text-center active">
						<p  class="next"><span><i class="fas fa-check"></i></span></span></p>
						<label><?php echo $language['checkout'] ?></label>
					</div>
					<div class="process text-center">
						<p><span>03</span></p>
						<label><?php echo $language['finalize'] ?></label>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-2 mt-md-4 mt-lg-4">
			<div class="checkout col-sm p-4 bg-white">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h4><i class="fas fa-list"></i> <?php echo $language['checkout'] ?></h4>
				</div>
				<hr>
				<div class="row">

					<div class="cart-detail col-sm-12 col-md-8 col-lg-8 mb-3">
						<h5><?php echo $language['selected-items'] ?></h5>
						<ul class="pl-4">
							<?php 
							$count = 0;
							$total = 0;

							$cartId = Sys_Secure($_SESSION['cartId']);

							// retorna somente produtos com quantidade em stock maior que zero.
							$sql = "SELECT * FROM cart_item AS c WHERE c.cart_id = {$cartId} AND (SELECT p.quantity FROM product AS p WHERE p.quantity > 0 AND p.product_id = c.product_id) ORDER BY `cart_item_id` DESC";
							$resultado = mysqli_query($connect, $sql);

							if ($resultado->num_rows > 0) {
								
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
							}else{
								?>
								<div class="text-center">
									<label class="text-muted">Nenhum item adicionado.</label>
								</div>
								<div class="d-flex justify-content-center">
									<a href="productFilters.php" class="btn btn-primary btn-sm rounded-0"><i class="fas fa-eye"></i> Visualizar produtos</a>
								</div>
								<?php
							}

							?>
						</ul>
						<div class="pr-2 d-flex justify-content-end">
							<span>
								<strong class="text-muted"><?php echo $language['total'] ?>: </strong>
							</span>
							<span id="subTotal" class="font-weight-bold pl-2"> <?php echo number_format($total, 2,",","."); ?> Mt</span>
						</div>
					</div>

					<div class="col-sm-12 col-md-4 col-lg-4">
						<h5 class=""><?php echo $language['payment-options'] ?></h5>
						
						<div class="row m-0">
							<!-- Limite 25 000 MTn -->
							<div class="mpesa col-4" title="M-pesa Max: 25.000,00 MTn"><img class="h-50" src="../assests/images/app/mpesa.png"></div>
							<div class="visa col-4" title="Visa"><img class="h-50" src="../assests/images/app/visa.png"></div>
							<div class="mastercard col-4" title="Mastercard"><img class="h-50" src="../assests/images/app/mastercard.png"></div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row mx-1">
					<div class="col-6">
						<a href="cart.php?c=cartItems&i=<?php echo $cartId; ?>" class="btn btn-outline-secondary rounded-0"> <i class="fas fa-arrow-alt-circle-left mr-2"></i><?php echo $language['back-to-cart'] ?> </a>
					</div>
					<div class="col-6 d-flex justify-content-end">
						<div class="d-inline">
							<a href="finalize.php" class="btn btn-success rounded-0 font-weight-bold"> <?php echo $language['finalize'] ?> <i class="fas fa-arrow-alt-circle-right ml-2"></i> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script src="custom/js/cart.js"></script> -->

<?php require_once 'includes/footer.php'; ?>