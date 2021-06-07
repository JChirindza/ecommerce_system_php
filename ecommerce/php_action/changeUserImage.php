<?php 	

require_once 'db_connect.php';

$valid['success'] = array('success' => false, 'messages' => array());

if(isset($_SESSION['userId'])) {	

	$userId = $_SESSION['userId'];
	
	$type = explode('.', $_FILES['editUserImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/users/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['editUserImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['editUserImage']['tmp_name'], $url)) {

				$sql = "UPDATE users SET user_image = '$url' WHERE user_id = $userId";				

				if($connect->query($sql) === TRUE) {									
					$valid['success'] = true;
					$valid['messages'] = "Successfully Updated";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while updating user image";
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST