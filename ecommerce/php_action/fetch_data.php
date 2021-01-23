<?php

require_once 'db_connect.php';

if(isset($_POST["action"])) {
	if($_GET['category_id']){
		$categories_id = $_GET["category_id"];
		$sql = "SELECT * FROM product WHERE categories_id = {$categories_id} AND active = '1' ORDER BY RAND() limit 8";
	}else{
		$sql = " SELECT * FROM product WHERE active = '1' ORDER BY RAND() limit 8";
	}
	// if($_POST['action'] == "filter_computers"){
	// 	$sql = " SELECT * FROM product WHERE categories_id = '1' AND active = '1' ORDER BY RAND() limit 8";
	// }elseif ($_POST['action'] == "filter_hardware") {
	// 	$sql = " SELECT * FROM product WHERE categories_id = '2' AND active = '1' ORDER BY RAND() limit 8";
	// }elseif ($_POST['action'] == "filter_components") {
	// 	$sql = " SELECT * FROM product WHERE categories_id = '3' AND active = '1' ORDER BY RAND() limit 8";
	// }else{
	// $sql = " SELECT * FROM product WHERE active = '1' ORDER BY RAND() limit 8";
	// }

	$result = $connect->query($sql);

	$output = '';
	if($result->num_rows > 0) { 
		foreach($result as $row) {

			$brandID = $row['brand_id'];

			$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
			$query2 = $connect->query($sql2);
			$result2 = $query2->fetch_assoc();

			$output .= '
			<div class="col-md-3">
				<a href="product_details.php?product_id='. $row['product_id'] .'">
					<div class="product-entry">
						<div class="col-md-12 product-img" style="display: flex; justify-content: center; align-items: center;">
							<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 200px; " >
						</div>
						<div class="product-brand">Marca '. $result2['brand_name'] .' </div>
						<div class="product-name card-body">
							<p align="center"><strong><a href="product_details.php?product_id='. $row['product_id'] .'" class="" data-toggle="tooltip" title="'. $row['product_name'] .'">'. $row['product_name'] .'</a></strong></p>
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
							<a href="#" class="btn btn-sm add-to-cart" data-toggle="tooltip" title="Adicionar ao carrinho.">
								<i class="fas fa-cart-arrow-down"></i>
							</a>
						</div>
						<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
					</div>
				</a>
			</div>
			';
		}
	} else {
		$output = '<h3>No Data Found</h3>';
	}
	
	echo $output;
}

?>

