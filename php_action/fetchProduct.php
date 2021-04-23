<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
product.categories_id, product.quantity, product.rate, product.active, product.status, 
brands.brand_name, categories.categories_name FROM product 
INNER JOIN brands ON product.brand_id = brands.brand_id 
INNER JOIN categories ON product.categories_id = categories.categories_id  
WHERE product.status = 1 ORDER BY product_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
	$active = ""; 

	while($row = $result->fetch_array()) {
		$productId = $row[0];
 	// active 
		if($row[7] == 1) {
 		// activate member
			$active = "<label class='badge badge-success'>Available</label>";
		} else {
 		// deactivate member
			$active = "<label class='badge badge-danger'>Not Available</label>";
 	} // /else

 	$button = '<!-- Single button -->
 	<div class="btn-group">
 		<a href="produto.php?p=detail&i='.$productId.'" class="btn btn-outline-success btn-sm" id="productDetailsBtn"> <i class="fas fa-eye"></i></a>
	 	<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="fas fa-edit"></i></button>
	 	<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="fas fa-trash"></i></button>       
 	</div>';

	// $brandId = $row[3];
	// $brandSql = "SELECT * FROM brands WHERE brand_id = $brandId";
	// $brandData = $connect->query($sql);
	// $brand = "";
	// while($row = $brandData->fetch_assoc()) {
	// 	$brand = $row['brand_name'];
	// }

 	$brand = $row[9];
 	$category = $row[10];

 	$imageUrl = substr($row[2], 3);
 	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		$productImage,
 		// product name
 		$row[1], 
 		// rate
 		$row[6],
 		// quantity 
 		$row[5], 		 	
 		// brand
 		$brand,
 		// category 		
 		$category,
 		// active
 		$active,
 		// button
 		$button 		
 	); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);