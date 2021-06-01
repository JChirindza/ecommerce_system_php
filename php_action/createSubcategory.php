<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$categoryId = $_POST['categoryId'];
	$subcategoryName = $_POST['subcategoryName'];
  	$subcategoryStatus = $_POST['subcategoryStatus']; 

	$sql = "INSERT INTO sub_categories (categories_id, sub_category_name, active, status) VALUES ('$categoryId', '$subcategoryName', '$subcategoryStatus', 1)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST