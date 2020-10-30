

// Simple select and multiple Selection
$(document).ready(function() {
	$(".js-select2-multi").select2();
	$('.js-select2').each(function() { // To fix modal problem
		$(this).select2({ dropdownParent: $(this).parent()});
	});
	$(".large").select2({
		dropdownCssClass: "big-drop",
	});

});


