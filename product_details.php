
<?php 
$productId = $_GET['i'];

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
product.categories_id, product.quantity, product.rate, product.active, product.status, 
brands.brand_name, categories.categories_name FROM product 
INNER JOIN brands ON product.brand_id = brands.brand_id 
INNER JOIN categories ON product.categories_id = categories.categories_id  
WHERE product.status = 1 AND product.product_id = {$productId}";

$query = $connect->query($sql);
$prodResult = $query->fetch_assoc();
?>
<div class="row mb-3">
	<div class="col-12">
		<div class="card rounded-0">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold">Dados do produto </h6>
			</div>
			
			<div class="card-body ">
				<div class="form-group col-12">
					<div class="row ">
						<div class="col-sm-12 col-md-6 col-lg-6" style="display: flex; justify-content: center;"> 
							<img class="img-fluid" src="src/<?php echo $prodResult['product_image']; ?>" style="max-height: 200px;">
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6" style="display: flex; align-items: center;">
							<!-- <label class="strong bold font-weight-bold">Nome do produto:</label> -->
							<style type="text/css">
								.prodName {
									overflow: hidden;
									display: -webkit-box;
									-webkit-line-clamp: 3;
									-webkit-box-orient: vertical;
								}
							</style>

							<label class="prodName" data-toggle="tooltip" title="<?php echo $prodResult['product_name']; ?>"><?php echo $prodResult['product_name']; ?></label>
						</div>
					</div>
				</div>
				
				<div class="view-more m-0 p-0" id="view-more" data-toggle="tooltip" title="Ver mais" style="cursor: pointer;">
					<label class="text-muted p-0 m-0" style="cursor: pointer;"><i class="fas fa-angle-down"></i></label>
				</div>

				<!-- d-none -->
				<div class="product-info mb-3" id="product-info" style="display: none;"> 
					<div class="form-group row">
						<div class="form-group col-md-6 col-lg-6">
							<label for="quantity" class="col-12 control-label">Available Quantity: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="quantity" name="quantity" autocomplete="off" value="<?php echo $prodResult['quantity']; ?>">
							</div>
						</div> <!-- /form-group-->	        	 

						<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
							<label for="rate" class="col-12 control-label">Rate: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="rate" name="rate" autocomplete="off" value="<?php echo $prodResult['rate']; ?>">
							</div>
						</div> <!-- /form-group-->	     	        
					</div>
					
					<div class="form-group row">
						<div class="form-group col-md-6 col-lg-6">
							<label for="brand" class="col-12 control-label">Brand Name: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="brand" name="brand" autocomplete="off" value="<?php echo $prodResult['brand_name']; ?>">
							</div>
						</div> <!-- /form-group-->	

						<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
							<label for="category" class="col-12 control-label">Category Name: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="category" name="category" autocomplete="off" value="<?php echo $prodResult['categories_name']; ?>">
							</div>
						</div> <!-- /form-group-->
					</div>					        	         	       

					<div class="form-group pt-2 pt-md-0 pt-lg-0">
						<label for="status" class="col-12 control-label">Status: </label>
						<div class="form-group col-md-3 col-lg-3">
							
							<?php $active = $prodResult['active']; ?>

							<?php if ($active == 1) { ?>
								<input type="text" readonly class="form-control border-0 text-success font-weight-bold" id="status" name="status" autocomplete="off" value="Available">
							<?php } elseif ($active == 2) { ?>
								<input type="text" readonly class="form-control border-0 text-danger font-weight-bold" id="status" name="status" autocomplete="off" value="Not Available">
							<?php } ?>
						</div>
					</div> <!-- /form-group-->
					

					<div class="view-less m-0 p-0" id="view-less" data-toggle="tooltip" title="Ver menos" style="cursor: pointer;">
						<label class="text-muted p-0 m-0" style="cursor: pointer;"><i class="fas fa-angle-up"></i></label>
					</div>
				</div>

				<script type="text/javascript">
					var view_more = document.getElementById('view-more');
					var view_less = document.getElementById('view-less');
					var product_info = document.getElementById('product-info');
					
					view_more.onclick = function() {
						if (product_info.style.display === 'none') {
							view_more.style.display = 'none';
							product_info.style.display = 'block';
						}
					};

					view_less.onclick = function() {						
						if (product_info.style.display !== 'none') {
							product_info.style.display = 'none';
							view_more.style.display = 'block';
						}
					}
				</script>
				<button class="btn btn-primary btn-sm" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('<?php echo $prodResult['product_id']; ?>')"> <i class="fas fa-edit"></i>Alterar dados</button>

			</div> 
		</div>
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- Technical detail -->
<div class="row">
	<div class="col-12">
		<div class="card rounded-0">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold"> Detalhes tecnicos</h6>
			</div>
			
			<div class="card-body ">
				<button class="btn btn-primary btn-sm m-0" data-toggle="modal" id="addProductDetailsModalBtn" data-target="#addProductDetailModal"> <i class="fas fa-plus"></i> Adicionar detalhes </button>
				<hr>

				<div class="remove-messages"></div>

				<div class="table-responsive table-responsive-sm table-hover">
					<table class="table" id="manageProductDetailsTable">
						<thead>
							<tr>							
								<th width="5%">#</th>
								<th width="40%">Detalhe</th>
								<th width="40%">Descricao</th>
								<th width="10%">Estado</th>
								<th width="5%" class="text-center">Opcoes</th>
							</tr>
						</thead>
					</table>
				</div>
			</div> 
		</div>
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->



<!-- add product -->
<div class="modal fade " id="addProductDetailModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add Product Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">
				<form class="form-horizontal" id="submitProductDetailsForm" action="php_action/createProductDetails.php" method="POST" enctype="multipart/form-data">

					<div id="add-product-detail-messages"></div>

					<div class="form-group">
						<label for="productDetail" class="col-sm-4 control-label">Product Detail: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="productDetail" placeholder="Product Detail" name="productDetail" autocomplete="off">
						</div>
					</div> <!-- /form-group-->

					<div class="form-group">
						<label for="detailDescription" class="col-sm-4 control-label"> Detail description: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="detailDescription" placeholder="Detail description" name="detailDescription" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="productDetailStatus" class="col-sm-4 control-label">Status: </label>
						<div class="col-sm-8">
							<select class="form-control" id="productDetailStatus" name="productDetailStatus">
								<option value="">~~SELECT~~</option>
								<option value="1">Available</option>
								<option value="2">Not Available</option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="createProductDetailBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> Save Changes</button>
						</div>
					</div>	
					<input type="hidden" name="productId" id="productId" value="<?php echo $prodResult['product_id']; ?>">
				</form> <!-- /.form -->	 
			</div> <!-- /modal-body -->

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div> <!-- /modal-footer -->	

		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /add product -->

<!-- edit product detail -->
<div class="modal fade" id="editProductDetailModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product detail</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only">Loading...</span>
				</div>

				<div class="div-result">
					<form class="form-horizontal" id="editProductDetailForm" action="php_action/editProductDetail.php" method="POST">				    
						<div id="edit-product-messages"></div>
						<div class="form-group">
							<label for="editProductDetail" class="col-sm-4 control-label">Product Detail: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editProductDetail" placeholder="Product detail" name="editProductDetail" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	    

						<div class="form-group">
							<label for="editDetailDescription" class="col-sm-4 control-label"> Detail description: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editDetailDescription" placeholder="Product detail description" name="editDetailDescription" autocomplete="off">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="editDetailStatus" class="col-sm-4 control-label">Status: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editDetailStatus" name="editDetailStatus">
									<option value="">~~SELECT~~</option>
									<option value="1">Available</option>
									<option value="2">Not Available</option>
								</select>
							</div>
						</div> <!-- /form-group-->	         	        

						<div class="editProductDetailFooter m-3">
							<button type="submit" class="btn btn-success" id="editProductDetailBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> Save Changes</button>
						</div> 	
					</form>			     
				</div> <!-- /div-result -->
			</div> <!-- /modal-body -->

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div> <!-- /modal-footer -->

		</div> <!-- /modal-content -->
	</div> <!-- /modal-dailog -->
</div> <!-- /categories brand -->

<!-- remove produt detail -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductDetailModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> Remove Product</h4>
				<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div class="removeProductDetailMessages"></div>

				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeProductDetailFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeProductDetailBtn" data-loading-text="Loading..."> <i class="fas fa-trash "></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /produt detail -->