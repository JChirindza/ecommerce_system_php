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
<?php 
$cartId 	= Sys_Secure($_SESSION['cartId']);
$user_id 	= Sys_Secure($_SESSION['userId']);

$sql 	= "SELECT * FROM cart WHERE cart_id = {$cartId}";
$query 	= $connect->query($sql);
$resultCart = $query->fetch_assoc();

$sql 	= "SELECT * FROM users WHERE user_id = {$user_id}";
$query 	= $connect->query($sql);
$resultUser = $query->fetch_assoc();

$sql 	= "SELECT * FROM clients WHERE user_id = {$user_id}";
$query 	= $connect->query($sql);
$resultClient = $query->fetch_assoc();

$sql 	= "SELECT * FROM delivery_address WHERE client_id = (SELECT client_id FROM clients WHERE user_id = {$user_id} LIMIT 1)";
$query 	= $connect->query($sql);
$resultAddress = $query->fetch_assoc();

?>

<script> 
	$(document).ready(function(){
		$("#flipUp").hide();

		$("#flipDown").click(function(){
			$("#panel").slideDown("slow");
			$("#flipDown").hide();

			$("#flipUp").show();
		});

		$("#flipUp").click(function(){
			$("#panel").slideUp("slow");
			$("#flipDown").show();

			$("#flipUp").hide();    
		});
	});
</script>

<style> 
#panel {
	display: none;
}

#flipDown:hover, #flipUp:hover {
	background: #f8f9fa;
	cursor: pointer;
	opacity: 90%;
}
</style>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=carts"><?php echo $language['carts'] ?></a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=cartItems"><?php echo $language['cart-items'] ?></a></li>
				<li class="breadcrumb-item"><a href="checkout.php"><?php echo $language['checkout'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['finalize'] ?></li>
			</ol>
		</div>

		<div class="card border-0 row">
			<div class="col-md-12 col-md-offset-1">
				<div class="process-wrap mt-4">
					<div class="process text-center active">
						<a href="cart.php?c=cartItems">
							<p><span><i class="fas fa-check"></i></span></p>
							<label><?php echo $language['cart-items'] ?></label>
						</a>
					</div>
					<div class="process text-center active">
						<a href="checkout.php">
							<p><span><i class="fas fa-check"></i></span></p>
							<label><?php echo $language['checkout'] ?></label>
						</a>
					</div>
					<div class="process text-center">
						<p class="next"><span><i class="fas fa-check"></i></span></p>
						<label><?php echo $language['finalize'] ?></label>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-2 mt-md-4 mt-lg-4">
			<div class="checkout col-sm p-4 bg-white">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h4><i class="fas fa-list"></i> <?php echo $language['finalize'] ?></h4>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6">
						<h5><?php echo $language['delivery-address'] ?> <i class="fas fa-shipping-fast"></i></h5>
						
						<form class="form-horizontal" id="submitDeliveryAddressForm" action="php_action/ctrl_delivery_address.php?action=editAddress" method="POST" enctype="multipart/form-data">

							<div class="form-group px-3 mt-4">
								<div class="row">
									<div class="form-group col-sm-10 col-md-5">
										<label for="name" class="control-label"><?php echo $language['name'] ?>: </label>

										<div class="">
											<input type="text" class="form-control"  id="name" placeholder="<?php echo $language['name'] ?>" name="name" autocomplete="off" value="<?php echo $resultUser['name']; ?>" disabled>
										</div>
									</div> <!-- /form-group-->

									<div class="form-group col-sm-10 col-md-5">
										<label for="surname" class="control-label"><?php echo $language['surname'] ?>: </label>

										<div class="">
											<input type="text" class="form-control"  id="surname" placeholder="<?php echo $language['surname'] ?>" name="surname" autocomplete="off" value="<?php echo $resultUser['surname']; ?>" disabled>
										</div>
									</div> <!-- /form-group-->
								</div>
							</div> <!-- /form-group-->
							<div class="form-group">
								<label for="country" class="col-sm-6 control-label"><?php echo $language['country'] ?>: </label>
								
								<div class="col-sm-10">
									<select class="form-control" id="country" name="country" disabled>
										<option value="1"><?php echo $language['mozambique'] ?></option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="province" class="col-sm-6 control-label"><?php echo $language['province'] ?>: </label>
								
								<div class="col-sm-10">
									<select class="form-control" id="province" name="province" required>
										<option value="">~~<?php echo $language['select'] ?>~~</option>
										<option value="1">Maputo Cidade</option>
										<option value="2">Maputo Provincia (Matola)</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="address" class="col-sm-6 control-label"><?php echo $language['address'] ?>: </label>
								
								<div class="col-sm-10">
									<input type="text" class="form-control" id="address" placeholder="<?php echo $language['address'] ?>" name="address" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="referencePoint" class="col-sm-6 control-label"><?php echo $language['reference-point'] ?>: </label>
								
								<div class="col-sm-10">
									<input type="text" class="form-control" id="referencePoint" placeholder="<?php echo $language['reference-point'] ?>" name="referencePoint" autocomplete="off" required>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="postalCode" class="col-sm-6 control-label"><?php echo $language['postal-code'] ?>: </label>
								
								<div class="col-sm-10">
									<input type="text" class="form-control" id="postalCode" placeholder="<?php echo $language['postal-code'] ?>" name="postalCode" autocomplete="off" required>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group ">
								<div class="updateDeliveryAddressMessages col-sm-10"></div>
							</div>

							<button type="submit" class="btn btn-success ml-3 rounded-0" id="updateAddressBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button> 
						</form>
					</div>

					<div class="cart-detail col-sm-12 col-md-6 col-lg-6 mb-3 mt-4 mt-md-0 mt-lg-0">
						<h5 class=""><?php echo $language['order-resume'] ?></h5>
						<div class="select-itens mt-4">
							<h6>Cart items</h6>
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

						<div class="pr-4 d-flex justify-content-end">
							<span>
								<strong class="text-muted"><?php echo $language['total'] ?>: </strong>
							</span>
							<span id="subTotal" class="font-weight-bold pl-2"> <?php echo number_format($total, 2,",","."); ?> Mt</span>
						</div>
						
						<div class="payment-options mt-4 d-none d-sm-inline d-md-inline">
							<hr>
							<h6><?php echo $language['payment-options'] ?></h6>
							<div class="row" id="panel">
								<div class="row m-0">
									<!-- Limite 25 000 MTn -->
									<div class="mpesa col-4" title="M-pesa Max: 25.000,00 MTn"><img class="h-75" src="../assests/images/app/mpesa.png"></div>
									<div class="visa col-4" title="Visa"><img class="h-75" src="../assests/images/app/visa.png"></div>
									<div class="mastercard col-4" title="Mastercard"><img class="h-75" src="../assests/images/app/mastercard.png"></div>
								</div>

							</div>

							<div id="flipDown" class="text-center" title="Click to slide down panel">
								<i class="fas fa-angle-down"></i>
							</div>

							<div id="flipUp" class="text-center" title="Click to slide up panel">
								<i class="fas fa-angle-up"></i>
							</div>

							<div class="options mt-4">
								<div class="note">
									<label>Selecione uma das opcao para finalizar o pagamento.</label>
									<br>
									<label class="text-muted"><i class="fas fa-info-circle"></i> M-pesa max: 25.000,00 MTn</label>
								</div>

								<div class="select-options">
									<select class="form-control col-6">
										<option value="1" <?php if ($total > 25000) { echo "disabled"; } ?>>MPesa</option>
										<option value="2">Visa</option>
										<option value="3">Mastercard</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-6 col-lg-6">
					<hr>
					<h5 class=""><?php echo $language['contact'] ?> <i class="fas fa-shipping-fast"></i></h5>
					<div class="updateContactMessages"></div>
					<form class="form-horizontal" id="changeClientContactForm" action="php_action/ctrl_client.php.php?action=editContact" method="POST" enctype="multipart/form-data">
						<div class="form-group mt-4">

							<label for="contact" class="control-label"><?php echo $language['your-number'] ?>: </label>

							<div class="">
								<input type="text" class="form-control col-6"  id="contact" placeholder="<?php echo $language['contact'] ?>" name="name" autocomplete="off" value="<?php echo $resultClient['contact']; ?>" required>
							</div>
						</div>

						<button type="submit" class="btn btn-success rounded-0" id="updateContactBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
					</form>
				</div>

				<hr>
				<div class="row pt-4">
					<div class="col-6">
						<a href="checkout.php" class="btn btn-secondary rounded-0"> <i class="fas fa-arrow-alt-circle-left mr-2"></i><?php echo $language['checkout'] ?> </a>
					</div>
					<div class="col-6">
						<div class="d-flex justify-content-end">
							<button class="btn btn-success rounded-0" data-toggle="modal" id="finalizePaymentModalBtn" data-target="#finalizePaymentModal"> <?php echo $language['payment'] ?> <i class="fas fa-arrow-alt-circle-right ml-2"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- finalize payments -->
<div class="modal fade bg-light" tabindex="-1" role="dialog" id="finalizePaymentModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-check"></i> <?php echo $language['payment'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form class="form-horizontal" id="payCart" action="php_action/ctrl_cart.php?action=finalizePayment" method="POST">
				<div class="modal-body">
					<div class="finalizeMessages"></div>
					<div class="timer text-muted d-flex justify-content-center"><span><i class="fas fa-clock"></i> 120 sec.</span></div>
					<p class="text-muted px-sm-4"><i class="fas fa-info-circle"></i> Confirme o pagamento via MPESA no seu numero <span id="client_payment_contact" class="font-weight-bolder"><?php echo $resultClient['contact']; ?></span> e insira o codigo aqui.</p>

					<div class="form-group">
						<div class="d-flex justify-content-center"><label class=""> <?php echo $language['insert-the-payment-code'] ?>:</label></div>
						<div class="d-flex justify-content-center">
							<input type="text" class="form-control col-6" name="payment-code" id="payment-code" placeholder="<?php echo $language['payment-code']; ?>" required>
						</div>
					</div>

					<div class="pt-4 d-flex justify-content-center">
						<button type="submit" class="btn btn-success col-6" id="removeProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['pay'] ?></button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
					
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /finalize payment -->

<script src="custom/js/delivery_address.js"></script>
<script src="custom/js/client.js"></script>

<?php require_once 'includes/footer.php'; ?>