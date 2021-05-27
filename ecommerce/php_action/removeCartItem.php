<?php 	

require_once 'db_connect.php';

$valid['success'] = array('success' => false, 'messages' => array());

$cartItemId = $_POST['cartItemId'];

if($cartItemId) {

	$sql = "DELETE FROM cart_item WHERE cart_item_id = {$cartItemId}";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Removed";		
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while remove the cart item";
	}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST