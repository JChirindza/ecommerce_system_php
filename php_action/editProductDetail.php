<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$productDetailId 	= $_POST['productDetailId'];
	$productDetail 		= $_POST['editProductDetail']; 
	$detailDescription	= $_POST['editDetailDescription'];
  	$productStatus 		= $_POST['editDetailStatus'];

	$sql = "UPDATE product_details SET detail = '$productDetail', description = '$detailDescription', active = '$productStatus', status = 1 WHERE id = $productDetailId ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
