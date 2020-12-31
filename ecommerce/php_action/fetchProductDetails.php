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
				<div class="product-entry p-3">
					<div class="row">
					<style>
						.product-img-2{
							border: 1px solid #dee2e6 !important;
						}

						.product-img-2:hover{
							border: 1px solid #6c757d !important;
							cursor: pointer
						}
					</style>
						<div class="col-md-6">
							<div class="col-md-12 product-img-details">
								<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 250px; " >
							</div>

							<div class="row pt-2 ml-2">
								<div class="col-md-2">
									<a href="#">
										<div class="product-img-2 p-2">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>
								</div>
								<div class="col-md-2">
									<a href="#">
										<div class="product-img-2 p-2">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>
								</div>
								<div class="col-md-2">
									<a href="#">
										<div class="product-img-2 p-2">
											<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 40px; " >
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
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
								<h5  >'. number_format($row['rate'], 2). " Mt" .' </h5>
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

