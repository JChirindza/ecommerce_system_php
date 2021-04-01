<?php 	

require_once 'core.php';

$sql = "SELECT cart_id, cart_date, payment_status FROM cart WHERE cart_status = 1 ORDER BY cart_id DESC";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

	$paymentStatus = ""; 
	$x = 1;

	while($row = $result->fetch_array()) {
		$cartId = $row[0];

		$countOrderItemSql = "SELECT count(*) FROM cart_item WHERE cart_id = {$cartId}";
		$itemCountResult = $connect->query($countOrderItemSql);
		$itemCountRow = $itemCountResult->fetch_row();

 		// payment status 
		if($row[2] == 1) { 		
			$paymentStatus = "<label class='badge badge-success'>Full Payment</label>";
		} else { 		
			$paymentStatus = "<label class='badge badge-secondary'>No Payment</label>";
 		} // /else

	 	$button = '<!-- Single button -->
	 	<div class="btn-group">
		 	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 		Action <span class="caret"></span>
		 	</button>
		 	<ul class="dropdown-menu bg-transparent border-0">
			 	<li><a href="cart.php?c=cart&i='.$cartId.'" class="btn btn-success btn-sm col-12" id="editCartModalBtn"> <i class="fas fa-edit"></i> Edit</a></li>

			 	<li><a type="button" class="btn btn-danger btn-sm col-12" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeCart('.$cartId.')"> <i class="fas fa-trash"></i> Remove</a></li>       
		 	</ul>
	 	</div>';		

 	$output['data'][] = array( 		
 		// image
 		$x,
 		// order date
 		$row[1],
 		// total items
 		$itemCountRow, 		 	
 		// payment status
 		$paymentStatus,
 		// button
 		$button 		
 	); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);