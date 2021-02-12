<?php require_once 'includes/header.php'; ?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
	    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Product</li>
	    <li class="breadcrumb-item active" aria-current="page">
	    	<?php if($_GET['p'] == 'manprod') { ?>
				Manage
			<?php } else if($_GET['p'] == 'detail') { ?>
				Details
			<?php } // /else manage ?>
		</li>
  	</ol>
</div>


<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Produto</h1>
	<?php if($_GET['p'] == 'manprod') { // gerir produto ?>
		<button class="btn btn-primary btn-sm" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="fas fa-plus"></i> Adicionar produto </button>
	<?php } else if($_GET['p'] == 'detail') { // adicionar detalhes ?>
		<a href="produto.php?p=manprod" class="btn btn-primary btn-sm"> <i class="fas fa-cogs"></i> Gerir produtos </a>
	<?php } ?>
	
</div>

<?php if($_GET['p'] == 'manprod') { // gerir produto ?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-white">
					<h6 class="m-0 font-weight-bold text-muted">Gerir Produtos</h6>
				</div>

				<div class="card-body ">
					<div class="remove-messages"></div>

					<div class="table-responsive table-responsive-sm table-hover">
						<table class="table " id="manageProductTable">
							<thead>
								<tr>
									<th style="width:10%;">Photo</th>							
									<th>Product Name</th>
									<th>Rate</th>							
									<th>Quantity</th>
									<th>Brand</th>
									<th>Category</th>
									<th>Status</th>
									<th style="width:10%;">Options</th>
								</tr>
							</thead>
						</table>
					</div>
				</div> 
			</div>
		</div> <!-- /col-md-12 -->
	</div> <!-- /row -->
<?php } else if($_GET['p'] == 'detail') { // adicionar detalhes
	// add product details
	require_once 'product_details.php';
} ?>


<!-- add product -->
<div class="modal fade " id="addProductModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

			<div class="modal-header bg-white">
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">
				<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">

					<div id="add-product-messages"></div>

					<div class="form-group">
						<label for="productImage" class="col-sm-4 control-label">Product Image: </label>
						<div class="col-sm-8">
							<!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							<div class="kv-avatar center-block">					        
								<input type="file" class="form-control" id="productImage" placeholder="Product Name" name="productImage" class="file-loading" style="width:auto;"/>
							</div>
							
						</div>
					</div> <!-- /form-group-->	     	           	       

					<div class="form-group">
						<label for="productName" class="col-sm-4 control-label">Product Name: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="quantity" class="col-sm-4 control-label">Quantity: </label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	        	 

					<div class="form-group">
						<label for="rate" class="col-sm-4 control-label">Rate: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="rate" placeholder="Rate" name="rate" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	     	        

					<div class="form-group">
						<label for="brandName" class="col-sm-4 control-label">Brand Name: </label>
						<div class="col-sm-8">
							<select class="form-control js-select2 js-example-placeholder-single" id="brandName" name="brandName">
								<option value="">~~SELECT~~</option>
								<?php 
								$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
								?>
							</select>
						</div>
					</div> <!-- /form-group-->	

					<div class="form-group">
						<label for="categoryName" class="col-sm-4 control-label">Category Name: </label>
						<div class="col-sm-8">
							<select type="text" class="form-control js-select2" id="categoryName" placeholder="Product Name" name="categoryName" >
								<option value="">~~SELECT~~</option>
								<?php 
								$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
								?>
							</select>
						</div>
					</div> <!-- /form-group-->					        	         	       

					<div class="form-group">
						<label for="productStatus" class="col-sm-4 control-label">Status: </label>
						<div class="col-sm-8">
							<select class="form-control" id="productStatus" name="productStatus">
								<option value="">~~SELECT~~</option>
								<option value="1">Available</option>
								<option value="2">Not Available</option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> Save Changes</button>
						</div>
					</div>	
				</form> <!-- /.form -->	 
		   	</div> <!-- /modal-body -->

		   	<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div> <!-- /modal-footer -->	

		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /add product -->

<!-- edit product -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only">Loading...</span>
				</div>

				<div class="div-result">

					<!-- Nav tabs -->
					<div class="form-group ">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#menuEdit1"> Foto</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menuEdit2"> Dados</a>
							</li>
						</ul>
					</div>

					<!-- Tab panes -->
					<div class="tab-content border border-top-0">
						<div id="menuEdit1" class="tab-pane active" >
							<form action="php_action/editProductImage.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

								<br />
								<div id="edit-productPhoto-messages"></div>

								<div class="form-group">
									<label for="editProductImage" class="col-sm-4 control-label">Product Image: </label>
									<div class="col-sm-8">							    				   
										<img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
									</div>
								</div> <!-- /form-group-->	     	           	       
								
								<div class="form-group">
									<label for="editProductImage" class="col-sm-4 control-label">Select Photo: </label>
									<div class="col-sm-8">
										<!-- the avatar markup -->
										<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
										<div class="kv-avatar center-block">					        
											<input type="file" class="form-control" id="editProductImage" placeholder="Product Name" name="editProductImage" class="file-loading" style="width:auto;"/>
										</div>
									</div>
								</div> <!-- /form-group-->	     	           	       
							</form> <!-- /form -->
						</div>
						<div id="menuEdit2" class="tab-pane fade" >
							<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">				    
								<div id="edit-product-messages"></div>
								<div class="form-group">
									<label for="editProductName" class="col-sm-4 control-label">Product Name: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editProductName" placeholder="Product Name" name="editProductName" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	    

								<div class="form-group">
									<label for="editQuantity" class="col-sm-4 control-label">Quantity: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editQuantity" placeholder="Quantity" name="editQuantity" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	        	 

								<div class="form-group">
									<label for="editRate" class="col-sm-4 control-label">Rate: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editRate" placeholder="Rate" name="editRate" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	     	        

								<div class="form-group">
									<label for="editBrandName" class="col-sm-4 control-label">Brand Name: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editBrandName" name="editBrandName">
											<option value="">~~SELECT~~</option>
											<?php 
											$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
										?>
										</select>
									</div>
								</div> <!-- /form-group-->	

								<div class="form-group">
									<label for="editCategoryName" class="col-sm-4 control-label">Category Name: </label>
									<div class="col-sm-8">
										<select type="text" class="form-control" id="editCategoryName" name="editCategoryName" >
											<option value="">~~SELECT~~</option>
											<?php 
											$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
											} // while
											
											?>
										</select>
									</div>
								</div> <!-- /form-group-->					        	         	       

								<div class="form-group">
									<label for="editProductStatus" class="col-sm-4 control-label">Status: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editProductStatus" name="editProductStatus">
											<option value="">~~SELECT~~</option>
											<option value="1">Available</option>
											<option value="2">Not Available</option>
										</select>
									</div>
								</div> <!-- /form-group-->	         	        

								<div class="editProductFooter m-3">
									<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> Save Changes</button>
								</div> 
							</form>				     
						</div>
					</div> <!-- /Tab panes -->
				</div> <!-- /div-result -->
			</div> <!-- /modal-body -->

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div>

		</div> <!-- /modal-content -->
	</div> <!-- /modal-dailog -->
</div> <!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> Remove Product</h4>
				<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div class="removeProductMessages"></div>

				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeProductFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeProductBtn" data-loading-text="Loading..."> <i class="fas fa-trash "></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

<script src="custom/js/product.js"></script>
<script src="custom/js/productDetails.js"></script>

<?php require_once 'includes/footer.php'; ?>