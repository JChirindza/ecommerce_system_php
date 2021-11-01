<?php  
require_once '../../php_action/db_connect.php';
require_once '../../php_action/ctrl_functions_general.php';

session_start();
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'read':
		fetchDeliveryAddress();
		break;
		case 'editAddress':
		updateDeliveryAddress();
		break;

		// default:
		// 	// code...
		// break;
	}
}

function fetchDeliveryAddress() {
	global $connect;

	if (isset($_SESSION['userId'])) {
		$userId = Sys_Secure($_SESSION['userId']);

		$sql = "SELECT * FROM delivery_address WHERE client_id = (SELECT client_id FROM clients WHERE user_id = {$userId})";
		$result = $connect->query($sql);

		if($result->num_rows > 0) { 
			$row = $result->fetch_array();
		} // if num_rows

		$connect->close();

		echo json_encode($row);
	}
}

function updateDeliveryAddress(){
	global $connect;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		// $country 		= Sys_Secure($_POST['country']); 
		$province 		= Sys_Secure($_POST['province']); 
		$address 		= Sys_Secure($_POST['address']); 
		$referencePoint = Sys_Secure($_POST['referencePoint']); 
		$postalCode 	= Sys_Secure($_POST['postalCode']);

		$userId  = Sys_Secure($_SESSION['userId']);
		$sql = "SELECT * FROM clients WHERE user_id = {$userId} AND status = 1";
		$result = $connect->query($sql);
		$clientResult = $result->fetch_array();

		$clientId = $clientResult['client_id'];

		if($result->num_rows <= 0) { 
			// Create client
			$sql = "INSERT INTO `clients`(`user_id`) VALUES ('$userId')";
			$connect->query($sql);
			$clientId = $connect->insert_id;
		}

		$sql = "SELECT * FROM delivery_address WHERE client_id = {$clientId} LIMIT 1";
		$data = $connect->query($sql);

		// Check if user address is set
		if($data->num_rows > 0) { 
			$sql = "UPDATE delivery_address SET province = '$province', address = '$address', reference_point = '$referencePoint', postal_code = '$postalCode' WHERE client_id = {$clientId}";

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully updated";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updatting delivery address information.";
			}
		}else{
			$sql =  "INSERT INTO delivery_address (client_id, province, address, reference_point, postal_code) 
			VALUES ('$clientId', '$province', '$address', '$referencePoint', '$postalCode')";

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully added";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while adding delivery address information.";
			}
		}

		$connect->close();

		echo json_encode($valid);
	}
}