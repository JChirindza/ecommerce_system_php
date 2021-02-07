<?php

require_once 'db_connect.php';


	$product_id = $_GET['product_id'];
	$sql = " SELECT * FROM product WHERE product_id = {$product_id} ";

	$result = $connect->query($sql);

	$output = '';
	if($result->num_rows > 0) { 
		foreach($result as $row) {

			$brandID = $row['brand_id'];

			$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
			$query2 = $connect->query($sql2);
			$result2 = $query2->fetch_assoc();

			$output .= '
				<div class="product-entry-details">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="row">
								<div class="d-flex col-md-2 col-lg-1 p-0 ml-1 d-md-inline d-lg-inline">
									<a href="#">
										<div class="product-img-2 m-0">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>

									<a href="#">
										<div class="product-img-2 m-0">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>

									<a href="#">
										<div class="product-img-2 m-0">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>
								</div>
								<div class="col-sm-12 col-md-9 col-lg-10 product-img-details">
									<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 250px; " >
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="product-name-details">
								<p><strong>'. $row['product_name'] .'</strong></p>
							</div>
							<div class="product-brand-details">Marca '. $result2['brand_name'] .' </div>

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
								<h5  >'. number_format($row['rate'],2,",",".").' <label class="text-muted">Mt</label></h5>
							</div>
							<div class="col-md-5 p-0">
								<div class="cart mt-4">
									<a href="#" class="btn btn-sm add-to-cart" title="Adicionar ao carrinho.">
										<i class="fas fa-cart-arrow-down"></i>
									</a>
								</div>
							</div>
							
						</div>
					</div>
					<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
				</div>
			';
		}
	
	
	echo $output;
}

?>