<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$editusername 	= $_POST['edituserName'];
	$editemail 		= $_POST['editEmail'];
	$editpassword 	= md5($_POST['editPassword']);
	$userid 		= $_POST['userid'];
	$userStatus		= $_POST['eidtUserStatus'];
				
	$sql = "UPDATE users SET username = '$editusername', email = '$editemail', password = '$editpassword', active = '$userStatus', status = 1 WHERE user_id = $userid ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
