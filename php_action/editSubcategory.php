<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$subcategoryId 	= $_POST['subcategoryId'];
	$subcategoryName 		= $_POST['editSubcategoryName']; 
  	$subcateogryStatus 		= $_POST['editSubcategoryStatus'];

	$sql = "UPDATE sub_categories SET sub_category_name = '$subcategoryName', active = '$subcateogryStatus', status = 1 WHERE sub_category_id = $subcategoryId";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating subcategory";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);