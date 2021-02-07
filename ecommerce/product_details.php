<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-md-2 m-lg-4">

		<div class="row">
			<div class="col-sm-12 bg-white p-3 productDetails">
				<h4><i class="fas fa-list"></i> Detalhes do Produto </h4>

				<!-- Product Details -->
				<?php require_once 'php_action/fetchProductDetails.php'; ?>
			</div>
		</div>
		
		<div class="row mt-1 mt-md-3 mt-lg-4">
			<div class="col-md-6 col-lg-6 bg-white p-3 technicalDetails">
				<h4><i class="fas fa-info-circle"></i> Detalhes técnicos </h4>
				<div class="table-responsive">
					<table class="table" id="productDetailsTable">
						<thead class="bg-light border">
							<tr>							
								<th width="5%">#</th>
								<th width="45%" class="text-center">Detalhe</th>
								<th class="text-center">Description</th>
							</tr>
						</thead>
						<tbody class="border">
							<?php
							$x = 1;
							$product_id = $_GET['product_id'];

							$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id}";

							$resultado = mysqli_query($connect, $sql);
							if (mysqli_num_rows($resultado) > 0):
								while ($dados = mysqli_fetch_array($resultado)):
									?>
									<tr>
										<td class="bg-light text-muted border"><?php echo $x ?></td>
										<td class="bg-light"><?php echo $dados['detail'];?></td>
										<td><?php echo $dados['description'];?></td>
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
								</tr>
								<!-- fim do IF -->
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6 col-lg-6 bg-white p-3 productDesctiption">
				<h4><i class="fas fa-info-circle"></i> Descricao do produto </h4>
				<div class="row product_description m-2">
					<li>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>
					<br>
					<li>2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>
					<br>
					<li>3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>
					<br>
					<li>4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>
					<br>
					<li>5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>
				</div>
			</div>
		</div>

		<div class="row mt-1 mt-md-3 mt-lg-4">
			<div class="col-12 bg-white p-3 relatedProducts">
				<h4><i class="fas fa-network-wired"></i> Produtos Relacionados </h4>

				<!-- Produtos Relacionados -->
				<div class="row related_products"></div>
			</div>
		</div>
		<div class="row mt-1 mt-md-3 mt-lg-4">
			<div class="col-sm-12 bg-white p-3 compareSimilars">
				<h4><i class="fas fa-network-wired"></i> Compare com Semelhantes </h4>

				<!-- Compare with Similar -->
				<div class="row compare_similar"></div>
				<div class="table-responsive table-hover">
					<table class="table" id="productDetailsTable">
						<thead>
							<tr>						
								<?php 

								$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id}";
								$result = mysqli_query($connect, $sql);
								$prodResult = mysqli_fetch_array($result)
								?>

								<th width="20%" class="text-center border-0"></th>
								<th width="20%" class="text-center border border-primary">
									<img src="../src/<?php echo $prodResult['product_image']; ?>" class="img-fluid" style="height: 100px; " >
									<div class="product-stars">
										<h6>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="far fa-star"></i>
										</h6>
									</div>
									<div class="product-price"><?php echo number_format($prodResult['rate'],2,",",".") ?><label class="text-muted">Mt</label></div>
								</th>

								<?php 

								$sql = "SELECT * FROM product WHERE categories_id = {$prodResult['categories_id']} AND active  = 1 AND product_id != {$product_id} ORDER BY RAND() limit 3";
								$result = mysqli_query($connect, $sql);

								while ($related_products = mysqli_fetch_array($result)) { 
									?>
									<th width="20%" class="text-center border similarProduct">
										<a href="product_details.php?product_id='<?php echo $related_products['product_id']; ?>'">
											<img src="../src/<?php echo $related_products['product_image']; ?>" class="img-fluid" style="height: 100px; " >
											<div class="product-stars">
												<h6>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="far fa-star"></i>
												</h6>
											</div>
											<div class="product-price"><?php echo number_format($related_products['rate'],2,",",".") ?><label class="text-muted">Mt</label></div>
										</a>
									</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody class="border">
							<?php
							$x = 1;
							$product_id = $_GET['product_id'];

							$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id}";

							$resultado = mysqli_query($connect, $sql);
							if (mysqli_num_rows($resultado) > 0):
								while ($dados = mysqli_fetch_array($resultado)):
									?>
									<tr>
										<td class="font-weight-bolder d-flex justify-content-center"><?php echo $dados['detail'];?></td>
										<td class="bg-light border"><?php echo $dados['description'];?></td>
										<td class="border"><?php echo $dados['description'];?></td>
										<td class="border"><?php echo $dados['description'];?></td>
										<td class="border"><?php echo $dados['description'];?></td>
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
								</tr>
								<!-- fim do IF -->
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Related Product -->
<script>
	$(document).ready(function(){

		related_products();

		function related_products(){
			$('.related_products').html('<div id="loading" style="" ></div>');
			var product_id = $('#product_id').val();
			
			$.ajax({
				url:"php_action/fetch_related.php",
				method:"POST",
				data:{product_id:product_id},
				success:function(data){
					$('.related_products').html(data);
				}
			});
		}
	});
</script>
<?php require_once 'includes/footer.php'; ?>