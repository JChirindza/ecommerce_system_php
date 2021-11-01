<?php  
require_once '../../php_action/db_connect.php';
require_once '../../php_action/ctrl_functions_general.php';
require_once '../../php_action/init.php';

session_start();
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'readSelected':
		fetchSelectedUser();
		break;
		case 'readImageUrl':
		fetchUserImageUrl();
		break;
		case 'editEmail':
		changeUserEmail();
		break;
		case 'editPassword':
		changeUserPassword();
		break;
		case 'editImage':
		changeUserImage();
		break;
		case 'editUsername':
		changeUsername();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function fetchSelectedUser(){

	global $connect;

	$userid = Sys_Secure($_POST['userid']);

	$sql 	= "SELECT * FROM users WHERE user_id = $userid";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}

function fetchUserImageUrl(){
	global $connect;

	$userId = Sys_Secure($_GET['i']);

	$sql 	= "SELECT user_image FROM users WHERE user_id = {$userId}";
	$data 	= $connect->query($sql);
	$result = $data->fetch_row();

	$connect->close();

	echo "users/" . $result[0];
}

function changeUserEmail(){

	global $connect, $language;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$uemail = Sys_Secure($_POST['email']);
		$userId = Sys_Secure($_POST['user_id']);

		$sql1 	= "SELECT * FROM users WHERE email = '$uemail' ";
		$query 	= $connect->query($sql1);
		$count 	= $query->num_rows;

		if ($count == 0) {

			$sql = "UPDATE users SET email = '$uemail' WHERE user_id = {$userId}";

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = $language['successfully-updated'];	
			} else {
				$valid['success'] = false;
				$valid['messages'] = $language['error-while-update'];
			}

		}else{
			$valid['success'] = false;
			$valid['messages'] = $language['existing-email-please-type-another-one'];
		}
		$connect->close();

		echo json_encode($valid);
	}
}

function changeUserPassword(){
	global $connect, $language;

	if($_POST) {

		$valid['success'] 	= array('success' => false, 'messages' => array());

		$currentPassword 	= md5(Sys_Secure($_POST['password']));
		$newPassword 		= md5(Sys_Secure($_POST['npassword']));
		$conformPassword 	= md5(Sys_Secure($_POST['cpassword']));
		$userId 			= Sys_Secure($_POST['user_id']);

		$sql = "SELECT * FROM users WHERE user_id = {$userId}";
		$query = $connect->query($sql);
		$result = $query->fetch_assoc();

		if($currentPassword == $result['password']) {

			if($newPassword == $conformPassword) {

				$updateSql = "UPDATE users SET password = '$newPassword' WHERE user_id = {$userId}";
				if($connect->query($updateSql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = $language['successfully-updated'];		
				} else {
					$valid['success'] = false;
					$valid['messages'] = $language['error-while-update'];	
				}

			} else {
				$valid['success'] = false;
				$valid['messages'] = $language['new-password-does-not-match-with-conform-password'];
			}

		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['current-password-is-incorrect'];
		}

		$connect->close();

		echo json_encode($valid);

	}
}

function changeUserImage(){
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if(isset($_SESSION['userId'])) {	

		$userId = Sys_Secure($_SESSION['userId']);

		$type = explode('.', $_FILES['editUserImage']['name']);
		$type = $type[count($type)-1];		
		$url = '../assests/images/users/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['editUserImage']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['editUserImage']['tmp_name'], $url)) {

					$sql = "UPDATE users SET user_image = '$url' WHERE user_id = $userId";				

					if($connect->query($sql) === TRUE) {									
						$valid['success'] = true;
						$valid['messages'] = $language['successfully-updated'];		
					} else {
						$valid['success'] = false;
						$valid['messages'] = $language['error-while-update'];
					}
				}	else {
					return false;
				}	// /else	
			} // if
		} // if in_array 		
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

function changeUsername(){
	global $connect, $language;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$name 		= Sys_Secure($_POST['name']);
		$surname 	= Sys_Secure($_POST['surname']);
		$userId 	= Sys_Secure($_POST['user_id']);

		$sql = "UPDATE users SET name = '$name', surname = '$surname' WHERE user_id = {$userId}";
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
?>