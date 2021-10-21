var manageClientsTable;

$(document).ready(function() {

	// Load client counter
	setClientCounter();

	// top nav bar 
	$('#navClient').addClass('active');
	// manage product data table
	manageClientsTable = $('#manageClientsTable').DataTable({
		'ajax': 'php_action/ctrl_client.php?action=read',
		'client': []
	});
}); // document.ready fucntion


function setClientCounter() {
	console.log(123);
	$.ajax({
		url : 'php_action/ctrl_client.php?action=readCounters', 
		type: 'post',
		dataType: 'json',
		success:function(response) {	
			$('#totalClients').text(response.totalClients);
			$('#totalClientsActive').text(response.totalClientsActive);
		} // /success function
	});
}