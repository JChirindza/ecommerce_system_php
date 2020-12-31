<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-4">
		<div class="row">
			<div class="col-md-12 col-md-offset-1">
				<div class="process-wrap">
					<div class="process text-center active">
						<p><span>01</span></p>
						<h4>Carrinho de compras</h4>
					</div>
					<div class="process text-center">
						<p><span>02</span></p>
						<h4> Pagamento </h4>
					</div>
					<div class="process text-center">
						<p><span>03</span></p>
						<h4>Finalizado</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm border p-4 bg-white">
				<h4><i class="fas fa-list"></i> Carrinho de Compras </h4>
				<div class="table-responsive pt-2 ">
					<table class="table border" id="productTable">
						<thead>
							<tr>			  			
								<th style="width:40%;">Product</th>
								<th style="width:15%;">Rate</th>
								<th style="width:10%;">Available</th>			  			
								<th style="width:10%;">Quantity</th>			  			
								<th style="width:15%;">Total</th>			  			
								<th style="width:5%;">Remove</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		filter_computers();

		function filter_computers()
		{
			$('.filter_computers').html('<div id="loading" style="" ></div>');
			var action = 'filter_computers';
			var minimum_price = $('#hidden_minimum_price').val();
			var maximum_price = $('#hidden_maximum_price').val();
			var brand = get_filter('brand');
			
			$.ajax({
				url:"php_action/fetch_data.php",
				method:"POST",
				data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
				success:function(data){
					$('.filter_computers').html(data);
				}
			});
		}

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			return filter;
		}

		$('.common_selector').click(function(){
			filter_data();
		});

		$('#price_range').slider({
			range:true,
			min:1000,
			max:165000,
			values:[1000, 165000],
			step:500,
			stop:function(event, ui)
			{
				$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
				$('#hidden_minimum_price').val(ui.values[0]);
				$('#hidden_maximum_price').val(ui.values[1]);
				filter_data();
			}
		});

	});
</script>



<?php require_once 'includes/footer.php'; ?>