<?php 
require_once 'core.php';

if (isset($_SESSION['userId'])) {
	
	$userId = $_SESSION['userId'];
	$paid 	= $_POST['paid'];
	// $status = $_POST['status'];

	// $sql = "SELECT cart_id FROM cart WHERE cart.user_id ='.$_SESSION["user_cpf"].' ";
	
	$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
	// print_r($valid);
	if($_POST) {	

		$sql = "INSERT INTO cart (user_id, paid, status) VALUES ('$userid', '$paid', 1)";

		$order_id;
		$orderStatus = false;
		if($connect->query($sql) === true) {
			$order_id = $connect->insert_id;
			$valid['order_id'] = $order_id;	

			$orderStatus = true;
		// echo "New record created successfully. Last inserted ID is: " . $order_id;
		} 
	// else {
	// 	echo "Error: " . $sql . "<br>" . $connect->error;
	// }

	// echo $_POST['productName'];
		$orderItemStatus = false;

		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);

			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
				// update product table
				$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
				$connect->query($updateProductTable);

				// add into order_item
				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
				VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;
				}		
		} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Successfully Added";		
	
	$connect->close();

	echo json_encode($valid);
	
} // /if $_POST
// echo json_encode($valid);


}else{
	header('Location: ../../sign-in.php');
}


?>