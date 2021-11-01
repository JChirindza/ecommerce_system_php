<?php  
require_once 'core.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'read':
		fetchClients();
		break;
		case 'readSelected':
		fetchSelectedClient();
		break;
		case 'readImageUrl':
		fetchClientImageUrl();
		break;
		case 'readCounters':
		clientsCounter();
		break;
		case 'readDetails':
		fetchClientDetails();
		break;
	}
}

function fetchClients(){
	
	global $connect, $language;

	$sql = "SELECT clients.client_id, clients.contact,
	users.user_image,
	users.name, users.surname,
	clients.province,
	clients.district,
	(SELECT COUNT(*) 
	FROM cart_has_paid 
	WHERE cart_has_paid.client_id = clients.client_id) 
	AS totalRequests,
	clients.active
	FROM clients
	INNER JOIN users ON users.user_id = clients.user_id
	WHERE clients.status = 1";

	$result = $connect->query($sql);

	$output = array('data' => array());
	if($result->num_rows > 0) {

		$active = ""; 

		while($row = $result->fetch_array()) {
			$clientId = $row['client_id'];
			$imageUrl = substr($row['user_image'], 3);
			$userImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:30px;'  />";
			$contact = $row['contact'];
			$name = $row['name']." ".$row['surname'];
			$province = $row['province'];
			$district = $row['district'];
			$totalResquests = $row['totalRequests'];

			// active 
			if($row['active'] == 1) {
				$active = "<label class='badge badge-success'>".$language['active']."</label>";
			} else {
				$active = "<label class='badge badge-danger'>".$language['inactive']."</label>";
			}
			
			$button = '<!-- Single button -->
			<div class="btn-group">
			<a href="clients.php?c=detail&i='.$clientId.'" class="btn btn-outline-success btn-sm" id="clientDetailsBtn"> <i class="fas fa-eye"></i></a>
			<button class="btn btn-outline-primary btn-sm" data-toggle="modal" id="viewAddressesModalBtn" data-target="#viewAddressesModal" onclick="viewAddresses('.$clientId.')"> <i class="fas fa-map-marker-alt"></i></button>
	      	<button class="btn btn-outline-dark btn-sm" data-toggle="modal" id="viewRequestsModalBtn" data-target="#viewRequestsModal" onclick="viewRequests('.$clientId.')"> <i class="fas fa-cart-plus"></i></button>
			</div>';

			$output['data'][] = array(
				$userImage, 
				$contact,		
				$name,
				$province,
				$district,
				$totalResquests,
				$active,
				$button 		
			); 	
	 	} // /while 
	}// if num_rows

	$connect->close();

	echo json_encode($output);
}

function clientsCounter() {
	global $connect;

	$sql = "SELECT  count(*) AS totalClients,
	(SELECT count(*) FROM clients WHERE status = 1 AND active = 1) AS totalClientsActive
	FROM clients
	WHERE status = 1";

	$result = $connect->query($sql);

	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
	} // if num_rows
	$connect->close();

	echo json_encode($row);
}

function fetchSelectedClient() {

}
?>