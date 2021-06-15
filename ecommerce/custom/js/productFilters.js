$(document).ready(function(){

	filter_data();

	function filter_data(){
		$('.filter_data').html('<div id="loading" style="" ></div>');
		var action = 'fetch_data';
		var category_id = $('#category_id').val();
		var minimum_price = $('#hidden_minimum_price').val();
		var maximum_price = $('#hidden_maximum_price').val();
		var limit = $('#product_limit').val();
		var sort = $('#product_sort').val();
		var brand = get_filter('brand');

		$.ajax({
			url:"php_action/ctrl_product.php?action=readFilters",
			method:"POST",
			data:{action:action, category_id:category_id, minimum_price:minimum_price, maximum_price:maximum_price, limit:limit, sort:sort, brand:brand},
			success:function(data){
				$('.filter_data').html(data);
			}
		});
	}

	function get_filter(class_name){
		var filter = [];
		$('.'+class_name+':checked').each(function(){
			filter.push($(this).val());
		});
		return filter;
	}

	$('#product_limit').on('change', function(){
		filter_data();
	});

	$('#product_sort').on('change', function(){
		filter_data();
	});		

	$('.common_selector').click(function(){
		filter_data();
	});

	$('#price_range').slider({
		range:true,
		min:<?php echo $minPrice; ?>,
		max:<?php echo $maxPrice; ?>,
		values:[<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>],
		step:0.5,
		stop:function(event, ui) {
			$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
			$('#hidden_minimum_price').val(ui.values[0]);
			$('#hidden_maximum_price').val(ui.values[1]);
			filter_data();
		}
	});

});