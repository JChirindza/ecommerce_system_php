<?php  
require_once 'core.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'readSelected':
		fetchSelectedClient();
		break;
		case 'editContact':
		changeClientContact();
		break;

		case 'readClientContact':
		fetchClientContact();
		break;
		// default:
		// 	// code...
		// break;
	}
}

function changeClientContact(){
	global $connect, $language;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$contact = Sys_Secure($_POST['contact']);
		$userId  = Sys_Secure($_SESSION['userId']);

		$sql = "UPDATE clients SET contact = '$contact' WHERE user_id = {$userId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}

		$connect->close();

		echo json_encode($valid);
	}
}

function fetchClientContact() {

	global $connect;

	$userId = Sys_Secure($_SESSION['userId']);
	$sql = "SELECT * FROM clients WHERE user_id = {$userId}";
	$query = $connect->query($sql);
	$result = $query->fetch_assoc();

	$clientId = $result['client_id'];

	$sql = "SELECT contact FROM clients WHERE client_id = {$clientId}";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	}
	$connect->close();

	echo json_encode($row);
}