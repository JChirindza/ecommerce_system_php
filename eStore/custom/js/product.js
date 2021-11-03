$(document).ready(function(){

	var product_id = $('#product_id').val();

	// product filters
	filter_data();
	function filter_data(){
		$('.loading_area').html('<div id="loading" style="" ></div>');
		var action = 'fetch_data';
		var category_id = $('#category_id').val();
		var page = $('#page').val();
		var minimum_price = $('#hidden_minimum_price').val();
		var maximum_price = $('#hidden_maximum_price').val();
		var limit = $('#product_limit').val();
		var sort = $('#product_sort').val();
		var brand = get_filter('brand');

		$.ajax({
			url:"php_action/ctrl_product.php?action=readFilters",
			method:"POST",
			data:{action:action, category_id:category_id, page:page, minimum_price:minimum_price, maximum_price:maximum_price, limit:limit, sort:sort, brand:brand},
			success:function(data){
				$('.filter_data').html(data);
				$('#loading').remove();
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

	var min_price = Number($('#hidden_minimum_price').val());
	var max_price = Number($('#hidden_maximum_price').val());

	$('#price_range').slider({
		range:true,
		min:min_price,
		max:max_price,
		values:[min_price, max_price],
		step:0.5,
		stop:function(event, ui) {
			$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
			$('#hidden_minimum_price').val(ui.values[0]);
			$('#hidden_maximum_price').val(ui.values[1]);
			filter_data();
		}
	});


	// product details
	related_products();
	function related_products(){
		$('.loading_area').html('<div id="loading" style="" ></div>');

		$.ajax({
			url:"php_action/ctrl_product.php?action=readRelated",
			method:"POST",
			data:{product_id:product_id},
			success:function(data){
				$('.related_products').html(data);
				$('#loading').remove();
			}
		});
	}

	setProductDescription(product_id);
	function setProductDescription(product_id = null) {
		console.log(1234);
		if(product_id) {
			$.ajax({
				url : 'php_action/ctrl_product.php?action=readProductDescription', 
				type: 'post',
				data: {product_id: product_id},
				dataType: 'json',
				success:function(response) {	
					$('#product_description').val(response.product_description);
					console.log(1231);
				} // /success function
			});
		}
	}
});

