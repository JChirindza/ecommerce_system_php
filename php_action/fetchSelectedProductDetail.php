<?php 	

require_once 'core.php';

$productDetailId = $_POST['productDetailId'];

$sql = "SELECT id, detail, description, active, status FROM product_details WHERE id = $productDetailId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);