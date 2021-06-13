<?php  

require_once 'db_connect.php';

session_start();

if (isset($_SESSION['cartId'])) {

	$cartId = $_SESSION['cartId'];
	$sql = "SELECT COUNT(*) AS totalQuantiy FROM cart_item WHERE cart_id = {$cartId}";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}
?>