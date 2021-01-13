<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$product_id = $_POST['productId'];
	$productDetail = $_POST['productDetail'];
  	$productDetailDescr = $_POST['detailDescription']; 
  	$productDetailStatus = $_POST['productDetailStatus']; 

	$sql = "INSERT INTO product_details (product_id, detail, description, active, status) VALUES ('$product_id', '$productDetail', '$productDetailDescr', '$productDetailStatus', 1)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST