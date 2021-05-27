<?php 	

require_once 'db_connect.php';

$cartId = $_GET['cartId'];

$sql = "SELECT cart_item_id, product_id, quantity FROM cart_item WHERE cart_id = {$cartId} AND status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

	while($row = $result->fetch_array()) {
		$cartItemId = $row[0];
		$productId = $row[1];
		$quantity = $row[2];

		$sql2 = "SELECT * FROM product WHERE product_id = {$productId} ";
		$query = $connect->query($sql2);
		$resultProduct = $query->fetch_assoc();
		
		$imageUrl = $resultProduct['product_image'];

		$productImage = "
		<a href='product_details.php?product_id=".$productId."'>
		<img class='img-round' src='".$imageUrl."' style='height:80px; width:120px;'/>
		</a>
		";
		$productName = "<a href='product_details.php?product_id=".$productId."'>".$resultProduct['product_name']."</a>";
		$price = $resultProduct['rate'];
		$availableQuantity = $resultProduct['quantity'];
		$total = $price * $quantity;

		$quantityInput = '
		<input type="number" class="col-sm-12 col-md-10 col-lg-8" name="quantity[]" id="quantity<?php echo $x; ?>"  autocomplete="off" class="form-control" min="1" max="'.$availableQuantity.'" value="'.$quantity.'" required>
		<label class="text-muted" style="font-size: 14px;">Available: '.$availableQuantity.'</label>
		';

		$button = '
		<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removeCartItemModal" id="removeCartItemModalBtn" onclick="removeCartItem('.$cartItemId.')"> <i class="fas fa-trash"></i></button>
		';

		$output['data'][] = array( 		
			$productImage,
			$productName,
			$price,
			$quantityInput,
			$total,
			$button 		
		);
 	} // /while 

}// if num_rows

$connect->close();

echo json_encode($output);