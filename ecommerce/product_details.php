<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-4">

		<div class="row mt-2">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-list"></i> Detalhes do Produto </h4>

				<!-- Product Details -->
				<?php require_once 'php_action/fetchProductDetails.php'; ?>
			</div>
		</div>
		<style type="text/css">
			table .name{
				font-weight: bolder;
			}
		</style>
		<div class="row mt-4">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-info-circle"></i> Detalhes técnicos </h4>
				<div class="table-responsive">
					<table class="col-md-6 table" id="productDetailsTable">
						<thead class="bg-light border">
							<tr>							
								<th width="5%">#</th>
								<th width="45%" class="text-center">Detalhe</th>
								<th class="text-center">Description</th>
							</tr>
						</thead>
						<tbody class="border">
							<?php
							$x = 1;
							$product_id = $_GET['product_id'];
							$sql = "SELECT pd.id, pd.name, pd.description FROM product as p, product_details as pd WHERE pd.product_id = {$product_id} and p.product_id = {$product_id}";
							$resultado = mysqli_query($connect, $sql);
							if (mysqli_num_rows($resultado) > 0):
								while ($dados = mysqli_fetch_array($resultado)):
									?>
									<tr>
										<td class="bg-light text-muted border"><?php echo $x ?></td>
										<td class="name bg-light"><?php echo $dados['name'];?></td>
										<td><?php echo $dados['description'];?></td>
									</tr>

									<?php 
									$x++;
								endwhile; 
							else:
								?>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
								<!-- fim do IF -->
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-network-wired"></i> Produtos Relacionados </h4>

				<!-- Produtos Relacionados -->
				<div class="row filter_hardware"></div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-network-wired"></i> Compare com Semelhantes </h4>

				<!-- Compare with Similar -->
				<div class="row filter_hardware"></div>
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	var productDetailsTable;

	$(document).ready(function() {
	// top bar active
	$('#navBrand').addClass('active');
	
	// manage brand table
	productDetailsTable = $("#productDetailsTable").DataTable({
		'ajax': 'php_action/fetchProductTechnicalDetails.php',
		'order': []		
	});
</script>
<?php require_once 'includes/footer.php'; ?>