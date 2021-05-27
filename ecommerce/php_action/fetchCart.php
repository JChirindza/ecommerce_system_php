<?php 	
require_once 'db_connect.php';

$sql = "SELECT cart_id, payment_status, cart_date FROM cart
WHERE cart_status = 1 ORDER BY cart_id DESC";

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