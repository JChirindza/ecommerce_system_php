<?php 

require_once 'db_connect.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$uemail = $_POST['email'];
	$userId = $_POST['user_id'];

	$sql1 = "SELECT * FROM users WHERE email = '$uemail' ";
	$query = $connect->query($sql1);
	$count = $query->num_rows;

	if ($count == 0) {

		$sql = "UPDATE users SET email = '$uemail' WHERE user_id = {$userId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Update";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while updating product info";
		}

	}else{
		$valid['success'] = false;
		$valid['messages'] = "Existing email, please type another one!";
	}

	$connect->close();

	echo json_encode($valid);

}

?>