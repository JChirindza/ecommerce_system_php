<?php

/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	switch($action) {
		case 'read':
		fetchCarts();
		break;
		case 'readItems':
		fetchCartItems();
		break;
		case 'readSelected':
		fetchSelectedCart();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

/**
 * 
 * */
function fetchCarts(){
	require_once 'core.php';

	$sql = "SELECT c.cart_id, c.payment_status, c.cart_date, c.user_id, 
	u.name, u.surname, u.user_image FROM cart AS c
	INNER JOIN users AS u ON c.user_id = u.user_id
	WHERE c.cart_status = 1 ORDER BY c.cart_id DESC";

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

			// Image
			$imageUrl = substr($row[6], 3);
			$userImage = "<img class='rounded-circle border border-secondary' src='".$imageUrl."' style='height:50px; width:50px;'  />";
			$userName = $row[4]." ".$row[5];

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
	 			$userImage,
	 			$userName,
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

/**
 * 
 * */
function fetchCartItems(){
	require_once 'core.php';
	
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

			$imageUrl = substr($resultProduct['product_image'], 3);

			$productImage = "
			<a href='produto.php?p=detail&i=".$productId."'>
			<img class='img-round' src='".$imageUrl."' style='height:80px; width:120px;'/>
			</a>
			";
			$productName = "<a href='produto.php?p=detail&i=".$productId."'>".$resultProduct['product_name']."</a>";
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

/**
 * 
 * */
function fetchSelectedCart(){
	
}
?>