<?php 	

require_once 'core.php';

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
	$activeBrands = ""; 

	while($row = $result->fetch_array()) {
		$brandId = $row[0];
 		// active 
		if($row[2] == 1) {
 		// activate member
			$activeBrands = "<label class='badge badge-success'>Available</label>";
		} else {
 		// deactivate member
			$activeBrands = "<label class='badge badge-danger'>Not Available</label>";
		}

		$button = '<!-- Single button -->
		
		<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands('.$brandId.')"> <i class="fas fa-edit"></i></button>
		<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$brandId.')"> <i class="fas fa-trash"></i></button>    
		';

		$output['data'][] = array( 		
			$row[1], 		
			$activeBrands,
			$button
		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);