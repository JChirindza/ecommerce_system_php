<?php 	

require_once 'db_connect.php';

session_start();

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	if (isset($_SESSION['cartId'])) {

		$cartId = $_SESSION['cartId'];
		$productId = $_POST['productId'];
		$quantity = $_POST['quantity'];

		// Verifica se o producto ja existe, caso exista aumenta a quantidade.
		$sql = "SELECT * FROM cart_item WHERE cart_id = $cartId AND product_id = {$productId} LIMIT 1";
		$result = $connect->query($sql);
		
		if ($result && $result->num_rows > 0) {
			$cartItemResult = $result->fetch_array();

			// verifica se a quantidade desejada nao e' superior a quantidade disponivel.
			$sql = "SELECT quantity FROM product WHERE product_id = {$productId}";
			$result = $connect->query($sql);
			$productResul = $result->fetch_array();

			if($productResul['quantity'] < $quantity){
				$valid['success'] = false;
				$valid['messages'] = "Error while updating the item";
			}else{
				$sql = "UPDATE cart_item SET quantity = {$quantity} WHERE cart_item_id = {$cartItemResult['cart_item_id']} AND product_id = {$productId}";
				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Updated";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while updating the item";
				}
			}
		}

		$connect->close();

		echo json_encode($valid);
	}
}

?>