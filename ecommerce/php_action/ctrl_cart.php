<?php  

/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	switch($action) {
		case 'addToCart':
		addToCart();
		break;
		case 'readCart':
		fetchCart();
		break;
		case 'readItems':
		fetchCartItem();
		break;
		case 'deleteCart':
		removeCart();
		break;
		case 'deleteItem':
		removeCartItem();
		break;
		case 'updateQuantity':
		editItemQuantity();
		break;
		case 'readItemQuant':
		getCartItemQuantity();
		break;
		case 'readTotalCart':
		getTotalItemValue();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function addToCart(){
	require_once 'db_connect.php';
	session_start();

	$valid['success'] = array('success' => false, 'messages' => array());

	if(isset($_SESSION['userId'])) {
		if($_POST) {

			if (isset($_SESSION['cartId'])) {

				$cartId = $_SESSION['cartId'];
				$productId = $_POST['productId'];
				$quantity = 1;

				// Verifica se o producto ja existe, caso exista aumenta a quantidade.
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
}

function fetchCart(){
	require_once 'db_connect.php';
	session_start();

	$user_id = $_SESSION['userId'];
	$sql = "SELECT cart_id, payment_status, cart_date FROM cart
	WHERE user_id = {$user_id} AND cart_status = 1 ORDER BY cart_id DESC";

	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

		$payment_status = ""; 
		$x = 1;
		while($row = $result->fetch_array()) {

			$cartId = $row[0];

			$countItemSql = "SELECT count(*) FROM cart_item WHERE cart_id = {$cartId}";
			$itemCountResult = $connect->query($countItemSql);
			$itemCountRow = $itemCountResult->fetch_row();

 			// payment_status 
			if($row[1] == 1) {
				$payment_status = "<label class='badge badge-success'>Paid</label>";
			} else {
				$payment_status = "<label class='badge badge-danger'>Not Paid</label>";
	 		} // /else

	 		$button = '<!-- Single button -->
	 		<div class="btn-group">
	 		<a href="cart.php?c=cartItems&i='.$cartId.'" class="btn btn-outline-success btn-sm" id="cartItemBtn"> <i class="fas fa-eye"></i></a>
	 		<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeCartModal" id="removeCartModalBtn" onclick="removeCart('.$cartId.')"> <i class="fas fa-trash"></i></button>       
	 		</div>';

	 		$output['data'][] = array( 		
	 			$x,
	 			$row[2],
	 			$itemCountRow,
	 			$payment_status,
	 			// button
	 			$button 		
	 		);
	 		$x++;	
	 	} // /while 

	}// if num_rows

	$connect->close();

	echo json_encode($output);
}

function fetchCartItem(){
	require_once 'db_connect.php';

	$cartId = $_GET['cartId'];

	$sql = "SELECT cart_item_id, product_id, quantity FROM cart_item WHERE cart_id = {$cartId} AND status = 1";
	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

		while($row = $result->fetch_array()) {
			$cartItemId = $row[0];
			$productId = $row[1];
			$quantity = $row[2];

			$sql2 = "SELECT * FROM product WHERE product_id = {$productId} ";
			$query = $connect->query($sql2);
			$resultProduct = $query->fetch_assoc();

			$imageUrl = $resultProduct['product_image'];

			$productImage = "
			<a href='product_details.php?product_id=".$productId."'>
			<img class='img-round' src='".$imageUrl."' style='height:80px; width:120px;'/>
			</a>
			";
			$productName = "<a href='product_details.php?product_id=".$productId."'>".$resultProduct['product_name']."</a>";
			$price = $resultProduct['rate'];
			$availableQuantity = $resultProduct['quantity'];
			$total = $price * $quantity;

			$quantityInput = '
			<input type="number" class="col-sm-12 col-md-10 col-lg-8" name="quantity[]" id="quantity<?php echo $x; ?>"  autocomplete="off" class="form-control" min="1" max="'.$availableQuantity.'" value="'.$quantity.'" required>
			<label class="text-muted" style="font-size: 14px;">Available: '.$availableQuantity.'</label>
			';

			$button = '
			<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeCartItemModal" id="removeCartItemModalBtn" onclick="removeCartItem('.$cartItemId.')"> <i class="fas fa-trash"></i></button>
			';

			$output['data'][] = array( 		
				$productImage,
				$productName,
				$price,
				$quantityInput,
				$total,
				$button 		
			);
	 	} // /while 

	}// if num_rows
	$connect->close();

	echo json_encode($output);
}

function removeCart(){
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
}

function removeCartItem(){
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
}

function editItemQuantity(){
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
}

function getCartItemQuantity(){
	require_once 'db_connect.php';

	session_start();

	if (isset($_SESSION['cartId'])) {

		$cartId = $_SESSION['cartId'];
		$sql = "SELECT COUNT(*) AS totalQuantiy FROM cart_item WHERE cart_id = {$cartId}";
		$result = $connect->query($sql);

		if($result->num_rows > 0) { 
			$row = $result->fetch_array();
		} // if num_rows
		$connect->close();

		echo json_encode($row);
	}
}

function getTotalItemValue(){
	require_once 'db_connect.php';

	session_start();

	if (isset($_SESSION['cartId'])) {
		$cartId = $_SESSION['cartId'];
		$sql = "SELECT SUM((p.rate)*(ci.quantity)) AS totalValue FROM product AS p INNER JOIN cart_item AS ci ON ci.product_id = p.product_id WHERE ci.cart_id = {$cartId}";
		$result = $connect->query($sql);

		if($result->num_rows > 0) { 
			$row = $result->fetch_array();
		} // if num_rows
		$connect->close();

		echo json_encode($row);
	}
}
?>