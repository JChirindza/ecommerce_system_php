<?php 	

require_once 'core.php';

// $product_id = $_GET['i'];
$product_id = 9;

$sql = "SELECT product_details.id, product_details.detail, product_details.description, product_details.active FROM product_details INNER JOIN product ON product_details.product_id = product.product_id WHERE product_details.status = 1 AND product.product_id = {$product_id} ORDER BY product_details.id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
	$active = ""; 
	$x = 1;
	while($row = $result->fetch_array()) {
		$detailId = $row[0];
 		// active 
		if($row[3] == 1) {
 			// activate member
			$active = "<label class='badge badge-success'>Active</label>";
		} else {
 			// deactivate member
			$active = "<label class='badge badge-danger'>Not Active</label>";
 		} // /else

 		$button = '<!-- Single button -->
	 	<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editProductDetailModalBtn" data-target="#editProductDetailModal" onclick="editProductDetail('.$detailId.')"> <i class="fas fa-edit"></i></button>
	 	<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeProductDetailModal" id="removeProductDetailModalBtn" onclick="removeProductDetail('.$detailId.')"> <i class="fas fa-trash"></i></button>       
	 	';

	 	$output['data'][] = array( 		
	 		// #
	 		$x,
	 		// detail 
	 		$row[1], 
	 		// description
	 		$row[2],
	 		// active
	 		$active,
	 		// button
	 		$button 		
 		); 	
 		$x++;
 	} // /while 

}// if num_rows

$connect->close();

echo json_encode($output);