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
		case 'readSelected':
		fetchSelectedClient();
		break;
		case 'editContact':
		changeClientContact();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function changeClientContact(){
	global $connect;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$contact = Sys_Secure($_POST['contact']);
		$userId  = Sys_Secure($_SESSION['userId']);

		$sql = "UPDATE clients SET contact = '$contact' WHERE user_id = {$userId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Update";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while updating product info";
		}

		$connect->close();

		echo json_encode($valid);
	}
}