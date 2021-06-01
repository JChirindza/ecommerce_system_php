<?php 	

require_once 'db_connect.php';

session_start();

$valid['success'] = array('success' => false, 'messages' => array());
echo "OKKKKKKKK.";
if(isset($_SESSION['userId'])) {
	if($_POST) {

		$cartId = 1;
		$productId = $_POST['productId'];
		$quantity = 1;

		$sql = "INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES (NULL, '$cartId', '$productId', '$quantity', '1', '1') ";

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
}else{ 
	?>
	<div class="p-4">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			Nao tem permissao para aceder a esta pagina.
		</div>
		<div class="d-flex justify-content-center">
			<a href="../../sign-in.php" class="btn btn-primary"><i class="fas fa-sign-in-alt pr-2"></i> Sign-in</a>
		</div>
	</div>
	<?php
	die();
}












// if(isset($_SESSION['userId']) {
// 	if($_POST) {

// 		$productId = $_POST['productId'];
// 		$quantity = 1;

// 		if(isset($_SESSION['cartId'])) {

// 			$cartId = $_SESSION['cartId'];

// 			// Check if the product exits in cart
// 			// $productSql = "SELECT product_id FROM cart_item WHERE cart_id = {$cartId}";
// 			// $result = $connect->query($sql);

// 			$sql = "INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES (NULL, '$cartId', '$productId', '$quantity', '1', '1')";

// 			if($connect->query($sql) === TRUE) {
// 				$valid['success'] = true;
// 				$valid['messages'] = "Successfully Added";	
// 			} else {
// 				$valid['success'] = false;
// 				$valid['messages'] = "Error while adding the members";
// 			}

// 			$connect->close();

// 			echo json_encode($valid);

// 		}else{
// 			$userId = $_SESSION['userId'];

// 			$sql = "INSERT INTO `cart` (`cart_id`, `user_id`, `payment_status`, `cart_status`, `cart_date`) VALUES (NULL, '$userId', '2', '1', NULL) ";

// 			$newCartId;
// 			if($connect->query($sql) === true) {
// 				$newCartId = $connect->insert_id;
// 				$valid['cart_id'] = $newCartId;	
// 			// echo "New record created successfully. Last inserted ID is: " . $newCartId;
// 			}

// 			$cartItemSql = "INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES (NULL, '$newCartId', '$productId', '$quantity', '1', '1')";

// 			if($connect->query($cartItemSql) === TRUE) {
// 				$valid['success'] = true;
// 				$valid['messages'] = "Successfully Added";	
// 				// set session
// 				$_SESSION['cartId'] = $newCartId;
// 			} else {
// 				$valid['success'] = false;
// 				$valid['messages'] = "Error while adding the members";
// 			}

// 			$connect->close();

// 			echo json_encode($valid);
// 		}
// 	} // /if $_POST
// }else{
// 	header('Location: http://localhost/SistemaDeVendas_ControleDeStock/sign-in.php'); 
// 	exit();
// }





