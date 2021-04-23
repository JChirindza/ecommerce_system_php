<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$userid 		= $_POST['userid'];
	$editName 		= $_POST['editName'];
	$editSurname 	= $_POST['editSurname'];
	$editemail 		= $_POST['editEmail'];
	$editPermittion = $_POST['editPermittion'];
	$userStatus		= $_POST['editUserStatus'];
				
	$sql = "UPDATE users SET name = '$editName', surname = '$editSurname', email = '$editemail', permittion = '$editPermittion', active = '$userStatus' WHERE user_id = $userid ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating user info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);