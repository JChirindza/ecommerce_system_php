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

function confirm_request(cartHasPaidId = null) {

	if(cartHasPaidId) {

		// button loading
		$("#confirmRequestBtn").button('loading');

		$.ajax({
			url: 'php_action/ctrl_request.php?action=confirm',
			type: 'post',
			data: {cartHasPaidId : cartHasPaidId},
			dataType: 'json',
			success:function(response) {
				// button loading
				$("#confirmRequestBtn").button('reset');

				$("html, body, div.card, div.card-body").animate({scrollTop: '210px'}, 100);

				if(response.success == true) {
					$(".success-messages").html('<div class="alert alert-success p-2">'+
					'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
					'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
					'<a type="button" onclick="printRequest('+response.cartHasPaidId+')" class="btn btn-primary btn-sm ml-4 mr-2"> <i class="fas fa-print"></i> Print </a>'+
					'</div>');
				} else {
					$('.success-messages').html('<div class="alert alert-warning p-2">'+
						'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						'<strong><i class="fas fa-save"></i></strong> '+ response.messages +
						'</div>');
				} // /else

				$(".alert-warning").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				}); // /.alert
			} // /response messages
		}); // /ajax function
	}
}

// print request function
function printRequest(cartHasPaidId = null) {

	if(cartHasPaidId) {

		$.ajax({
			url: 'php_action/ctrl_request.php?action=printRequest',
			type: 'post',
			data: {cartHasPaidId: cartHasPaidId},
			dataType: 'text',
			success:function(response) {
				var mywindow = window.open('', 'ComputersOnly - Sales & Management System', 'height=400,width=600');
				mywindow.document.write('<html><head><title>Order Request Slip</title>');        
				mywindow.document.write('</head><body>');
				mywindow.document.write(response);
				mywindow.document.write('</body></html>');

		        mywindow.document.close(); // necessary for IE >= 10
		        mywindow.focus(); // necessary for IE >= 10
		        mywindow.resizeTo(screen.width, screen.height);
		        setTimeout(function() {
		        	mywindow.print();
		        	mywindow.close();
		        }, 1250);
			}// /success function
		}); // /ajax function to fetch the printable request
	} // /else
} // /print function