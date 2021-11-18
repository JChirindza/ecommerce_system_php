<?php  
require_once 'core.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createOrder();
		break;
		case 'read':
		fetchOrders();
		break;
		case 'update':
		editOrder();
		break;
		case 'delete':
		removeOrder();
		break;
		case 'readSelected':
		fetchSelectedOrder();
		break;
		case 'updatePayment':
		editPayment();
		break;
		case 'printOrder':
		printOrder();
		break;
		case 'getReport':
		getOrderReport();
		break;
		case 'readSelectedProd':
		fetchSelectedProduct();
		break;
		case 'readProdData':
		fetchProductData();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function createOrder(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
	// print_r($valid);
	if($_POST) {	

		$orderDate 			= date('Y-m-d H:i:s');	
		$clientName 		= Sys_Secure($_POST['clientName']);
		$clientContact 		= Sys_Secure($_POST['clientContact']);
		$subTotalValue 		= Sys_Secure($_POST['subTotalValue']);
		$vatValue 			= Sys_Secure($_POST['vatValue']);
		$totalAmountValue   = Sys_Secure($_POST['totalAmountValue']);
		$discount 			= Sys_Secure($_POST['discount']);
		$grandTotalValue 	= Sys_Secure($_POST['grandTotalValue']);
		$paid 				= Sys_Secure($_POST['paid']);
		$dueValue 			= Sys_Secure($_POST['dueValue']);
		$paymentType 		= Sys_Secure($_POST['paymentType']);
		$paymentStatus 		= Sys_Secure($_POST['paymentStatus']);
		$userid 			= Sys_Secure($_SESSION['userId']);

		$sql = "INSERT INTO orders (order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_status,order_status,user_id) VALUES ('$orderDate', '$clientName', '$clientContact', '$subTotalValue', '$vatValue', '$totalAmountValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', '$paymentType', '$paymentStatus', 1, '$userid')";

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

		if ($orderStatus === true) {

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
					VALUES ('$order_id', '".$_POST['productName'][$x]."', '".Sys_Secure($_POST['quantity'][$x])."', '".Sys_Secure($_POST['rateValue'][$x])."', '".$_POST['totalValue'][$x]."', 1)";

					$connect->query($orderItemSql);		

					if($x == count($_POST['productName'])) {
						$orderItemStatus = true;
					}		
				} // while	
			} // /for quantity

			$valid['success'] = true;
			$valid['messages'] = $language['successfully-added'];
		}

		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function fetchOrders(){
	
	global $connect, $language;

	$sql = "SELECT order_id, order_date, client_name, client_contact, grand_total, payment_status FROM orders WHERE order_status = 1 ORDER BY order_id DESC";
	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

		$paymentStatus = ""; 
		$x = 1;

		while($row = $result->fetch_array()) {
			$orderId = $row[0];

			$countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
			$itemCountResult = $connect->query($countOrderItemSql);
			$itemCountRow = $itemCountResult->fetch_row();

		 	// payment status 
	 		if($row[5] == 1) { 		
	 			$paymentStatus = "<label class='badge badge-success'>".$language['full-payment']."</label>";
	 		} else if($row[5] == 2) { 		
	 			$paymentStatus = "<label class='badge badge-info'>".$language['partial-payment']."</label>";
	 		} else { 		
	 			$paymentStatus = "<label class='badge badge-secondary'>".$language['no-payment']."</label>";
		 	} // /else

		 	$button = '<!-- Single button -->
		 	<div class="btn-group">
		 	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 	Action <span class="caret"></span>
		 	</button>
		 	<ul class="dropdown-menu bg-transparent border-0">
		 	<li><a href="orders.php?p=editOrd&i='.$orderId.'" class="btn btn-success btn-sm col-12" id="editOrderModalBtn"> <i class="fas fa-eye"></i> '.$language['view'].'</a></li>

		 	<li><a type="button" class="btn btn-primary btn-sm col-12" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')"> <i class="fas fa-money-bill"></i> '.$language['payment'].'</a></li>

		 	<li><a type="button" class="btn btn-warning btn-sm col-12" onclick="printOrder('.$orderId.')"> <i class="fas fa-print"></i> '.$language['print'].' </a></li>

		 	<li><a type="button" class="btn btn-danger btn-sm col-12" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="fas fa-trash"></i> '.$language['remove'].'</a></li>       
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
		 		$row[4],
		 		$paymentStatus,
		 		// button
		 		$button 		
		 	); 	
		 	$x++;
		} // /while 

	}// if num_rows
	$connect->close();

	echo json_encode($output);
}

function fetchSelectedOrder(){
	
	global $connect;

	$orderId = Sys_Secure($_POST['orderId']);

	$valid = array('order' => array(), 'order_item' => array());

	$sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status FROM orders 	
	WHERE orders.order_id = {$orderId}";

	$result = $connect->query($sql);
	$data = $result->fetch_row();
	$valid['order'] = $data;

	$connect->close();

	echo json_encode($valid);
}

function editOrder(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

	if($_POST) {	

		$orderId 			= Sys_Secure($_POST['orderId']);
		$orderDate 			= date('Y-m-d H:i:s');
		$clientName 		= Sys_Secure($_POST['clientName']);
		$clientContact 		= Sys_Secure($_POST['clientContact']);
		$subTotalValue 		= Sys_Secure($_POST['subTotalValue']);
		$vatValue 			= Sys_Secure($_POST['vatValue']);
		$totalAmountValue	= Sys_Secure($_POST['totalAmountValue']);
		$discount 			= Sys_Secure($_POST['discount']);
		$grandTotalValue	= Sys_Secure($_POST['grandTotalValue']);
		$paid 				= Sys_Secure($_POST['paid']);
		$dueValue 			= Sys_Secure($_POST['dueValue']);
		$paymentType 		= Sys_Secure($_POST['paymentType']);
		$paymentStatus 		= Sys_Secure($_POST['paymentStatus']);
		$userid 			= Sys_Secure($_SESSION['userId']);

		$sql = "UPDATE orders SET order_date = '$orderDate', client_name = '$clientName', client_contact = '$clientContact', sub_total = '$subTotalValue', vat = '$vatValue', total_amount = '$totalAmountValue', discount = '$discount', grand_total = '$grandTotalValue', paid = '$paid', due = '$dueValue', payment_type = '$paymentType', payment_status = '$paymentStatus', order_status = 1 ,user_id = '$userid' WHERE order_id = {$orderId}";	
		$connect->query($sql);

		if($connect->query($sql) === TRUE) {

			$valid['order_id'] = $orderId;

			$readyToUpdateOrderItem = false;
			// add the quantity from the order item to product table
			for($x = 0; $x < count($_POST['productName']); $x++) {		
				//  product table
				$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
				$updateProductQuantityData = $connect->query($updateProductQuantitySql);			

				while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
					// order item table add product quantity
					$orderItemTableSql = "SELECT order_item.quantity FROM order_item WHERE order_item.order_id = {$orderId}";
					$orderItemResult = $connect->query($orderItemTableSql);
					$orderItemData = $orderItemResult->fetch_row();

					$editQuantity = $updateProductQuantityResult[0] + $orderItemData[0];							

					$updateQuantitySql = "UPDATE product SET quantity = $editQuantity WHERE product_id = ".$_POST['productName'][$x]."";
					$connect->query($updateQuantitySql);		
				} // while	
				
				if(count($_POST['productName']) == count($_POST['productName'])) {
					$readyToUpdateOrderItem = true;			
				}
			} // /for quantity

			// remove the order item data from order item table
			for($x = 0; $x < count($_POST['productName']); $x++) {			
				$removeOrderSql = "DELETE FROM order_item WHERE order_id = {$orderId}";
				$connect->query($removeOrderSql);	
			} // /for quantity

			if($readyToUpdateOrderItem) {
				// insert the order item data 
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
						VALUES ({$orderId}, '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

						$connect->query($orderItemSql);		
					} // while	
				} // /for quantity
			}// /if readyToUpdateOrderItem

			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function editPayment(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	
		$orderId 			= Sys_Secure($_POST['orderId']);
		$payAmount 			= Sys_Secure($_POST['payAmount']); 
		$paymentType 		= Sys_Secure($_POST['paymentType']);
		$paymentStatus 		= Sys_Secure($_POST['paymentStatus']);  
		$paidAmount        	= Sys_Secure($_POST['paidAmount']);
		$grandTotal        	= Sys_Secure($_POST['grandTotal']);

		$updatePaidAmount = $payAmount + $paidAmount;
		$updateDue = $grandTotal - $updatePaidAmount;

		$sql = "UPDATE orders SET paid = '$updatePaidAmount', due = '$updateDue', payment_type = '$paymentType', payment_status = '$paymentStatus' WHERE order_id = {$orderId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function removeOrder(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	$orderId = Sys_Secure($_POST['orderId']);

	if($orderId) { 
		$sql = "UPDATE orders SET order_status = 2 WHERE order_id = {$orderId}";

		$orderItem = "UPDATE order_item SET order_item_status = 2 WHERE  order_id = {$orderId}";

		if($connect->query($sql) === TRUE && $connect->query($orderItem) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-removed'];		
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-remove'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function printOrder(){
	
	global $connect, $language;

	$orderId = Sys_Secure($_POST['orderId']);

	$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

	$orderResult = $connect->query($sql);
	$orderData = $orderResult->fetch_array();

	$orderDate = $orderData[0];
	$clientName = $orderData[1];
	$clientContact = $orderData[2]; 
	$subTotal = $orderData[3];
	$vat = $orderData[4];
	$totalAmount = $orderData[5]; 
	$discount = $orderData[6];
	$grandTotal = $orderData[7];
	$paid = $orderData[8];
	$due = $orderData[9];

	$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
	product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
	WHERE order_item.order_id = $orderId";
	$orderItemResult = $connect->query($orderItemSql);

	$table = '
	<style>
	label { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
	table { border-collapse: collapse; }
	table td, table th { border: 1px solid black; padding: 5px; }

	   #header { height: 15px; width: 100%; margin: 20px 0; border: 1px solid black; background: #eee; text-align: center; color: black; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

	   #address { width: 250px; height: 150px; float: left; margin-left: .5rem}
	   #customer { overflow: hidden; }

	   #logo { text-align: right; float: right; position: relative; max-width: 540px; max-height: 100px; overflow: hidden; margin-right: .5rem;}
	   #customer-title { font-size: 20px; font-weight: bold; float: left; }

	   #client { margin-top: 1px; width: 300px; float: left; }
	   #client td { text-align: right;  }
	   #client td.meta-head { text-align: left; background: #eee; }
	   #client td label { width: 100%; height: 20px; text-align: right; }

	   #meta { margin-top: 1px; width: 300px; float: right; }
	   #meta td { text-align: right;  }
	   #meta td.meta-head { text-align: left; background: #eee; }
	   #meta td label { width: 100%; height: 20px; text-align: right; }

	.qty{ text-align: center; }

	   #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
	   #items th { background: #eee; }
	   #items label { width: 80px; height: 50px; }
	   #items tr.item-row td { border:  1px solid black; vertical-align: top; }
	   #items td.description { width: 300px; }
	   #items td.item-name { width: 175px; }
	   #items td.description label, #items td.item-name label { width: 100%; }
	   #items td.total-line { border-right: 0; text-align: right; }
	   #items td.total-value { border-left: 0; padding: 10px; }
	   #items td.total-value label { height: 20px; background: none; }
	   #items td.balance { background: #eee; }
	   #items td.blank { border: 0; }

	   #terms { text-align: center; margin: 20px 0 0 0; }
	   #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
	   #terms label { width: 100%; text-align: center;}
	</style>

	<div id="page-wrap">

	<p id="header">INVOICE</p>

	<div id="identity">

	<label id="address">
	Computer Only Corp.;<br>
	Av.: Karl Max Nr.: 1234;<br>
	Maputo, '.$language['mozambique'] .';<br>
	Tel: (+258) 82 11 11 111; <br>
	Email: computersonly@pconly.co.mz
	</label>
	<div id="logo">
	<img id="image" src="assests/images/logo.png" alt="logo" />
	</div>
	</div>

	<div style="clear:both"></div>

	<div id="customer">

	<table id="client">
	<tr>
	<td class="meta-head">'.$language['client-name'].': </td>
	<td>'.$clientName.'</td>
	</tr>
	<tr>

	<td class="meta-head">'.$language['contact'] .': </td>
	<td>'.$clientContact.'</td>
	</tr>
	<tr>
	<td class="meta-head">Nuit: </td>
	<td>3453453</div></td>
	</tr>
	</table>

	<table id="meta">
	<tr>
	<td class="meta-head">Recibo & Data Nr.</td>
	<td>'.$orderDate.'</td>
	</tr>
	<tr>

	<td class="meta-head">'.$language['order-date'].'</td>
	<td>'.$orderDate.'</td>
	</tr>
	<tr>
	<td class="meta-head">'.$language['due-amount'].'</td>
	<td><div class="due">'.$due.'</div></td>
	</tr>
	</table>
	</div>

	<table id="items">

	<tr>
	<th width="5%">#</th>
	<th width="55%">'.$language['product-description'].'</th>
	<th width="15%">'.$language['price'].'</th>
	<th width="10%">'.$language['quantity'].'</th>
	<th width="15%">'.$language['sub-amount'].'</th>
	</tr>
	';
	$x = 1;

	while($row = $orderItemResult->fetch_array()) {       
		$table .= '
		<tr class="item-row">
		<td class="item-name"><label>'.$x.'</label></td>
		<td class="description"><label>'.$row[4].'</label></td>
		<td><label class="cost">'.$row[1].'</label></td>
		<td><label class="qty">'.$row[2].'</label></td>
		<td><span class="price">'.$row[3].'</span></td>
		</tr>
		';
		$x++;
    } // /while
    $table.= '
    <tr>
    <td colspan="2" class="blank"> </td>
    <td colspan="2" class="total-line">'.$language['total-amount'].':</td>
    <td class="total-value"><div id="subtotal">'.$subTotal.'</div></td>
    </tr>
    <tr>
    <td colspan="2" class="blank"> </td>
    <td colspan="2" class="total-line balance">'.$language['grand-total'].':</td>
    <td class="total-value balance"><div class="due">'.$grandTotal.'</div></td>
    </tr>
    </table>

    <div class="">
    <label>Assinatura do Funcionario:</label>
    <br>
    &nbsp;
    </div>

    <div id="terms">
    <h5>Terms</h5>
    <label>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</label>
    </div>

    </div>
    ';
    $connect->close();

    echo $table;
}


function getOrderReport(){

	global $connect, $language;

	if($_POST) {

		$startDate = Sys_Secure($_POST['startDate']);
		$date = DateTime::createFromFormat('m/d/Y',$startDate);
		$start_date = $date->format("Y-m-d");


		$endDate = Sys_Secure($_POST['endDate']);
		$format = DateTime::createFromFormat('m/d/Y',$endDate);
		$end_date = $format->format("Y-m-d");

		$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
		$query = $connect->query($sql);

		$table = '
		<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
		<th>'.$language['order-date'].'</th>
		<th>'.$language['client-name'].'</th>
		<th>'.$language['contact'].'</th>
		<th>'.$language['grand-total'].'</th>
		</tr>

		<tr>';
		$totalAmount = 0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
			<td><center>'.$result['order_date'].'</center></td>
			<td><center>'.$result['client_name'].'</center></td>
			<td><center>'.$result['client_contact'].'</center></td>
			<td><center>'.$result['grand_total'].'</center></td>
			</tr>';	
			$totalAmount += $result['grand_total'];
		}
		$table .= '
		</tr>

		<tr>
		<td colspan="3"><center>'.$language['total-amount'].'</center></td>
		<td><center>'.$totalAmount.'</center></td>
		</tr>
		</table>
		';	

		echo $table;
	}
}

function fetchSelectedProduct(){
	
	global $connect;

	$productId = Sys_Secure($_POST['productId']);

	$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}

function fetchProductData(){

	global $connect;

	$sql = "SELECT product_id, product_name FROM product WHERE status = 1 AND active = 1";
	$result = $connect->query($sql);

	$data = $result->fetch_all();

	$connect->close();

	echo json_encode($data);
}
?>