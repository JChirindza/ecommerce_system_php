<?php  
require_once 'core.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createProductDetil();
		break;
		case 'read':
		fetchProductDetils();
		break;
		case 'update':
		editProductDetil();
		break;
		case 'delete':
		removeProductDetil();
		break;
		case 'readSelected':
		fetchSelectedProductDetil();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function createProductDetil(){

	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$product_id 		= Sys_Secure($_POST['productId']);
		$productDetail 		= Sys_Secure($_POST['productDetail']);
		$productDetailDescr = Sys_Secure($_POST['detailDescription']); 
		$productDetailStatus= Sys_Secure($_POST['productDetailStatus']); 

		$sql = "INSERT INTO product_details (product_id, detail, description, active, status) VALUES ('$product_id', '$productDetail', '$productDetailDescr', '$productDetailStatus', 1)";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-added'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-adding-the-members'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function fetchProductDetils(){
	
	global $connect, $language;
	
	$product_id = Sys_Secure($_GET['product_id']);

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
				$active = "<label class='badge badge-success'>".$language['active']."</label>";
			} else {
 				// deactivate member
				$active = "<label class='badge badge-danger'>".$language['inactive']."</label>";
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
}

function editProductDetil(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {

		$productDetailId 	= Sys_Secure($_POST['productDetailId']);
		$productDetail 		= Sys_Secure($_POST['editProductDetail']); 
		$detailDescription	= Sys_Secure($_POST['editDetailDescription']);
		$productStatus 		= Sys_Secure($_POST['editDetailStatus']);

		$sql = "UPDATE product_details SET detail = '$productDetail', description = '$detailDescription', active = '$productStatus', status = 1 WHERE id = $productDetailId ";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}
	} // /$_POST
	$connect->close();

	echo json_encode($valid);
}

function removeProductDetil(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	$productDetailId = Sys_Secure($_POST['productDetailId']);

	if($productDetailId) { 

		$sql = "UPDATE product_details SET active = 2, status = 2 WHERE id = {$productDetailId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-removed'];		
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-remove'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function fetchSelectedProductDetil(){
	
	global $connect;

	$productDetailId = Sys_Secure($_POST['productDetailId']);

	$sql = "SELECT id, detail, description, active, status FROM product_details WHERE id = $productDetailId";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}

?>