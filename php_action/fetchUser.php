<?php 	



require_once 'core.php';

$sql = "SELECT * FROM users WHERE permittion != 0";

$result = $connect->query($sql);

$output = array('data' => array());
if($result->num_rows > 0) { 

 	// $row = $result->fetch_array();
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
		$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:30px;'  />";

		// type 
		// if($row[6] == 1) {
		// 	$type = "<label class='badge badge-success'>Funcionario</label>";
		// } else {
		// 	$type = "<label class='badge badge-primary'>Cliente</label>";
		// }

		// permittion 
		// if($row[7] == 1) {
		// 	$permittion = "<label class='badge badge-info'>Administrador</label>";
		// } elseif ($row[7] == 2) {
		// 	$permittion = "<label class='badge badge-warning'>Gestor</label>";
		// } else {
		// 	$permittion = "<label class='badge badge-secondary'>Vendedor</label>";
		// }

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
			$productImage, 		
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