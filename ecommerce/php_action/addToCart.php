<?php 	

require_once 'db_connect.php';

$valid['success'] = array('success' => false, 'messages' => array());

if(isset($_SESSION['userId']) {
	if($_POST) {
		if(isset($_SESSION['cartId'])) {

			$cartId = $_SESSION['cartId'];
			$productId = $_POST['productId'];
			$quantity = $_POST['quantity'];

			// Check if the product
			// $productSql = "SELECT product_id FROM cart_item WHERE cart_id = {$cartId}";
			// $result = $connect->query($sql);

			$sql = "INSERT INTO cart_item(cart_id, product_id, quantity, active, status) VALUES('$cartId', '$productId', '$quantity', 1, 1)";

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Added";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while adding the members";
			}

			$connect->close();

			echo json_encode($valid);

		}else{
			$user_id = $_SESSION['userId'];
			$cart_date = date('Y-m-d H:i:s');

			$sql = "INSERT INTO cart(user_id, payment_status, cart_status, cart_date) VALUES('$user_id', 2, 1, '$cart_date')";

			$cartId;
			if($connect->query($sql) === true) {
				$cartId = $connect->insert_id;
				$valid['cart_id'] = $cartId;	
			// echo "New record created successfully. Last inserted ID is: " . $cartId;
			}

			$cartItemSql = "INSERT INTO cart_item(cart_id, product_id, quantity, active, status) VALUES()";

			if($connect->query($cartItemSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Added";	
			// Create session cartId

				$_SESSION['cartId'] = $cartId;
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while adding the members";
			}

			$connect->close();

			echo json_encode($valid);
		}
	} // /if $_POST
}else{
	header('Location: ../sign-in.php'); 
}





