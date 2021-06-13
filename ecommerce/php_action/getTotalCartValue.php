<?php  

require_once 'db_connect.php';

session_start();

if (isset($_SESSION['cartId'])) {
	$cartId = $_SESSION['cartId'];
	$sql = "SELECT SUM((p.rate)*(ci.quantity)) AS totalValue FROM product AS p INNER JOIN cart_item AS ci ON ci.product_id = p.product_id WHERE ci.cart_id = {$cartId}";
	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows

	$connect->close();

	echo json_encode($row);
}
?>