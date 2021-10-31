<?php  
require_once 'core.php';
include 'init.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'create':
		createProduct();
		break;
		case 'read':
		fetchProduct();
		break;
		case 'update':
		editProduct();
		break;
		case 'delete':
		removeProduct();
		break;
		case 'readSelected':
		fetchSelectedProduct();
		break;
		case 'updateImage':
		editProductImage();
		break;
		case 'readImageUrl':
		fetchProductImageUrl();
		break;
		case 'readProductInfo':
		fetchProductInfo();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}
/**
 * 
 * */
function createProduct(){
	
	global $connect;
	global $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	

		$productName 	= Sys_Secure($_POST['productName']);
		$quantity 		= Sys_Secure($_POST['quantity']);
		$rate 			= Sys_Secure($_POST['rate']);
		$brandName 		= Sys_Secure($_POST['brandName']);
		$categoryName 	= Sys_Secure($_POST['categoryName']);
		$productStatus 	= Sys_Secure($_POST['productStatus']);

		$type = explode('.', $_FILES['productImage']['name']);
		$type = $type[count($type)-1];		
		$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {

					$sql = "INSERT INTO product (product_name, product_image, brand_id, categories_id, quantity, rate, active, status) 
					VALUES ('$productName', '$url', '$brandName', '$categoryName', '$quantity', '$rate', '$productStatus', 1)";

					if($connect->query($sql) === TRUE) {
						$valid['success'] = true;
						$valid['messages'] = $language['successfully-added'];	
					} else {
						$valid['success'] = false;
						$valid['messages'] = $language['error-while-adding-the-members'];
					}

				} else {
					return false;
				}	// /else	
			} // if
		} // if in_array 		
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

/**
 * 
 * */
function fetchProduct(){

	global $connect;
	global $language;

	$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
	product.categories_id, product.quantity, product.rate, product.active, product.status, 
	brands.brand_name, categories.categories_name FROM product 
	INNER JOIN brands ON product.brand_id = brands.brand_id 
	INNER JOIN categories ON product.categories_id = categories.categories_id  
	WHERE product.status = 1 ORDER BY product_id DESC";

	$result = $connect->query($sql);

	$output = array('data' => array());

	if($result->num_rows > 0) { 

	 	// $row = $result->fetch_array();
		$active = ""; 

		while($row = $result->fetch_array()) {
			$productId = $row[0];
	 	// active 
			if($row[7] == 1) {
	 		// activate member
				$active = "<label class='badge badge-success'>".$language['available']."</label>";
			} else {
	 		// deactivate member
				$active = "<label class='badge badge-danger'>".$language['not-available']."</label>";
	 	} // /else

	 	$button = '<!-- Single button -->
	 	<div class="btn-group">
	 	<a href="products.php?p=detail&i='.$productId.'" class="btn btn-outline-success btn-sm" id="productDetailsBtn"> <i class="fas fa-eye"></i></a>
	 	<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="fas fa-edit"></i></button>
	 	<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="fas fa-trash"></i></button>       
	 	</div>';

	 	$brand = $row[9];
	 	$category = $row[10];

	 	$imageUrl = substr($row[2], 3);
	 	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

	 	$output['data'][] = array( 		
	 		// image
	 		$productImage,
	 		// product name
	 		$row[1], 
	 		// rate
	 		$row[6],
	 		// quantity 
	 		$row[5], 		 	
	 		// brand
	 		$brand,
	 		// category 		
	 		$category,
	 		// active
	 		$active,
	 		// button
	 		$button 		
	 	); 	
	 	} // /while 

	}// if num_rows
	$connect->close();

	echo json_encode($output);
}

/**
 * 
 * */
function editProduct(){
	
	global $connect;
	global $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {
		$productId 		= Sys_Secure($_POST['productId']);
		$productName 	= Sys_Secure($_POST['editProductName']); 
		$quantity 		= Sys_Secure($_POST['editQuantity']);
		$rate 			= Sys_Secure($_POST['editRate']);
		$brandName 		= Sys_Secure($_POST['editBrandName']);
		$categoryName 	= Sys_Secure($_POST['editCategoryName']);
		$productStatus 	= Sys_Secure($_POST['editProductStatus']);


		$sql = "UPDATE product SET product_name = '$productName', brand_id = '$brandName', categories_id = '$categoryName', quantity = '$quantity', rate = '$rate', active = '$productStatus', status = 1 WHERE product_id = $productId ";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-updated'];	
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-update'];
		}
	} // /$_POST
	$connect->close();

	echo json_encode($valid);
}

/**
 * 
 * */
function editProductImage(){
	
	global $connect;

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {		
		$productId = Sys_Secure($_POST['productId']);

		$type = explode('.', $_FILES['editProductImage']['name']);
		$type = $type[count($type)-1];		
		$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['editProductImage']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['editProductImage']['tmp_name'], $url)) {

					$sql = "UPDATE product SET product_image = '$url' WHERE product_id = $productId";				

					if($connect->query($sql) === TRUE) {									
						$valid['success'] = true;
						$valid['messages'] = $language['successfully-updated'];	
					} else {
						$valid['success'] = false;
						$valid['messages'] = $language['error-while-updating-image'];
					}
				} else {
					return false;
				}	// /else	
			} // if
		} // if in_array 		
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
}

/**
 * 
 * */
function removeProduct(){
	
	global $connect;
	global $language;

	$valid['success'] = array('success' => false, 'messages' => array());

	$productId = Sys_Secure($_POST['productId']);

	if($productId) { 

		$sql = "UPDATE product SET active = 2, status = 2 WHERE product_id = {$productId}";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = $language['successfully-removed'];		
		} else {
			$valid['success'] = false;
			$valid['messages'] = $language['error-while-remove'];
		}
		$connect->close();

		echo json_encode($valid);
	} // /if $_POST
} 

/**
 * 
 * */
function fetchSelectedProduct(){
	
	global $connect;

	$productId = Sys_Secure($_POST['productId']);

	$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows
	$connect->close();

	echo json_encode($row);
} 

/**
 * 
 * */
function fetchProductImageUrl(){
	
	global $connect;

	$productId = Sys_Secure($_GET['i']);

	$sql = "SELECT product_image FROM product WHERE product_id = {$productId}";
	$data = $connect->query($sql);
	$result = $data->fetch_row();

	$connect->close();

	echo "stock/" . $result[0];

}

function fetchProductInfo() {

	global $connect;

	if (isset($_POST['product_id'])) {
		$productId = Sys_Secure($_POST['product_id']);

		$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
		product.categories_id, product.quantity, product.rate, product.active,
		brands.brand_name, categories.categories_name FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1 AND product.product_id = {$productId}";

		$query = $connect->query($sql);
		$prodInfo = $query->fetch_assoc();

		$connect->close();

		echo json_encode($prodInfo);
	}
}
?>