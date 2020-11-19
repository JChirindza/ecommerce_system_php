<?php

require_once 'php_action/db_connect.php';

if(isset($_POST["action"])) {

	$sql = " SELECT * FROM product WHERE  categories_id = '1' AND active = '1' ORDER BY RAND() limit 8";

	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
		$sql .= " AND rate BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."' ";
	}
	
	if(isset($_POST["brand"])) {
		$brand_filter = implode("','", $_POST["brand"]);
		$sql .= " AND brand_id IN('".$brand_filter."') ";
	}

	$result = $connect->query($sql);

	$output = '';
	if($result->num_rows > 0) { 
		foreach($result as $row) {

			$brandID = $row['brand_id'];

			$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
			$query2 = $connect->query($sql2);
			$result2 = $query2->fetch_assoc();

			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div class="product-entry">
					<div class="product-img">
						<img src="src/'. $row['product_image'] .'" class="img-fluid" style="height: 200px; " >
					</div>
					<div class="product-brand">By '. $result2['brand_name'] .' </div>
					<div class="product-name card-body">
						<p align="center"><strong><a href="#" class="" data-toggle="tooltip" title="'. $row['product_name'] .'">'. $row['product_name'] .'</a></strong></p>
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

						<h5 style="text-align:center;" class="text-danger" >'. number_format($row['rate'], 2). " Mt" .' </h5>
					</div>
					<div class="cart">
						<a href="#" class="add-to-cart" data-toggle="tooltip" title="Adicionar ao carrinho.">
							<i class="fas fa-cart-arrow-down"></i>
						</a>
					</div>
					<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
				</div>
			</div>
			';
		}
	} else {
		$output = '<h3>No Data Found</h3>';
	}
	
	echo $output;
}

?>

