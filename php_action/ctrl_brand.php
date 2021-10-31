<?php 	
require_once 'core.php';
include 'init.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createBrand();
		break;
		case 'read':
		fetchBrand();
		break;
		case 'update':
		editBrand();
		break;
		case 'delete':
		removeBrand();
		break;
		case 'readSelected':
		fetchSelectedBrand();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function createBrand(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());
	
	if($_POST) {	

		$brandName 		= Sys_Secure($_POST['brandName']);
		$brandStatus 	= Sys_Secure($_POST['brandStatus']); 

		$sql = "INSERT INTO brands (brand_name, brand_active, brand_status) VALUES ('$brandName', '$brandStatus', 1)";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-added'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-adding-the-members'];
		}
	} // /if $_POST

	$connect->close();

	echo json_encode($valid);
}

function fetchBrand(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 ORDER BY brand_id DESC";
	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

		$activeBrands = ""; 

		while($row = $result->fetch_array()) {
			$brandId = $row[0];
 			// active 
			if($row[2] == 1) {
 				// activate brands
				$activeBrands = "<label class='badge badge-success'>".$language['available']."</label>";
			} else {
 				// deactivate brands
				$activeBrands = "<label class='badge badge-danger'>".$language['not-available']."</label>";
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
}

function editBrand(){
	
	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$brandName 		= Sys_Secure($_POST['editBrandName']);
		$brandStatus 	= Sys_Secure($_POST['editBrandStatus']); 
		$brandId 		= Sys_Secure($_POST['brandId']);

		$sql = "UPDATE brands SET brand_name = '$brandName', brand_active = '$brandStatus' WHERE brand_id = '$brandId'";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}
	} // /if $_POST

	$connect->close();

	echo json_encode($valid);
}

function removeBrand(){

	global $connect, $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	$brandId = Sys_Secure($_POST['brandId']);

	if($brandId) { 

		$sql = "UPDATE brands SET brand_active = 2, brand_status = 2 WHERE brand_id = {$brandId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-removed'];		
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-remove'];
		}
	} // /if $_POST

	$connect->close();

	echo json_encode($valid);
}

function fetchSelectedBrand(){
	
	global $connect;

	$brandId = Sys_Secure($_POST['brandId']);

	$sql = "SELECT * FROM brands WHERE brand_id = $brandId";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}