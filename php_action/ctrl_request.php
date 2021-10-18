<?php
require_once 'core.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'read':
		fetchRequests();
		break;
		case 'readItems':
		fetchRequestedItems();
		break;
		case 'confirm':
		confirm_request();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function fetchRequests(){
	
	global $connect;

	$output = array('data' => array());

	$sql = "SELECT cart_has_paid.cart_has_paid_id, 
	requests.dt_requested, 
	users.name, 
	users.surname, 
	clients.contact, 
	(SELECT COUNT(*) 
	FROM cart_item_has_paid 
	WHERE cart_item_has_paid.cart_has_paid_id  = cart_has_paid.cart_has_paid_id ) 
	AS totalItems, 
	cart_has_paid.payment_type, 
	requests.active
	FROM cart_has_paid
	INNER JOIN requests ON cart_has_paid.cart_has_paid_id = requests.cart_has_paid_id
	INNER JOIN cart ON cart_has_paid.cart_id = cart.cart_id 
	INNER JOIN clients ON cart.user_id = clients.user_id 
	INNER JOIN users ON clients.user_id = users.user_id
	ORDER BY cart_has_paid_id DESC";

	$result = $connect->query($sql);

	if($result->num_rows > 0) { 

		$pendingStatus = ""; 
		$paymentType = "";
		$x = 1;
		while($row = $result->fetch_array()) {

			$dtResponded = $row['dt_requested'];
			$clientName = $row['name']." ".$row['surname'];
			$contact = $row['contact'];
			$totalItems = $row['totalItems'];

 			// payment_status 
			if($row['active'] == 1) {
				$pendingStatus = "<label class='badge badge-warning'>Pending Request</label>";
			} else {
				$pendingStatus = "<label class='badge badge-success'>Responded</label>";
	 		} // /else

	 		// payment_type 
	 		if($row['payment_type'] == 1) {
	 			$paymentType = "<label class='badge badge-danger rounded-0'>Mpesa</label>";
	 		} else {
	 			$paymentType = "<label class='badge badge-primary rounded-0'>VISA</label><label class='badge badge-info rounded-0'>MasterCard</label>";
	 		} // /else

	 		$button = '<!-- Single button -->
	 		<div class="btn-group">
	 		<a href="request.php?r=respreq&i='.$row['cart_has_paid_id'].'" class="btn btn-outline-success btn-sm" id="cartItemBtn"> <i class="fas fa-eye"></i></a>
	 		</div>';

	 		$output['data'][] = array( 		
	 			$x,
	 			$dtResponded,
	 			$clientName,
	 			$contact,
	 			$totalItems,
	 			$paymentType,
	 			$pendingStatus,
	 			// button
	 			$button 		
	 		);
	 		$x++;	
	 	} // /while 

	}// if num_rows

	$connect->close();

	echo json_encode($output);
}

function fetchRequestedItems(){
	global $connect;

	$output = array('data' => array());
	
	if (isset($_GET['cartHasPaidId'])) {

		$cartHasPaidId = $_GET['cartHasPaidId'];

		$sql = "SELECT * FROM `cart_item_has_paid` WHERE cart_has_paid_id = {$cartHasPaidId}";
		$result = $connect->query($sql);

		if($result->num_rows > 0) { 

			while($data = $result->fetch_assoc()) {
				$itemId = $data['cart_item_has_paid_id'];
				$productId = $data['product_id'];
				$quantity = $data['quantity'];
				$paidPrice = $data['paid_price'];

				$sql2 = "SELECT * FROM product WHERE product_id = {$productId}";
				$query = $connect->query($sql2);
				$resultProduct = $query->fetch_assoc();

				$imageUrl = substr($resultProduct['product_image'], 3);

				$productImage = "
				<a href='products.php?p=detail&i=".$productId."'>
				<img src='".$imageUrl."' style='height:80px; width:120px;'/>
				</a>
				";
				$productName = "<a href='products.php?p=detail&i=".$productId."'>".$resultProduct['product_name']."</a>";

				$quantityInput = '
				<input type="number" readOnly class="col-sm-12 col-md-10 col-lg-8" class="form-control" value="'.$quantity.'">
				';

				$total = $paidPrice * $quantity;

				$output['data'][] = array( 		
					$productImage,
					$productName,
					$quantityInput,
					number_format($paidPrice,2,",","."),
					number_format($total,2,",","."),
				);
	 		} // /while 
		}// if num_rows
		$connect->close();

		echo json_encode($output);
	}

}

function confirm_request() {

	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array(), 'cart_has_paid_id' => '');
	
	if (isset($_POST['cartHasPaidId'])) {

		$cartHasPaidId = $_POST['cartHasPaidId'];

		$sql = "SELECT * FROM `cart_has_paid` WHERE cart_has_paid_id = {$cartHasPaidId}";
		$result = $connect->query($sql);

		if ($result->num_rows > 0) {
			if (is_request_confirmed($cartHasPaidId) === false) {

				$sql = "UPDATE `requests` SET `active` = 2, `dt_responded` = current_timestamp() WHERE cart_has_paid_id = {$cartHasPaidId}";
				if ($connect->query($sql) === true) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully confirmed.";
					$valid['cart_has_paid_id'] = $cartHasPaidId;
				}				
			}else{
				$valid['messages'] = "Error while confirm. This request was been confirmed!";
			}
		}else{
			$valid['messages'] = "Error while confirm request!";
		}
	}else {
		$valid['messages'] = "Error while confirm request!";
	}
	$connect->close();

	echo json_encode($valid);
}

// Check if request was confirmed
function is_request_confirmed($cartHasPaidId){
	global $connect;

	$sql = "SELECT * FROM requests WHERE cart_has_paid_id = {$cartHasPaidId} AND active = 2 LIMIT 1"; // active = 2  -> Confirmed = TRUE
	$result = $connect->query($sql);

	if ($result->num_rows > 0) {
		return true; // confirmed
	}else{
		return false; // <= 0 Not confirmed
	}
}
?>