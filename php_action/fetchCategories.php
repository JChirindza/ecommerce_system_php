<?php 	

require_once 'core.php';

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeCategories = ""; 

 while($row = $result->fetch_array()) {
 	$categoriesId = $row[0];
 	// active 
 	if($row[2] == 1) {
 		// activate member
 		$activeCategories = "<label class='badge badge-success'>Available</label>";
 	} else {
 		// deactivate member
 		$activeCategories = "<label class='badge badge-danger'>Not Available</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
		<a href="categoria.php?c=subc&i='.$categoriesId.'" class="btn btn-outline-success btn-sm" id="categoryDetailsBtn"> <i class="fas fa-eye"></i></a>
	    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editCategories('.$categoriesId.')"> <i class="fas fa-edit"></i></button>
	    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoriesModalBtn" onclick="removeCategories('.$categoriesId.')"> <i class="fas fa-trash"></i></button>
	</div>';

 	$output['data'][] = array( 		
 		$row[1], 		
 		$activeCategories,
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);