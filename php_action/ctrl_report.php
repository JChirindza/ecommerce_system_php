<?php  
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	switch($action) {
		case 'genOrderReport':
		getOrderReport();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

/**
 * 
 * */
function getOrderReport(){
	require_once 'core.php';

	if($_POST) {

		// $startDate = $_POST['startDate'];
		// echo 'Data INICIO: '.$startDate;
		// $date = DateTime::createFromFormat('Y-m-d',$startDate);
		$start_date = $_POST['startDate'];


		// $endDate = $_POST['endDate'];
		// echo 'Data FIM: '.$endDate;
		// $format = DateTime::createFromFormat('Y-m-d',$endDate);
		$end_date = $_POST['endDate'];

		$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
		$query = $connect->query($sql);

		$table = '
		<table border="1" cellspacing="0" cellpadding="0" style="width:100%; border: 0px;">
			<tr>
				<th>Order Date</th>
				<th>Client Name</th>
				<th>Contact</th>
				<th>Grand Total</th>
			</tr>

			<tr>';
			$totalAmount = 0;
			while ($result = $query->fetch_assoc()) {
				$table .= '<tr>
					<td><center>'.$result['order_date'].'</center></td>
					<td><center>'.$result['client_name'].'</center></td>
					<td><center>'.$result['client_contact'].'</center></td>
					<td><center>'.$result['grand_total'].'</center></td>
				</tr>';	
				$totalAmount += $result['grand_total'];
			}
			$table .= '
			</tr>

			<tr>
				<td colspan="3"><center>Total Amount</center></td>
				<td><center>'.$totalAmount.'</center></td>
			</tr>
		</table>
		';	

		echo $table;

	}
}
?>