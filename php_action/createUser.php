<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$name 	= $_POST['name'];
	$name 	= $_POST['surname'];
	$uemail 	= $_POST['uemail'];
	$upassword 	= md5($_POST['upassword']);
	$permittion	= $_POST['permittion'];
	$url 		= '../assests/images/photo_default.png';
	
	$sql1 = "SELECT * FROM users WHERE email = '$uemail' ";
	$query1 = $connect->query($sql1);
	$count = $query1->num_rows;

	if ($count == 0) {
		$sql = "INSERT INTO users (name, surname, email, password, user_image, type, permittion, active, status) 
		VALUES ('$userName' , '$uemail', '$upassword', '$url', 1, '$permittion', 1, 1)";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Added";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members";
		}
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Existing email, please type another one!";
	}
	
} // if in_array 		

$connect->close();

echo json_encode($valid);

