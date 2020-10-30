<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$userName 		= $_POST['userName'];
	$uemail 		= $_POST['uemail'];
	$upassword 		= md5($_POST['upassword']);
	$userStatus 	= $_POST['userStatus'];

	$type = explode('.', $_FILES['userImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/users/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['userImage']['tmp_name'], $url)) {
				
				$sql = "INSERT INTO users (username, email, password, user_image, active, status) 
				VALUES ('$userName' , '$uemail', '$upassword', '$url', 1, '$userStatus')";
				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		
} // if in_array 		

$connect->close();

echo json_encode($valid);

