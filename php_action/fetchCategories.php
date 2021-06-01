<?php 	

require_once 'core.php';

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
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
		<a href="categoria.php?c=subc&i='.$categoriesId.'" class="btn btn-outline-success btn-sm" id="categoryDetailsBtn"> <i class="fas fa-eye"></i></a>
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