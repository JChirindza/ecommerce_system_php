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
		case 'printRequest':
		printRequest();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function fetchRequests(){
	
	global $connect, $language;


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
	INNER JOIN users ON clients.user_id = users.user_id";

	$result = $connect->query($sql);

	if($result->num_rows > 0) { 

		$pendingStatus = ""; 
		$paymentType = "";
		$x = 1;
		while($row = $result->fetch_array()) {

			$cartHasPaidId = $row['cart_has_paid_id'];
			$dtResponded = $row['dt_requested'];
			$clientName = $row['name']." ".$row['surname'];
			$contact = $row['contact'];
			$totalItems = $row['totalItems'];

 			// payment_status 
			if($row['active'] == 1) {
				$pendingStatus = "<label class='badge badge-warning'>".$language['pending-request']."</label>";
			} else {
				$pendingStatus = "<label class='badge badge-success'>".$language['responded']."</label>";
	 		} // /else

	 		// payment_type 
	 		if($row['payment_type'] == 1) {
	 			$paymentType = "<label class='badge badge-danger rounded-0'>Mpesa</label>";
	 		} else {
	 			$paymentType = "<label class='badge badge-primary rounded-0'>VISA</label><label class='badge badge-info rounded-0'>MasterCard</label>";
	 		} // /else

	 		$button = '<!-- Single button -->
	 		<div class="btn-group">
		 	<a href="request.php?r=respreq&i='.$cartHasPaidId.'" class="btn btn-outline-success btn-sm"> <i class="fas fa-eye"></i></a>
		 	<button class="btn btn-outline-primary btn-sm" onclick="printRequest('.$cartHasPaidId.')"> <i class="fas fa-print"></i></button>
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

	global $connect, $language;

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
				$valid['messages'] = "".$language['error-while-confirm-this-request-was-been-confirmed']."!";
			}
		}else{
			$valid['messages'] = "".$language['error-while-confirm-request']."!";
		}
	}else {
		$valid['messages'] = "".$language['error-while-confirm-request']."!";
	}
	$connect->close();

	echo json_encode($valid);
}

function printRequest() {
	global $connect, $language;

	$cartHasPaidId = Sys_Secure($_POST['cartHasPaidId']);
	
	$sql = "SELECT cart_has_paid.dt_paid, 
	users.name, 
	users.surname, 
	clients.contact,
	cart_has_paid.sub_total,
	cart_has_paid.vat,
	cart_has_paid.total_amount,
	cart_has_paid.discount,
	cart_has_paid.grand_total,
	cart_has_paid.payment_type,
	(SELECT active 
	FROM requests 
	WHERE cart_has_paid_id = cart_has_paid.cart_has_paid_id) 
	AS active
	FROM cart_has_paid
	INNER JOIN cart ON cart_has_paid.cart_id = cart.cart_id 
	INNER JOIN clients ON cart.user_id = clients.user_id 
	INNER JOIN users ON clients.user_id = users.user_id
	WHERE cart_has_paid_id = {$cartHasPaidId} ORDER BY cart_has_paid_id DESC";
	$query = $connect->query($sql);
	$resultData = $query->fetch_array();

	$dateRequested = $resultData['dt_paid'];
	$clientName = $resultData['name']." ".$resultData['surname'];
	$clientContact = $resultData['contact']; 
	$subTotal = $resultData['sub_total'];
	$vat = $resultData['vat'];
	$totalAmount = $resultData['total_amount']; 
	$discount = $resultData['discount'];
	$grandTotal = $resultData['grand_total'];
	$paymentType = $resultData['payment_type'];

	$sql = "SELECT * FROM `cart_item_has_paid` WHERE cart_has_paid_id = {$cartHasPaidId}";
	$itemResult = $connect->query($sql);

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
	   #items td.total-value { border-left: 0; padding: 10px; font-weight:bold;}
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
	Maputo, '.$language['mozambique'].';<br>
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

	<td class="meta-head">'.$language['contact'].': </td>
	<td>'.$clientContact.'</td>
	</tr>
	<tr>
	<td class="meta-head">NUIT: </td>
	<td>3453453</div></td>
	</tr>
	</table>

	<table id="meta">
	<tr>
	<td class="meta-head">Recibo & Data Nr.</td>
	<td>'.$dateRequested.'</td>
	</tr>
	<tr>

	<td class="meta-head">'.$language['date'].'</td>
	<td>'.$dateRequested.'</td>
	</tr>
	</table>
	</div>

	<table id="items">

	<tr>
	<th width="5%">#</th>
	<th width="55%">'.$language['product-description'].'</th>
	<th width="15%">'.$language['price'].'</th>
	<th width="10%">'.$language['quantity'].'</th>
	<th width="15%">'.$language['total-amount'].'</th>
	</tr>
	';
	$x = 1;
	while($row = $itemResult->fetch_array()) { 

		$itemId = $row['cart_item_has_paid_id'];
		$productId = $row['product_id'];
		$quantity = $row['quantity'];
		$paidPrice = $row['paid_price'];

		$sql2 = "SELECT * FROM product WHERE product_id = {$productId}";
		$query = $connect->query($sql2);
		$resultProduct = $query->fetch_assoc();

		$table .= '
		<tr class="item-row"> 
		<td class="item-name"><label>'.$x.'</label></td>
		<td class="description"><label>'.$resultProduct['product_name'].'</label></td>
		<td><label class="cost">'.number_format($paidPrice,2,",",".").'</label></td>
		<td><label class="qty">'.$quantity.'</label></td>
		<td><span class="price">'.number_format($paidPrice * $quantity,2,",",".").'</span></td>
		</tr>
		';
		$x++;
    } // /while
    
    $table.= '
    <tr>
    <td colspan="2" class="blank"></td>
    <td colspan="2" class="total-line">'.$language['total-amount'].'</td>
    <td class="total-value"><div id="subtotal">'.number_format($subTotal,2,",",".").'</div></td>
    </tr>
    <tr>
    <td colspan="2" class="blank"></td>
    <td colspan="2" class="total-line balance">'.$language['grand-total'].'</td>
    <td class="total-value balance"><div class="due">'.number_format($grandTotal,2,",",".").' MZN</div></td>
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