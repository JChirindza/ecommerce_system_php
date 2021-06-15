<?php  

/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
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
	require_once 'db_connect.php';

	$userid = $_POST['userid'];

	$sql = "SELECT * FROM users WHERE user_id = $userid";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}

function fetchUserImageUrl(){
	require_once 'db_connect.php';

	$userId = $_GET['i'];

	$sql = "SELECT user_image FROM users WHERE user_id = {$userId}";
	$data = $connect->query($sql);
	$result = $data->fetch_row();

	$connect->close();

	echo "users/" . $result[0];
}

function changeUserEmail(){
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
}

function changeUserPassword(){
	require_once 'db_connect.php';

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$currentPassword = md5($_POST['password']);
		$newPassword = md5($_POST['npassword']);
		$conformPassword = md5($_POST['cpassword']);
		$userId = $_POST['user_id'];

		$sql ="SELECT * FROM users WHERE user_id = {$userId}";
		$query = $connect->query($sql);
		$result = $query->fetch_assoc();

		if($currentPassword == $result['password']) {

			if($newPassword == $conformPassword) {

				$updateSql = "UPDATE users SET password = '$newPassword' WHERE user_id = {$userId}";
				if($connect->query($updateSql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Updated";		
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while updating the password";	
				}

			} else {
				$valid['success'] = false;
				$valid['messages'] = "New password does not match with Conform password";
			}

		} else {
			$valid['success'] = false;
			$valid['messages'] = "Current password is incorrect";
		}

		$connect->close();

		echo json_encode($valid);

	}
}

function changeUserImage(){
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
}

function changeUsername(){
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
}
?>