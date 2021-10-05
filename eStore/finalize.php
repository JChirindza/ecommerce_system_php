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
	// Payment options
	$(document).ready(function(){
		$("#flipDown").hide();

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

	// Discount
	$(document).ready(function(){
		$("#flipUp2").hide();

		$("#flipDown2").click(function(){
			$("#panel2").slideDown("slow");
			$("#flipDown2").hide();

			$("#flipUp2").show();
		});

		$("#flipUp2").click(function(){
			$("#panel2").slideUp("slow");
			$("#flipDown2").show();

			$("#flipUp2").hide();    
		});
	});

	// Item 2
	$(document).ready(function(){
		$("#flipUpItem2").hide();
		$("#resultIndex2").hide();

		$("#flipDownItem2").click(function(){
			$("#item2").slideDown("slow");
			
			$("#flipDownItem2").hide();
			$("#resultIndex1").hide();

			$("#flipUpItem2").show();
			$("#resultIndex2").show();
		});

		$("#flipUpItem2").click(function(){
			$("#item2").slideUp("slow");
			
			$("#flipDownItem2").show();
			$("#resultIndex1").show();

			$("#flipUpItem2").hide(); 
			$("#resultIndex2").hide();
		});
	});
</script>

<style> 
/*Payment options && discount*/
#flipDown:hover, #flipUp:hover, 
#flipDown2:hover, #flipUp2:hover {
	background: #f8f9fa;
	color: blue;
	cursor: pointer;
	opacity: 90%;
}

#flipDownItem2:hover, #flipUpItem2:hover {
	background: #f8f9fa;
	color: blue;
	cursor: pointer;
	opacity: 90%;
}

/*Discount*/
#panel2, #item2, #resultIndex2 {
	display: none;
}
</style>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=carts"><?php echo $language['carts'] ?></a></li>
				<li class="breadcrumb-item"><a href="cart.php?c=cartItems&i=<?php echo $cartId; ?>"><?php echo $language['cart-items'] ?></a></li>
				<li class="breadcrumb-item"><a href="checkout.php"><?php echo $language['checkout'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['finalize'] ?></li>
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
						
						<form class="form-horizontal mx-0 px-0" id="submitDeliveryAddressForm" action="php_action/ctrl_delivery_address.php?action=editAddress" method="POST" enctype="multipart/form-data">

							<div class="form-group mt-4">
								<div class="row">
									<div class="form-group col-sm-10 col-md-5">
										<label for="name" class="control-label"><?php echo $language['name'] ?></label>

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
								<label for="country" class="col-sm-6 control-label px-0"><?php echo $language['country'] ?>: </label>
								
								<div class="col-sm-10 px-0">
									<select class="form-control" id="country" name="country" disabled>
										<option value="1"><?php echo $language['mozambique'] ?></option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="province" class="col-sm-6 control-label px-0"><?php echo $language['province'] ?>: </label>
								
								<div class="col-sm-10 px-0">
									<select class="form-control" id="province" name="province" required>
										<option value="">~~<?php echo $language['select'] ?>~~</option>
										<option value="1">Maputo Cidade</option>
										<option value="2">Maputo Provincia (Matola)</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="address" class="col-sm-6 control-label px-0"><?php echo $language['address'] ?>: </label>
								
								<div class="col-sm-10 px-0">
									<input type="text" class="form-control" id="address" placeholder="<?php echo $language['address'] ?>" name="address" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="referencePoint" class="col-sm-6 control-label px-0"><?php echo $language['reference-point'] ?>: </label>
								
								<div class="col-sm-10 px-0">
									<input type="text" class="form-control" id="referencePoint" placeholder="<?php echo $language['reference-point'] ?>" name="referencePoint" autocomplete="off" required>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="postalCode" class="col-sm-6 control-label px-0"><?php echo $language['postal-code'] ?>: </label>
								
								<div class="col-sm-10 px-0">
									<input type="text" class="form-control" id="postalCode" placeholder="<?php echo $language['postal-code'] ?>" name="postalCode" autocomplete="off" required>
								</div>
							</div> <!-- /form-group-->

							<!-- Success messages -->
							<div class="form-group ">
								<div class="updateDeliveryAddressMessages col-sm-10 px-0"></div>
							</div>

							<button type="submit" class="btn btn-success rounded-0" id="updateAddressBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button> 
						</form>
					</div>

					<div class="cart-detail col-sm-12 col-md-6 col-lg-6 mb-3 mt-4 mt-md-0 mt-lg-0">
						<h5 class=""><?php echo $language['order-resume'] ?></h5>
						<div class="select-itens mt-4">
							<?php  
							$sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId}";
							$query = $connect->query($sql);
							$totalItems = $query->num_rows;

							$limit = 3;
							if ($totalItems <= 3) {
								$limit = $totalItems;
							}
							?>

							<h6><?php echo $language['cart-items']?> <span class="totalItems"> ( <?php echo $totalItems; ?> )</span></h6>
							<ul>
								<?php 
								$count = 0;
								$total = 0;

								$sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId} LIMIT {$limit}";
								$resultado = mysqli_query($connect, $sql);

								while ($dados = mysqli_fetch_array($resultado)) { 

									$sql2 = "SELECT * FROM product WHERE product_id = {$dados['product_id']} ";
									$query = $connect->query($sql2);
									$resultProduct = $query->fetch_assoc();

									$total += $resultProduct['rate'] * $dados['quantity']; 

									echo '
									<li>
									<ul>
									<li><span class="text-muted" data-toggle="tooltip" title="'.$resultProduct['product_name'].'">'.$dados['quantity'].' x '.$resultProduct['product_name'].'</span> <span data-toggle="tooltip" title="'.$dados['quantity'].' x '.number_format($resultProduct['rate'],2,",",".").'"> '.number_format($resultProduct['rate'] * $dados['quantity'],2,",",".").' MTn</span>
									</li>
									</ul>
									</li>';
								}
								?>
							</ul>
							<span class="text-muted" id="resultIndex1" style="font-size: 12px;"><?php echo $language['showing']; if ($totalItems <= 0){echo " 0";}else{echo " 1";} ?> - <?php echo $limit  ." ( ". $totalItems ?> total )</span>
							
							<?php if ($totalItems > 3){ ?>
								<ul id="item2">
									<?php 
									$count = 0;
									$total = 0;



									$sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId} LIMIT 3,$totalItems";
									$resultado = mysqli_query($connect, $sql);

									while ($dados = mysqli_fetch_array($resultado)) { 

										$sql2 = "SELECT * FROM product WHERE product_id = {$dados['product_id']} ";
										$query = $connect->query($sql2);
										$resultProduct = $query->fetch_assoc();

										$total += $resultProduct['rate'] * $dados['quantity']; 

										echo '
										<li>
										<ul>
										<li><span class="text-muted" data-toggle="tooltip" title="'.$resultProduct['product_name'].'">'.$dados['quantity'].' x '.$resultProduct['product_name'].'</span> <span data-toggle="tooltip" title="'.$dados['quantity'].' x '.number_format($resultProduct['rate'],2,",",".").'"> '.number_format($resultProduct['rate'] * $dados['quantity'],2,",",".").' MTn</span>
										</li>
										</ul>
										</li>';
									}
									?>
								</ul>
								
								<span class="text-muted" id="resultIndex2" style="font-size: 12px;"><?php echo $language['showing'] ?> 1 - <?php echo $totalItems ." ( ".$totalItems ?> total )</span>
							<?php } ?>
							
						</div>

						<div class="flipUpDownItem2">
							<?php if ($totalItems > 3) { ?>
								<div id="flipDownItem2" class="text-center" title="<?php echo $language['click-to-view-all'] ?>">
									<i class="fas fa-angle-down"></i>
								</div>

								<div id="flipUpItem2" class="text-center" title="<?php echo $language['click-to-view-less'] ?>">
									<i class="fas fa-angle-up"></i>
								</div>
							<?php } ?>
						</div>

						<div class="pr-4 d-flex justify-content-end">
							<span>
								<strong class="text-muted"><?php echo $language['total'] ?>: </strong>
							</span>
							<span id="subTotal" class="font-weight-bold pl-2"> <?php echo number_format($total, 2,",","."); ?> MTn</span>
						</div>
						
						<div class="payment-options mt-4">
							<hr>
							<h6><?php echo $language['payment-options'] ?></h6>
							<div class="row" id="panel">
								<!-- Limite 25 000 MTn -->
								<div class="mpesa col-4" title="M-pesa Max: 25.000,00 MTn"><img class="col-12 m-0 p-0" src="../assests/images/app/mpesa.png"></div>
								<div class="visa col-4" title="Visa"><img class="col-12 m-0 p-0" src="../assests/images/app/visa.png"></div>
								<div class="mastercard col-4" title="Mastercard"><img class="col-12 m-0 p-0" src="../assests/images/app/mastercard.png"></div>
							</div>

							<div class="flipUpDown">
								<div id="flipDown" class="text-center" title="<?php echo $language['click-to-slide-down'] ?>">
									<i class="fas fa-angle-down"></i>
								</div>

								<div id="flipUp" class="text-center" title="<?php echo $language['click-to-slide-up'] ?>">
									<i class="fas fa-angle-up"></i>
								</div>
							</div>

							<!--  -->
							<style> .box{ display: none; }</style>

							<script>
								$(document).ready(function(){
									$('input[type="radio"]').click(function(){
										var inputValue = $(this).attr("value");
										var targetBox = $("." + inputValue);
										$(".box").not(targetBox).hide();
										$(targetBox).show();
									});
								});

								$(document).ready(function(){
									if($("input:radio[name='paymentType']").is(":checked")) {
										var inputValue = $("input[name='paymentType']:checked").val();
										var targetBox = $("." + inputValue);
										$(".box").not(targetBox).hide();
										$(targetBox).show();
									}
								});
							</script>

							<div class="col-sm-10 mx-0 px-0 mt-4">

								<div class="form-check mx-0 px-0">
									<label><input type="radio" name="paymentType" value="payWithMpesa" title="Mpesa" <?php if ($total <= 25000) {echo"checked";}else{echo "disabled"; } ?>> MPesa (Maximo 25000,00 MTn)</label>
									</div>

									<div class="form-check mx-0 px-0">
										<label><input type="radio" name="paymentType" value="payWithcard" title="Cartão de Débito/Crédito" <?php if ($total > 25000){echo "checked";} ?>> Cartão de Débito/Crédito</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
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

						<div class="discount-options col-sm-12 col-md-6 col-lg-6">
							<hr>
							<h5>Descontos</h5>

							<div class="discount" id="panel2">

								<form class="form-horizontal" id="changeClientContactForm" action="php_action/ctrl_client.php.php?action=editContact" method="POST" enctype="multipart/form-data">

									<div class="form-group mt-4">
										<label class="control-label">Insira o codigo:</label>
										<div class="select-options">
											<input type="text" name="discount" id="discountCode" placeholder="Codigo de desconto" class="form-control col-sm-12 col-md-8 col-lg-8">
										</div>
									</div>

									<button type="submit" class="btn btn-success rounded-0" id="updateContactBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
								</form>
							</div>

							<div id="flipDown2" class="text-center" title="<?php echo $language['click-to-slide-down'] ?>">
								<i class="fas fa-angle-down"></i>
							</div>

							<div id="flipUp2" class="text-center mt-1" title="<?php echo $language['click-to-slide-up'] ?>">
								<i class="fas fa-angle-up"></i>
							</div>
						</div>
					</div>

					<hr>
					<div class="row pt-4">
						<div class="col-6">
							<a href="checkout.php" class="btn btn-secondary rounded-0 py-2"> <i class="fas fa-arrow-alt-circle-left mr-2"></i><?php echo $language['checkout'] ?> </a>
						</div>
						<div class="col-6">
							<div class="d-flex justify-content-end">
								<button onclick="startPaymentTimer()" class="btn btn-success rounded-0 py-2" id="finalizePaymentModalBtn"> <?php echo $language['payment'] ?> <i class="fas fa-arrow-alt-circle-right ml-2"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- finalize payments Mpesa | Debit/credit card -->
	<div class="modal fade bg-light" tabindex="-1" role="dialog" id="finalizePaymentCardModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fas fa-check"></i> Payments </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">
					<div class="finalizeMessages"></div>
					<div class="form-group">
						<!-- Mpesa -->
						<div class="payWithMpesa box">

							<form class="form-horizontal mx-0 px-0" id="submitCardInformationForm" action="php_action/ctrl_cart.php?action=finalizePayment" method="POST" enctype="multipart/form-data">

								<h6 class="mx-2"><?php echo $language['payment-via-mpesa'] ?>. <label><?php echo $language['total-amount'] ?>:</label><span class="totalAmount align-items-end"><?php echo number_format($total, 2,",","."); ?> MTn</span>
								</h6>

								<hr>

								<div class="small timer d-flex justify-content-center"><span><i class="fas fa-clock"></i> Registration closes in <span id="time" class="font-weight-bolder">02:00</span> minutes!</span></div>
								<hr>
								<p class="small text-center"><i class="fas fa-info-circle"></i> Confirme via MPESA no pelo numero <span id="client_payment_contact" class="font-weight-bolder"><?php echo $resultClient['contact']; ?></span></p>

								<div class="form-group">
									<div class="d-flex justify-content-center"><label class=""> <?php echo $language['insert-the-payment-code'] ?>:</label></div>
									<div class="d-flex justify-content-center">
										<input type="text" class="form-control col-6" name="payment-code" id="payment-code" placeholder="<?php echo $language['payment-code']; ?>" required>
									</div>
								</div>

								<div class="pt-4 d-flex justify-content-center">
									<button type="submit" class="btn btn-success col-6" id="submitPaymentForm" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['pay'] ?></button>
								</div>

								<!-- paymentType -->
								<input type="text" name="paymentType" id="paymentTypeValue" value="1" hidden>
								<!-- SubTotal -->
								<input type="text" name="subTotal" id="subTotal" value="<?php echo $total; ?>" hidden>
							</form>
						</div><!-- /. payWithMpesa -->

						<!-- Credit/Debit card -->
						<div class="payWithcard box">
							
							<h6 class="mx-2 my-4"><?php echo $language['payment-via-crdt-debit-card'] ?></h6>
							
							<form class="form-horizontal mx-0 px-0" id="submitCardInformationForm" action="php_action/ctrl_cart.php?action=finalizePayment" method="POST" enctype="multipart/form-data">

								<div class="form-group mb-0 pb-0">
									<label for="cardNumber" class="col-sm-6 control-label px-0"><?php echo $language['card-number'] ?>: </label>

									<input type="text" class="form-control rounded" id="cardNumber" name="cardNumber" autocomplete="off">
								</div> <!-- /form-group-->

								<div class="form-group row mt-0 pt-0 col-6">
									<div class="visa col-4" title="Visa"><img class="col-12 m-0 p-0 shadow-sm" src="../assests/images/app/visa.png"></div>
									<div class="mastercard col-4" title="Mastercard"><img class="col-12 m-0 p-0 shadow-sm" src="../assests/images/app/mastercard.png"></div>
								</div>

								<div class="row form-group mt-4">
									<div class="col-6 col-md-5 col-lg-5">
										<label for="expirationMonth" class="control-label px-0"><?php echo $language['expiration-month'] ?>: </label>

										<div class="px-0">
											<select class="form-control rounded" id="expirationMonth" name="expirationMonth">
												<option value="">~~<?php echo $language['select'] ?>~~</option>
												<option value="1">Janeiro</option>
												<option value="2">Fevereiro</option>
												<option value="3">Marco</option>
												<option value="4">Abril</option>
												<option value="5">Maio</option>
												<option value="6">Junho</option>
												<option value="7">Julho</option>
												<option value="8">Agosto</option>
												<option value="9">Septembro</option>
												<option value="10">Octubro</option>
												<option value="11">Novembro</option>
												<option value="12">Dezembro</option>

											</select>
										</div>
									</div> <!-- /form-group-->

									<div class="col-6 col-md-5 col-lg-5">
										<label for="expirationYear" class="control-label px-0"><?php echo $language['expiration-year'] ?>: </label>

										<div class="px-0">
											<select class="form-control rounded" id="expirationYear" name="expirationYear">
												<option value="">~~<?php echo $language['select'] ?>~~</option>
												<option value="2021">2021</option>
												<option value="2022">2022</option>
												<option value="2023">2023</option>
												<option value="2024">2024</option>
											</select>
										</div>
									</div> <!-- /form-group -->
								</div>

								<div class="form-group mt-4">
									<label for="holderName" class="control-label px-0"><?php echo $language['name-of-the-card-holder'] ?>: </label>

									<div class="col-sm-8 px-0">
										<input type="text" class="form-control rounded" id="holderName" name="holderName" autocomplete="off">
									</div>
								</div> <!-- /form-group-->

								<div class="form-group mb-0 pb-0 mt-4">
									<label for="securityCode" class="control-label px-0"><?php echo $language['security-code'] ?>: </label>

									<div class="col-6 col-md-4 col-lg-4 px-0">
										<input type="text" class="form-control rounded" id="securityCode" name="securityCode" autocomplete="off">
									</div>
								</div> <!-- /form-group-->

								<div class="form-group row text-muted mt-0 pt-0">
									<div class="visa col-1 pr-0" title="Visa"><img class="col-12 m-0 p-0" src="../assests/images/app/cvv_cvc_number.png"></div>
									<label for="securityCode" class="control-label px-0 mx-0 pt-1" style="font-size: 12px;">3 <?php echo $language['digits-on-the-back-of-the-card'] ?>.</label>
								</div> <!-- /form-group-->

								<div class="mt-4 d-flex justify-content-center">
									<button type="submit" class="btn btn-success col-6" id="submitPaymentForm" data-loading-text="Loading..."> <i class="fas fa-arrow-right"></i> <?php echo $language['pay'] ?></button>
								</div>

								<!-- paymentType -->
								<input type="text" name="paymentType" id="paymentTypeValue" value="2" hidden>
								<!-- SubTotal -->
								<input type="text" name="subTotal" id="subTotal" value="<?php echo $total; ?>" hidden>
							</form>
						</div><!-- /. payWithcard -->
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- /finalize payment -->

	<script>
		function startPaymentTimer() {

			function startTimer(duration, display) {
				var timer = duration, minutes, seconds;
				setInterval(function () {
					minutes = parseInt(timer / 60, 10)
					seconds = parseInt(timer % 60, 10);

					minutes = minutes < 10 ? "0" + minutes : minutes;
					seconds = seconds < 10 ? "0" + seconds : seconds;

					display.text(minutes + ":" + seconds);

					if (--timer < 0) {
						timer = duration;
					}
				}, 1000);
			}

			jQuery(function ($) {
				var twoMinutes = 60 * 2,
				display = $('#time');
				startTimer(twoMinutes, display);
			});

			setTimeout(function(){
			    $('#finalizePaymentCardModal').modal('hide')
			}, 120000); // 120000 = Two (2) minutes in milliseconds
		}
	</script>

	<script src="custom/js/delivery_address.js"></script>
	<script src="custom/js/client.js"></script>
	<script src="custom/js/cart.js"></script>

	<?php require_once 'includes/footer.php'; ?>