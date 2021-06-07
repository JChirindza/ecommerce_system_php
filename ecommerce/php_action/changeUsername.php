<?php 

require_once 'db_connect.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$name 		= $_POST['name'];
	$surname 	= $_POST['surname'];
	$userId 	= $_POST['user_id'];

	$sql = "UPDATE users SET name = '$name', surname = '$surname' WHERE user_id = {$userId}";
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

?>