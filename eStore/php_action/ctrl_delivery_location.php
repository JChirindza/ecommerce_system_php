<?php  
require_once 'db_connect.php';
require_once '../../php_action/ctrl_functions_general.php';
session_start();
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createLocationForDelivery();
		break;
		case 'read':
		fetchLocationForDelivery();
		break;
		case 'update':
		editLocationForDelivery();
		break;
		case 'delete':
		removeLocationForDelivery();
		break;
		case 'readSelected':
		fetchSelectedLocationForDelivery();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function createLocationForDelivery(){

	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$userId 	= Sys_Secure($_SESSION['userId']);
		$country 	= Sys_Secure($_POST['country']);
		$province 	= Sys_Secure($_POST['province']);
		$address 	= Sys_Secure($_POST['address']);
		$refPoint 	= Sys_Secure($_POST['reference_point']);
		$postalCode = Sys_Secure($_POST['postal_code']);

		$sql1 = "SELECT client_id FROM clients WHERE user_id = '$userId' ";
		$data = $connect->query($sql1);
		$clientId = $data->fetch_row();

		$sql = "INSERT INTO delivery_address (client_id, country, province, address, reference_point, postal_code) 
		VALUES ('$clientId', '$country' , '$province', '$address', '$refPoint', '$postalCode')";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Added";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members";
		}
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
}