<?php  

/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	switch($action) {
		case 'create':
		createSubcategory();
		break;
		case 'read':
		fetchSubcategories();
		break;
		case 'update':
		editSubcategory();
		break;
		case 'delete':
		removeSubcategory();
		break;
		case 'readSelected':
		fetchSelectedSubcategory();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

/**
 * 
 * */
function createSubcategory(){
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
}

/**
 * 
 * */
function fetchSubcategories(){
	require_once 'core.php';

	$category_id = $_GET['categories_id'];

	$sql = "SELECT sub_categories.sub_category_id, sub_categories.sub_category_name, sub_categories.active FROM sub_categories INNER JOIN categories ON sub_categories.categories_id = categories.categories_id WHERE sub_categories.status = 1 AND categories.categories_id = {$category_id} ORDER BY sub_categories.sub_category_id DESC";

	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

 		// $row = $result->fetch_array();
		$active = ""; 
		$x = 1;
		while($row = $result->fetch_array()) {
			$subcategoryId = $row[0];
 			// active 
			if($row[2] == 1) {
 				// activate member
				$active = "<label class='badge badge-success'>Available</label>";
			} else {
 				// deactivate member
				$active = "<label class='badge badge-danger'>Not Available</label>";
	 		} // /else

	 		$button = '<!-- button -->
	 		<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editSubcategoryModalBtn" data-target="#editSubcategoryModal" onclick="editSubcategory('.$subcategoryId.')"> <i class="fas fa-edit"></i></button>
	 		<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeSubcategoryModal" id="removeSubcategoryModalBtn" onclick="removeSubcategory('.$subcategoryId.')"> <i class="fas fa-trash"></i></button>       
	 		';

	 		$output['data'][] = array( 		
		 		// #
	 			$x,
		 		// name 
	 			$row[1], 
		 		// active
	 			$active,
		 		// button
	 			$button 		
	 		); 	
	 		$x++;
	 	} // /while 

	}// if num_rows
	$connect->close();

	echo json_encode($output);
}

/**
 * 
 * */
function editSubcategory(){
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
}

/**
 * 
 * */
function removeSubcategory(){
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
}

/**
 * 
 * */
function fetchSelectedSubcategory(){
	require_once 'core.php';

	$subcategoryId = $_POST['subcategoryId'];

	$sql = "SELECT sub_category_id, sub_category_name, active FROM sub_categories WHERE sub_category_id = {$subcategoryId}";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}
?>