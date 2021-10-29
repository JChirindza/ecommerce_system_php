$(document).ready(function() {
	// order date picker
	$("#startDate").datepicker();
	// order date picker
	$("#endDate").datepicker();
});

// print report function
function printReport() {

	// remove the error text
	$(".text-danger").remove();
	// remove the form error
	$('.form-group').removeClass('has-error').removeClass('has-success');

	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();

	if(startDate == "") {
		$("#startDate").after('<p class="text-danger">The start date field is required</p>');
		$('#startDate').closest('.form-group').addClass('has-error');
	} else {
		// remov error text field
		$("#startDate").find('.text-danger').remove();
		// success out for form 
		$("#startDate").closest('.form-group').addClass('has-success');	  	
	}

	if(endDate == "") {
		$("#endDate").after('<p class="text-danger">The end date field is required</p>');
		$('#endDate').closest('.form-group').addClass('has-error');
	} else {
		// remov error text field
		$("#endDate").find('.text-danger').remove();
		// success out for form 
		$("#endDate").closest('.form-group').addClass('has-success');	  	
	}

	if(startDate && endDate) {

		$.ajax({
			url: 'php_action/ctrl_report.php?action=genOrderReport',
			type: 'post',
			data: {startDate: startDate, endDate: endDate},
			dataType: 'text',
			success:function(response) {

				// remove the error text
				$(".text-danger").remove();
				// remove the form error
				$('.form-group').removeClass('has-error').removeClass('has-success');

				var mywindow = window.open('', 'ComputersOnly - Sales & Management System', 'height=400,width=600');
				mywindow.document.write('<html><head><title>Order Report Slip</title>');        
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
		}); // /ajax function to fetch the printable report
	} // /if
} // /print function