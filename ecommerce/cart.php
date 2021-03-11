<?php require_once 'includes/header.php'; ?>

<?php 
	// $cartId = $_GET['i'];
$cartId = 1;
$sql = "SELECT * FROM cart WHERE cart_id = {$cartId}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

?>

<div class="bg-white m-0 p-0 ml-4 mr-4">
	<ol class="breadcrumb bg-transparent m-0 p-1 pl-4">
		<li class="breadcrumb-item"><a href="home.php">Home</a></li>
		<li class="breadcrumb-item active">Cart</li>
	</ol>
</div>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-4">

		<?php if($_GET['c'] == 'carts') { // gerir carts ?>
			<div class="row mb-4">
				<div class="col-sm p-4 bg-white">
					<div class="d-sm-flex align-items-center justify-content-between">
						<h4><i class="fas fa-list"></i> Lista de Carrinhos </h4>
					</div>
					<style type="text/css">
						#productTable td, th {
							text-align: center;
						}
					</style>

					<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
						<table class="table border-bottom" id="manageCartsListTable">
							<thead>
								<tr>		
									<th style="width:5%;">#</th>
									<th style="width:40%;">Date</th>
									<th style="width:15%">Total Items</th>
									<th style="width:25%;">Payment Status</th>
									<th style="width:10%;">Opcoes</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		<?php } else if($_GET['c'] == 'cart') { // cart ?> 

			<div class="card border-0 row mb-4">
				<div class="col-md-12 col-md-offset-1">
					<div class="process-wrap mt-4">
						<div class="process text-center">
							<p class="next"><span>01</span></p>
							<label>Carrinho de compras</label>
						</div>
						<div class="process text-center">
							<p><span>02</span></p>
							<label>Pagamento</label>
						</div>
						<div class="process text-center">
							<p><span>03</span></p>
							<label>Finalizar</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm p-4 bg-white">
					<div class="d-sm-flex align-items-center justify-content-between">
						<h4><i class="fas fa-list"></i> Carrinho de Compras </h4>
						<label>Created on: <strong><?php echo $result['cart_date']; ?></strong></label>
					</div>
					<style type="text/css">
						#productTable td, th {
							text-align: center;
						}
					</style>

					<div class="table-responsive table-responsive-sm table-responsive-md table-hover pt-2">
						<table class="table border-bottom" id="manageCartTable">
							<thead>
								<tr>			
									<th style="width:10%;">Image</th> 			
									<th style="width:40%;">Product Name</th>
									<th style="width:15%;">Price</th>
									<th style="width:10%;">Quantity</th>			  			
									<th style="width:15%;">Total</th>			  			
									<th style="width:5%;">Remove</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$arrayNumber = 0;
								$x = 1;
								$total = 0;
								$sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId}";
								$resultado = mysqli_query($connect, $sql);

								if (mysqli_num_rows($resultado) > 0):
									while ($dados = mysqli_fetch_array($resultado)):

										$sql2 = "SELECT * FROM product WHERE product_id = {$dados['product_id']} ";
										$query = $connect->query($sql2);
										$resultProduct = $query->fetch_assoc();

										$total += $resultProduct['rate'] * $dados['quantity']; 
										?>
										<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  
											<td style="width:10%;"> <img src="<?php  echo $resultProduct['product_image']; ?>" class="w-100" style="height: 100px;"></td>
											<td style="width:40%;"><?php  echo $resultProduct['product_name']; ?></td>
											<td style="width:15%;" class="text-center">
												<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control border-0 bg-transparent text-center text-dark" value="<?php echo number_format($resultProduct['rate'],2,",","."); ?>" />
												<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $resultProduct['rate']; ?>" />
											</td>
											<td style="width:10%;" class="text-center">
												<input type="number" class="col-sm-12 col-md-10 col-lg-8" name="quantity[]" id="quantity<?php echo $x; ?>" id="quantity<?php echo $x; ?>" oninput="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" max="<?php echo $resultProduct['quantity']; ?>" value="<?php echo $dados['quantity']; ?>" required>

												<label class="text-muted" style="font-size: 14px;">Available: <?php echo $resultProduct['quantity']; ?></label>
											</td>
											<td style="width:15%;" class="text-center">
												<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control text-center bg-transparent border-0 text-dark" disabled="true" value="<?php  echo number_format($resultProduct['rate'] * $dados['quantity'],2,",","."); ?>"/>			  					
												<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php  echo number_format($resultProduct['rate'] * $dados['quantity'],2,",","."); ?>"/>
											</td>

											<td style="width:5%;">
												<!-- <button class="btn border text-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fas fa-trash"></i></button> -->
												<button class="btn btn-lg border-0 bg-transparent removeProductRowBtn" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fas fa-trash"></i></button>
											</td>
										</tr>
										<?php 
										$x++;
									endwhile; 
								else:
									?>
									<tr>
										<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>
									</tr>
									<!-- fim do IF -->
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<div class="d-flex justify-content-end">
						<div class=" col-md-push-1 text-center p-0 ">
							<div class="grand-total border pt-3">
								<p>
									<span>
										<strong class="text-muted">Total: </strong>
									</span>
									<span id="subTotal" class="font-weight-bold"><?php echo number_format($total,2,",","."); ?> Mt</span>
								</p>
							</div>
							<div class="">
								<div class="row">
									<p><a href="home.php" class="btn btn-primary rounded-0"> Continue Shopping </a></p>
									<p><a href="checkout.php" class="btn btn-success rounded-0"> Checkout </a></p>
								</div>
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

<script src="custom/js/cart.js"></script>

<?php require_once 'includes/footer.php'; ?>