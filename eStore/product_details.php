<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['details'] ?></li>
			</ol>
		</div>
		
		<div class="row mt-2 mt-md-0 mt-lg-0">
			<div class="col-sm-12 bg-white p-3 productDetails">
				<h4><i class="fas fa-list"></i> <?php echo $language['prod-details'] ?> </h4>

				<!-- Product Details -->
				<?php  
				$product_id = Sys_Secure($_GET['product_id']);
				$sql = " SELECT * FROM product WHERE product_id = {$product_id} ";

				$result = $connect->query($sql);

				$output = '';
				if($result && $result->num_rows > 0) { 
					foreach($result as $row) {

						$brandID = $row['brand_id'];

						$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
						$query2 = $connect->query($sql2);
						$result2 = $query2->fetch_assoc();

						?>
						<div class="product-entry-details">
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="row">
										<div class="d-flex col-md-2 col-lg-1 p-0 ml-1 d-md-inline d-lg-inline">
											<a href="#">
												<div class="product-img-2 m-0">
													<img src="../src/<?php echo $row['product_image']; ?>" class="img-fluid" style="height: 40px; " >
												</div>
											</a>

											<a href="#">
												<div class="product-img-2 m-0">
													<img src="../src/<?php echo $row['product_image']; ?>" class="img-fluid" style="height: 40px; " >
												</div>
											</a>

											<a href="#">
												<div class="product-img-2 m-0">
													<img src="../src/<?php echo $row['product_image']; ?>" class="img-fluid" style="height: 40px; " >
												</div>
											</a>
										</div>
										<div class="col-sm-12 col-md-9 col-lg-10 product-img-details">
											<img src="../src/<?php echo $row['product_image']; ?>" class="img-fluid" style="height: 250px; " >
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="product-name-details">
										<p><strong><?php echo $row['product_name']; ?></strong></p>

									</div>
									<div id="add-to-cart-messages_<?php echo $product_id; ?>"></div>
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="product-brand-details"><?php echo $language['brand'].' '.$result2['brand_name']; ?> </div>

											<div class="product-stars-details">
												<h6>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="far fa-star"></i>
												</h6>
											</div>

											<div class="product-price-details">
												<h5><?php echo number_format($row['rate'],2,",","."); ?><label class="text-muted">Mt</label></h5>
											</div>

										</div>

										<div class="col-md-6 col-lg-6 mt-4">
											<div class="form-group col-12 m-0 p-0">
												<label for="quantity" class="col-sm-4 control-label"><?php echo $language['quantity'] ?>: </label>
												<div class="col-sm-8">
													<input type="number" class="form-control font-weight-bold" id="quantity" placeholder="<?php echo $language['quantity'] ?>" name="quantity" autocomplete="off" min="1" max="<?php echo $row['quantity']; ?>" value="1">
													<label class="text-muted font-weight-light"><?php echo $language['available'] ?>: <?php echo $row['quantity']; ?></label>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-5 p-0">
										<div class="cart mt-4">
											<a class="btn btn-sm add-to-cart" id="addToCartBtn" onclick="addProductToCart(<?php echo $product_id; ?>);" data-loading-text="Loading..." autocomplete="off" title="Adicionar ao carrinho"><i class="fas fa-cart-arrow-down"></i>
											</a>
										</div>
									</div>
									<input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>" />
								</div>
							</div>
						</div>
						<?php
					}
				}else {
					echo $output = '<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
					<h5 class="p-5 text-muted">'.$language['no-data-found'].'</h5></div>
					';
				}
				?>
			</div>
		</div>
		
		<div class="row mt-2 mt-md-3 mt-lg-4">
			<div class="col-md-6 col-lg-6 bg-white p-3 technicalDetails">
				<h4><i class="fas fa-info-circle"></i> <?php echo $language['technical-details'] ?> </h4>
				<div class="table-responsive">
					<table class="table" id="productDetailsTable">
						<tbody class="border">
							<?php
							$x = 1;
							$product_id = $_GET['product_id'];

							$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id} LIMIT 8";

							$resultado = mysqli_query($connect, $sql);
							if (mysqli_num_rows($resultado) > 0){
								while ($dados = mysqli_fetch_array($resultado)){
									?>
									<tr>
										<td width="4%" class="bg-light text-muted border"><?php echo $x ?></td>
										<td width="48%" class="bg-light"><?php echo $dados['detail'];?></td>
										<td width="48%"><?php echo $dados['description'];?></td>
									</tr>

									<?php 
									$x++;
								} 
							}else{
								?>
								<tr class="text-center">
									<td></td>
									<td width="100%"><?php echo $language['no-data-found'] ?>.</td>
									<td></td>
								</tr>
								<!-- fim do IF -->
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6 col-lg-6 bg-white p-3 productDesctiption">
				<h4><i class="fas fa-info-circle"></i> <?php echo $language['product-description'] ?> </h4>
				<div class="row product_description m-2">
					<!-- Product description -->
					<textarea readonly class="form-control border-0" style="max-height: 440px; min-height: 220px; background: transparent;" id="product_description" name="product_description"></textarea>

					<style type="text/css">
						/* width */
						textarea::-webkit-scrollbar {
							width: 8px;
							height: 4px;
						}

						/* Track */
						textarea::-webkit-scrollbar-track {
							background: #f1f1f1; 
						}

						/* Handle */
						textarea::-webkit-scrollbar-thumb {
							background: #dee2e6; 
							border-radius: 0.3rem;
						}

						/* Handle on hover */
						textarea::-webkit-scrollbar-thumb:hover {
							background: #c3c3c4; 
						}
						.product_description:hover { background: #f8f9fa; }
						.product_description textarea:focus {
							box-shadow: unset;
						}</style>

					</div>
				</div>
			</div>

			<div class="row mt-2 mt-md-3 mt-lg-4">
				<div class="col-12 bg-white p-3 relatedProducts">
					<h4><i class="fas fa-network-wired"></i> <?php echo $language['related-products'] ?> </h4>

					<!-- Produtos Relacionados -->
					<div class="row related_products"></div>
				</div>
			</div>
			<div class="row mt-2 mt-md-3 mt-lg-4">
				<div class="col-sm-12 bg-white p-3 compareSimilars">
					<h4><i class="fas fa-network-wired"></i> <?php echo $language['compare-w-similar'] ?> </h4>

					<!-- Compare with Similar -->
					<div class="row compare_similar"></div>
					<div class="table-responsive table-hover">
						<table class="table" id="compareSimilarDetailsTable">
							<thead>
								<tr>						
									<?php 

									$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id}";
									$result = mysqli_query($connect, $sql);

									if ($result) {
										$prodResult = mysqli_fetch_array($result);
										if ($prodResult) {
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
													<a href="product_details.php?product_id=<?php echo $related_products['product_id']; ?>">
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
												<?php 
										} // /while
									} // /if($prodResul)
								} // if($result)
								?>
							</tr>
						</thead>
						<tbody class="border-left border-bottom">
							<?php
							$x = 1;
							$product_id = Sys_Secure($_GET['product_id']);

							$sql = "SELECT * FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.active = 1 AND product.product_id = {$product_id}";

							$resultado = mysqli_query($connect, $sql);
							if (mysqli_num_rows($resultado) > 0){
								while ($dados = mysqli_fetch_array($resultado)){
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
								}
							}else{
								?>
								<tr class="text-center">
									<td width="100%"><?php echo $language['nothing-to-compare-no-similar-prod-found'] ?>.</td>
								</tr>
								<!-- fim do IF -->
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Related Product -->
<script type="text/javascript" src="custom/js/product.js"></script>
<script type="text/javascript" src="custom/js/cart.js"></script>
<?php require_once 'includes/footer.php'; ?>