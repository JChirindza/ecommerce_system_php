<?php 	

require_once 'core.php';

$sql = "SELECT order_id, order_date, client_name, client_contact, payment_place, payment_status FROM orders WHERE order_status = 1 ORDER BY order_id DESC";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $paymentPlace = ""; 
 $paymentStatus = ""; 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];

 	$countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();


 	// payment place
 	if($row[4] == 1) { 		
 		$paymentPlace = "<label class='badge badge-info'>Loja Fisica</label>";
 	} else { 		
 		$paymentPlace = "<label class='badge badge-success'>Loja Virtual</label>";
 	} // /else

 	// payment status 
 	if($row[5] == 1) { 		
 		$paymentStatus = "<label class='badge badge-success'>Full Payment</label>";
 	} else if($row[5] == 2) { 		
 		$paymentStatus = "<label class='badge badge-info'>Advance Payment</label>";
 	} else { 		
 		$paymentStatus = "<label class='badge badge-secondary'>No Payment</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu bg-transparent border-0">
	    <li><a href="pedidos.php?p=editOrd&i='.$orderId.'" class="btn btn-success btn-sm col-12" id="editOrderModalBtn"> <i class="fas fa-edit"></i> Edit</a></li>
	    
	    <li><a type="button" class="btn btn-primary btn-sm col-12" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')"> <i class="fas fa-money-bill"></i> Payment</a></li>

	    <li><a type="button" class="btn btn-warning btn-sm col-12" onclick="printOrder('.$orderId.')"> <i class="fas fa-print"></i> Print </a></li>
	    
	    <li><a type="button" class="btn btn-danger btn-sm col-12" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="fas fa-trash"></i> Remove</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 		
 		// image
 		$x,
 		// order date
 		$row[1],
 		// client name
 		$row[2], 
 		// client contact
 		$row[3], 		 	
 		$itemCountRow, 		 	
 		$paymentPlace,
 		$paymentStatus,
 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);