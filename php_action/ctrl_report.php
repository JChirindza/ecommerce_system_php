<!-- ctrl_report -->
<?php  
require_once 'core.php';
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
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
	
	global $connect;

	$start_date = Sys_Secure($_POST['startDate']);

	$end_date = Sys_Secure($_POST['endDate']);

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
				<td><center>'.number_format($result['grand_total'],2,',','.').'</center></td>
			</tr>';	
			$totalAmount += $result['grand_total'];
		}
		$table .= '
		</tr>

		<tr>
			<td colspan="3"><center>Total Amount</center></td>
			<td><center>'.number_format($totalAmount,2,',','.').'</center></td>
		</tr>
	</table>
	';	

	$connect->close();

	echo $table;
}
?>