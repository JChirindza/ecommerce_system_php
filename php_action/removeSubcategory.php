<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$subcategoryId = $_POST['subcategoryId'];

if($subcategoryId) { 

	$sql = "UPDATE sub_categories SET active = 2, status = 2 WHERE sub_category_id = {$subcategoryId}";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while remove the subcategory";
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST