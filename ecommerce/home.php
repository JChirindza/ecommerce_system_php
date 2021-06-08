<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-md-2 m-lg-4">

		<div class="row mt-2 mt-md-0 mt-lg-0">
			<div class="col-sm-4 col-md-3 col-lg-3 bg-white p-3">
				<h4 class=""><i class="fas fa-list"></i> Categories</h4>
				<div class="list-group list-group-flush">
					<?php  
					$sql = "SELECT categories_id, categories_name FROM categories WHERE categories_active = 1 LIMIT 3";
					$result = $connect->query($sql);
					if($result && $result->num_rows > 0) { 
						foreach($result as $categoryData) {
							?>
							<a href="#category_<?php echo $categoryData['categories_id']; ?>" class="mt-1 pt-1 pb-1 list-group-item list-group-item-action border rounded-pill"><?php echo $categoryData['categories_name']; ?></a>
							<?php  
						}
					}else{ ?>
						<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
							<h5 class="p-5 text-muted">No Data Found</h5></div>
							<?php
						}
						?>
					</div>
					<?php if (!isset($_SESSION['userId'])){ ?>
						<div class="d-flex justify-content-center mt-4">
							<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="Sign-in for a better experience."><i class="fas fa-unlock"></i> Login</a>
						</div>
					<?php } ?>
				</div>

				<div class="col-sm-8 col-md-6 col-lg-6">
					<div id="demo" class="carousel slide border" data-ride="carousel">

						<ul class="carousel-indicators">
							<li data-target="#demo" data-slide-to="0" class="active"></li>
							<li data-target="#demo" data-slide-to="1"></li>
							<li data-target="#demo" data-slide-to="2"></li>
							<li data-target="#demo" data-slide-to="3"></li>
							<li data-target="#demo" data-slide-to="4"></li>
						</ul>

						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="../assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="../assests/images/slide/s2.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="../assests/images/slide/s3.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="../assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
							</div>
							<div class="carousel-item">
								<img src="../assests/images/slide/s5.jpg" style="width:100%;height:250px;" alt="">
							</div>
						</div>

						<a class="carousel-control-prev" href="#demo" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</a>
						<a class="carousel-control-next" href="#demo" data-slide="next">
							<span class="carousel-control-next-icon"></span>
						</a>
					</div>					
				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 bg-white p-3 d-none d-md-inline d-lg-inline">
					<h4><i class="fas fa-list"></i> Categories</h4>
				</div>
			</div>

			<?php  
			$sql = "SELECT categories_id, categories_name FROM categories WHERE categories_active = 1 LIMIT 3";
			$result = $connect->query($sql);
			if($result && $result->num_rows > 0) { 
				foreach($result as $categoryData) {
					?>
					<div class="row mt-2 mt-md-3 mt-lg-4" id="category_<?php echo $categoryData['categories_id']; ?>">
						<div class="col-sm-12 bg-white p-3">
							<h4><i class="fas fa-list"></i> <?php echo $categoryData['categories_name']; ?> </h4>

							<!-- fetch Computers -->
							<div class="row fetch_computers">
								<?php  

								$sql2 = "SELECT p.*, b.brand_name FROM product AS p INNER JOIN brands AS b ON b.brand_id = p.brand_id WHERE p.active = '1' AND p.categories_id = {$categoryData['categories_id']} LIMIT 7";
								$result2 = $connect->query($sql2);
								if($result2 && $result2->num_rows > 0) {
									foreach($result2 as $productData) {
										?>
										<div class="col-md-3">
											<a href="product_details.php?product_id=<?php echo $productData['product_id'];?>">
												<div class="product-entry">
													<div class="col-md-12 product-img" style="display: flex; justify-content: center; align-items: center;">
														<img src="../src/<?php echo $productData['product_image']; ?>" class="img-fluid" style="height: 200px; " >
													</div>
													<div class="product-brand">Brand <?php echo $productData['brand_name']; ?> </div>
													<div class="product-name card-body">
														<p align="center"><strong><a href="product_details.php?product_id=<?php echo $productData['product_id']; ?>" class="" data-toggle="tooltip" title="<?php echo $productData['product_name']; ?>"><?php echo $productData['product_name']; ?></a></strong></p>
													</div>
													<div class="product-stars">
														<h6>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="far fa-star"></i>
														</h6>
													</div>
													<div class="product-price">

														<h5 style="text-align:center;" class="text-danger" ><?php echo number_format($productData['rate'], 2). " Mt"; ?></h5>
													</div>
													<div class="cart">
														<a href="#" class="btn btn-sm add-to-cart" data-toggle="tooltip" title="Add to cart">
															<i class="fas fa-cart-arrow-down"></i>
														</a>
													</div>
													<input type="hidden" name="product_id" id="product_id" value="<?php echo $productData['product_id']; ?>" />
												</div>
											</a>
										</div>
										<?php  
									}	
								}
								?>
							</div>
						</div>
						<div class="col-sm-12 view-more">
							<a href="productFilters.php?category_id=<?php echo $categoryData['categories_id']; ?>"><i class="fas fa-filter"></i> + View more</a>
						</div>
					</div>
					<?php  
				}
			}
			?>
		<!-- <div class="row mt-2 mt-md-3 mt-lg-4">
			<div class="col-sm-3 border bg-white p-3">
				<h4 class="text-muted"><i class="fas fa-list"></i> Categories</h4>
				<div class="list-group list-group-flush">
					<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
					<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
					<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
				</div>
			</div>
		</div> -->		
	</div>
</div>
<script type="text/javascript">
	// nav bar 
	$(".navHome").addClass('border-bottom');
</script>
<?php require_once 'includes/footer.php'; ?>