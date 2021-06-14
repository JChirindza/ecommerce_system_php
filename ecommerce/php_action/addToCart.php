<?php 	

require_once 'db_connect.php';

session_start();

$valid['success'] = array('success' => false, 'messages' => array());

if(isset($_SESSION['userId'])) {
	if($_POST) {

		if (isset($_SESSION['cartId'])) {

			$cartId = $_SESSION['cartId'];
			$productId = $_POST['productId'];
			$quantity = 1;

			// Check if the selected product exists in cart. If exists, increments the item quantity
			$sql = "SELECT * FROM cart_item WHERE cart_id = $cartId AND product_id = {$productId} LIMIT 1";
			$result = $connect->query($sql);

			if ($result && $result->num_rows > 0) {
				$cartItemResult = $result->fetch_array();

				$newQuantity = $cartItemResult['quantity'] + $quantity;
				$sql = "UPDATE cart_item SET quantity = {$newQuantity} WHERE cart_item_id = {$cartItemResult['cart_item_id']} AND product_id = {$productId}";
			}else{
				$sql = "INSERT INTO `cart_item` (`cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES ('$cartId', '$productId', '$quantity', '1', '1') ";
			}

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Added";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while adding the members";
			}

			$connect->close();

			echo json_encode($valid);
		}
	}
}else{ 
	$valid['success'] = false;
	$valid['messages'] = "To add items to cart. <a class='text-primary' href='../sign-in.php'>Login first! <i class='fas fa-unlock '></i></a>";

	$connect->close();

	echo json_encode($valid);
}
?>