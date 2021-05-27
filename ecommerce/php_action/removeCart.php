<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$cartId = $_POST['cartId'];

if($cartId) { 

	$sql = "UPDATE cart SET cart_status = 2 WHERE cart_id = {$cartId}";

	$cartItem = "UPDATE cart_item SET active = 2, status = 2 WHERE cart_id = {$cartId}";

	if($connect->query($sql) === TRUE && $connect->query($cartItem) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Removed";		
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while remove the cart";
	}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST