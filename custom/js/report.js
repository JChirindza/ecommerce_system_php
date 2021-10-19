$(document).ready(function() {
	// order date picker
	$("#startDate").datepicker();
	// order date picker
	$("#endDate").datepicker();
});

// print report function
function printReport() {

	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();	

	if(startDate == "" || endDate == "") {
		if(startDate == "") {
			$("#startDate").closest('.form-group').addClass('has-error');
			$("#startDate").after('<p class="text-danger">The Start Date is required</p>');
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
		}

		if(endDate == "") {
			$("#endDate").closest('.form-group').addClass('has-error');
			$("#endDate").after('<p class="text-danger">The End Date is required</p>');
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
		}
	} else {

		$(".form-group").removeClass('has-error');
		$(".text-danger").remove();

		$.ajax({
			url: 'php_action/ctrl_report.php?action=genOrderReport',
			type: 'post',
			data: {startDate: startDate, endDate: endDate},
			dataType: 'text',
			success:function(response) {

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
	} // /else
} // /print function