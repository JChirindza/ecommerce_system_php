<?php  
require_once 'core.php';
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createCategory();
		break;
		case 'read':
		fetchCategories();
		break;
		case 'update':
		editCategory();
		break;
		case 'delete':
		removeCategory();
		break;
		case 'readSelected':
		fetchSelectedCategory();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}


/**
 * 
 * */
function createCategory(){

	global $connect;	

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$categoriesName 	= Sys_Secure($_POST['categoriesName']);
		$categoriesStatus 	= Sys_Secure($_POST['categoriesStatus']); 

		$sql = "INSERT INTO categories (categories_name, categories_active, categories_status) 
		VALUES ('$categoriesName', '$categoriesStatus', 1)";

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
 **/
function fetchCategories(){

	global $connect;

	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1";
	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

		$active = ""; 
		$x = 1;
		while($row = $result->fetch_array()) {
			$categoriesId = $row[0];

			$sql = "SELECT COUNT(sc.categories_id) as TotalSubcategories, (SELECT COUNT(p.product_id) 
			FROM product AS p
			WHERE  p.status = 1 AND p.categories_id = {$categoriesId}) AS TotalProducts 
			FROM sub_categories AS sc 
			WHERE sc.categories_id = {$categoriesId} AND sc.status = 1";

			$counts = $connect->query($sql);
			$totalCounts = $counts->fetch_assoc();

 			// active 
			if($row[2] == 1) {
 			// activate member
				$active = "<label class='badge badge-success'>Available</label>";
			} else {
 			// deactivate member
				$active = "<label class='badge badge-danger'>Not Available</label>";
			}

			$button = '<!-- Single button -->
			<div class="btn-group">
			<a href="categories.php?c=subc&i='.$categoriesId.'" class="btn btn-outline-success btn-sm" id="categoryDetailsBtn"> <i class="fas fa-eye"></i></a>
			<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editCategories('.$categoriesId.')"> <i class="fas fa-edit"></i></button>
			<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoriesModalBtn" onclick="removeCategories('.$categoriesId.')"> <i class="fas fa-trash"></i></button>
			</div>';

			$output['data'][] = array(
				$x, 		
				$row[1],
				$totalCounts['TotalSubcategories'],
				$totalCounts['TotalProducts'],
				$active,
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
function editCategory(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$brandName = Sys_Secure($_POST['editCategoriesName']);
		$brandStatus = Sys_Secure($_POST['editCategoriesStatus']); 
		$categoriesId = Sys_Secure($_POST['editCategoriesId']);

		$sql = "UPDATE categories SET categories_name = '$brandName', categories_active = '$brandStatus' WHERE categories_id = '$categoriesId'";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Updated";	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while updating the categories";
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

/**
 * 
 * */
function removeCategory(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	$categoriesId = Sys_Secure($_POST['categoriesId']);

	if($categoriesId) { 

		$sql = "UPDATE categories SET categories_active = 2, categories_status = 2 AND WHERE categories_id = {$categoriesId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Removed";		
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while remove the brand";
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

/**
 * 
 * */
function fetchSelectedCategory(){
	require_once 'core.php';

	$categoriesId = Sys_Secure($_POST['categoriesId']);

	$sql = "SELECT * FROM categories WHERE categories_id = $categoriesId";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}
?>