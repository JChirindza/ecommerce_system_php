<?php 	



require_once 'core.php';

$sql = "SELECT * FROM users";

$result = $connect->query($sql);

$output = array('data' => array());
if($result->num_rows > 0) { 

 	// $row = $result->fetch_array();
	$active = ""; 

	while($row = $result->fetch_array()) {
		$userid = $row[0];
 		// active 
		$username = $row[1];
 		// email
		$email = $row[2];
		// Image
		$imageUrl = substr($row[4], 3);
		$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:30px;'  />";

		// active 
		if($row[5] == 1) {
 			// activate member
			$active = "<label class='badge badge-success'>Activo</label>";
		} else {
 			// deactivate member
			$active = "<label class='badge badge-danger'>Inactivo</label>";
		}

		$button = '
		<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser('.$userid.')"> <i class="fas fa-user-edit"></i></button>
		<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeUserModal" id="removeUserModalBtn" onclick="removeUser('.$userid.')"> <i class="fas fa-trash"></i></button>   
		';

		$output['data'][] = array(
			// image
			$productImage, 		
 			// name
			$username,
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