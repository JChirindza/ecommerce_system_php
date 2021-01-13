<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$productDetailId = $_POST['productDetailId'];

if($productDetailId) { 

	$sql = "UPDATE product_details SET active = 2, status = 2 WHERE id = {$productDetailId}";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while remove the brand";
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST