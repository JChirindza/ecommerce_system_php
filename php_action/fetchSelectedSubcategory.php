<?php 	

require_once 'core.php';

$subcategoryId = $_POST['subcategoryId'];

$sql = "SELECT sub_category_id, sub_category_name, active FROM sub_categories WHERE sub_category_id = {$subcategoryId}";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);