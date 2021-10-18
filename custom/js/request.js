var manageRequestTable;
var requestedItemTable;

$(document).ready(function() {

	var divRequest = $(".div-request").text();

	// nav bar 
	$("#navRequest").addClass('active');

	manageRequestTable = $('#manageRequestTable').DataTable({
		'ajax' : 'php_action/ctrl_request.php?action=read',
		'request': []
	}); // manage request Data Table
	
	var cartHasPaidId = $("#cartHasPaidId").val();
	// manage request item data table
	requestedItemTable = $('#requestedItemTable').DataTable({
		"ajax": {
			"url": 'php_action/ctrl_request.php?action=readItems',
			"data":{
				"cartHasPaidId": cartHasPaidId
			}
		}
	});
});
