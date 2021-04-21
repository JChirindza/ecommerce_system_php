<?php 	

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
			$active = "<label class='badge badge-success'>Active</label>";
		} else {
 			// deactivate member
			$active = "<label class='badge badge-danger'>Not Active</label>";
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