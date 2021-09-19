<?php  
require_once 'core.php';
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createUser();
		break;
		case 'read':
		fetchUser();
		break;
		case 'update':
		editUser();
		break;
		case 'updateImage':
		editUserImage();
		break;
		case 'delete':
		removeUser();
		break;
		case 'readSelected':
		fetchSelectedUser();
		break;
		case 'readImageUrl':
		fetchUserImageUrl();
		break;
		// User profile settings
		case 'changeEmail':
		changeUserEmail();
		break;
		case 'changePassword':
		changeUserPassword();
		break;
		case 'changeUsername':
		changeUsername();
		break;
		case 'changeUserImage':
		changeUserImage();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

/**
 * 
 * */
function createUser(){

	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	
		$name 		= Sys_Secure($_POST['userName']);
		$surname 	= Sys_Secure($_POST['userSurname']);
		$uemail 	= Sys_Secure($_POST['uemail']);
		$upassword 	= Sys_Secure(md5($_POST['upassword']));
		$permittion	= Sys_Secure($_POST['permittion']);
		$url 		= '../assests/images/photo_default.png';

		$sql1 = "SELECT * FROM users WHERE email = '$uemail' ";
		$query1 = $connect->query($sql1);
		$count = $query1->num_rows;

		if ($count == 0) {
			$sql = "INSERT INTO users (name, surname, email, password, user_image, type, permittion, active, status) 
			VALUES ('$name', '$surname' , '$uemail', '$upassword', '$url', 1, '$permittion', 1, 1)";

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
}

/**
 * 
 * */
function fetchUser(){
	
	global $connect;

	$sql = "SELECT * FROM users WHERE status = 1 AND type = 1 ORDER BY user_id DESC";

	$result = $connect->query($sql);

	$output = array('data' => array());
	if($result->num_rows > 0) {

		$type = ""; 
		$permittion = ""; 
		$active = ""; 

		while($row = $result->fetch_array()) {
			$userid = $row[0];
 			// active 
			$name = $row[1];
			// surname
			$surname = $row[2];
 			// email
			$email = $row[3];
			// Image
			$imageUrl = substr($row[5], 3);
			$userImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:30px;'  />";

			// active 
			if($row[8] == 1) {
				$active = "<label class='badge badge-success'>Activo</label>";
			} else {
				$active = "<label class='badge badge-danger'>Inactivo</label>";
			}

			$button = '
			<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser('.$userid.')"> <i class="fas fa-user-edit"></i></button>
			<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeUserModal" id="removeUserModalBtn" onclick="removeUser('.$userid.')"> <i class="fas fa-trash"></i></button>   
			';

			$output['data'][] = array(
				// image
				$userImage, 		
 				// name
				$name,
				// surname
				$surname,
 				// email
				$email,
 				// active
				$active,
 				// button
				$button 		
			); 	
	 	} // /while 
	}// if num_rows

	$connect->close();

	echo json_encode($output);
}

/**
 * 
 * */
function editUser(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {

		$userid 		= Sys_Secure($_POST['userid']);
		$editName 		= Sys_Secure($_POST['editName']);
		$editSurname 	= Sys_Secure($_POST['editSurname']);
		$editemail 		= Sys_Secure($_POST['editEmail']);
		$editPermittion = Sys_Secure($_POST['editPermittion']);
		$userStatus		= Sys_Secure($_POST['editUserStatus']);

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
}

/**
 * 
 * */
function removeUser(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	$userid = Sys_Secure($_POST['userid']);

	if($userid) {
		$sql = "UPDATE users SET active = 2, status = 2 WHERE user_id = {$userid}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Removed";		
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while remove the user";
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

/**
 * 
 * */
function fetchSelectedUser(){
	
	global $connect;

	$userid = Sys_Secure($_POST['userid']);

	$sql = "SELECT * FROM users WHERE user_id = $userid";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows
	$connect->close();

	echo json_encode($row);
}


/**
 * 
 * */
function fetchUserImageUrl(){
	
	global $connect;

	$userId = Sys_Secure($_GET['i']);

	$sql = "SELECT user_image FROM users WHERE user_id = {$userId}";
	$data = $connect->query($sql);
	$result = $data->fetch_row();

	$connect->close();

	echo "users/" . $result[0];
}

/**
 * 
 * */
function editUserImage(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {		

		$userId = Sys_Secure($_POST['userid']);

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

/********************** USER PROFILE - SETTINGS **********************/
/**
 * 
 * */
function changeUserEmail(){
	
	global $connect;

	if($_POST) {
		$valid['success'] = array('success' => false, 'messages' => array());

		$uemail = Sys_Secure($_POST['email']);
		$userId = Sys_Secure($_POST['user_id']);

		$sql1  = "SELECT * FROM users WHERE email = '$uemail' ";
		$query = $connect->query($sql1);
		$count = $query->num_rows;

		if ($count == 0) {

			$sql = "UPDATE users SET email = '$uemail' WHERE user_id = {$userId}";

			if($connect->query($sql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Update";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating user info";
			}
		}else{
			$valid['success'] = false;
			$valid['messages'] = "Existing email, please type another one!";
		}
		$connect->close();

		echo json_encode($valid);
	}
}

/**
 * 
 * */
function changeUserPassword(){
	
	global $connect;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$currentPassword 	= Sys_Secure(md5($_POST['password']));
		$newPassword 		= Sys_Secure(md5($_POST['npassword']));
		$conformPassword 	= Sys_Secure(md5($_POST['cpassword']));
		$userId 			= Sys_Secure($_POST['user_id']);

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

/**
 * 
 * */
function changeUserImage(){
	
	global $connect;

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

/**
 * 
 * */
function changeUsername(){
	
	global $connect;

	if($_POST) {

		$valid['success'] = array('success' => false, 'messages' => array());

		$name 		= Sys_Secure($_POST['name']);
		$surname 	= Sys_Secure($_POST['surname']);
		$userId 	= Sys_Secure($_POST['user_id']);

		$sql = "UPDATE users SET name = '$name', surname = '$surname' WHERE user_id = {$userId}";
		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Update";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while updating user info";
		}
		$connect->close();

		echo json_encode($valid);
	}
}
?>