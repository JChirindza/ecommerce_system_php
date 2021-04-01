var manageCartsTable;

$(document).ready(function() {

	manageCartsTable = $("#manageCartsListTable").DataTable({
		'ajax': 'php_action/fetchCarts.php',
		'cart': []
	});

}); // /documernt

