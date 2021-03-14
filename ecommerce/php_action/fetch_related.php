<?php

require_once 'db_connect.php';

if(isset($_POST["product_id"])) {

	$product_id = $_POST['product_id'];
	
	$sql1 = " SELECT * FROM product WHERE product_id = {$product_id} ";
	$query1 = $connect->query($sql1);
	$result1 = $query1->fetch_assoc();

	$sql = " SELECT * FROM product WHERE active = '1' AND categories_id = {$result1['categories_id']} AND product_id != {$product_id} ORDER BY RAND() limit 5";
	$result = $connect->query($sql);

	$output = '';
	if($result->num_rows > 0) { 
		foreach($result as $row) {
			$brandID = $row['brand_id'];

			$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
			$query2 = $connect->query($sql2);
			$result2 = $query2->fetch_assoc();

			$output .= '
			<div class="col-auto col-lg-2 p-0 mb-0">
				<a href="product_details.php?product_id='. $row['product_id'] .'">
					<div class="product-entry">
						<div class="product-img">
							<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 100px; " >
						</div>
						<div class="product-brand" style= "text-align: center;">Marca '. $result2['brand_name'] .' </div>
						
						<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
					</div>
				</a>
			</div>
			';
		}
	} else {
		$output = '<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
		<h5 class="p-5 text-muted">No Data Found</h5></div>';
	}
	
	echo $output;
}

?>

