<?php require_once 'includes/header.php'; ?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
		<li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
		<li class="breadcrumb-item active"><?php echo $language['products'] ?></li>
		<li class="breadcrumb-item active" aria-current="page">
			<?php if($_GET['p'] == 'manprod') {
				echo $language['manage']; 
			} else if($_GET['p'] == 'detail') {
				echo $language['details']; 
			} // /else manage ?>
		</li>
	</ol>
</div>


<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['products'] ?></h1>
	<?php if($_GET['p'] == 'manprod') { // gerir produto ?>
		<button class="btn btn-primary btn-sm" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="fas fa-plus"></i> <?php echo $language['add-product'] ?> </button>
	<?php } else if($_GET['p'] == 'detail') { // adicionar detalhes ?>
		<a href="products.php?p=manprod" class="btn btn-primary btn-sm"> <i class="fas fa-cogs"></i> <?php echo $language['manage-products'] ?> </a>
	<?php } ?>
	
</div>

<?php if($_GET['p'] == 'manprod') { // gerir produto ?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-white">
					<h6 class="m-0 font-weight-bold text-muted"><?php echo $language['manage-products'] ?></h6>
				</div>

				<div class="card-body ">
					<div class="remove-messages"></div>

					<div class="table-responsive table-responsive-sm table-hover">
						<table class="table " id="manageProductTable">
							<thead>
								<tr>
									<th style="width:10%;"><?php echo $language['photo'] ?></th>							
									<th><?php echo $language['product-name'] ?></th>
									<th><?php echo $language['price'] ?></th>							
									<th><?php echo $language['quantity'] ?></th>
									<th><?php echo $language['brand'] ?></th>
									<th><?php echo $language['category'] ?></th>
									<th><?php echo $language['status'] ?></th>
									<th style="width:10%;"><?php echo $language['options'] ?></th>
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
				<h4 class="modal-title"><i class="fa fa-plus"></i> <?php echo $language['add-product'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">
				<form class="form-horizontal" id="submitProductForm" action="php_action/ctrl_product.php?action=create" method="POST" enctype="multipart/form-data">

					<div id="add-product-messages"></div>

					<div class="form-group">
						<label for="productImage" class="col-sm-4 control-label"><?php echo $language['product-image'] ?>: </label>
						<div class="col-sm-8">
							<!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							<div class="kv-avatar center-block">					        
								<input type="file" class="form-control" id="productImage" placeholder="<?php echo $language['product-name'] ?>" name="productImage" class="file-loading" style="width:auto;"/>
							</div>
							
						</div>
					</div> <!-- /form-group-->	     	           	       

					<div class="form-group">
						<label for="productName" class="col-sm-4 control-label"><?php echo $language['product-name'] ?>: * </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="productName" placeholder="<?php echo $language['product-name'] ?>" name="productName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="quantity" class="col-sm-4 control-label"><?php echo $language['quantity'] ?>: *</label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="quantity" placeholder="<?php echo $language['quantity'] ?>" name="quantity" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	        	 

					<div class="form-group">
						<label for="rate" class="col-sm-4 control-label"><?php echo $language['price'] ?>: *</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="rate" placeholder="<?php echo $language['price'] ?>" name="rate" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	     	        

					<div class="form-group">
						<label for="brandName" class="col-sm-4 control-label"><?php echo $language['brand-name'] ?>: *</label>
						<div class="col-sm-8">
							<select class="form-control js-select2" style="width: 100%;" id="brandName" name="brandName">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
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
						<label for="categoryName" class="col-sm-4 control-label"><?php echo $language['categ-name'] ?>: *</label>
						<div class="col-sm-8">
							<select type="text" class="form-control js-select2" style="width: 100%;" id="categoryName" placeholder="<?php echo $language['product-name'] ?>" name="categoryName" >
								<option value="">~~<?php echo $language['select'] ?>~~</option>
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
						<label for="productStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: *</label>
						<div class="col-sm-8">
							<select class="form-control" id="productStatus" name="productStatus">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1"><?php echo $language['available'] ?></option>
								<option value="2"><?php echo $language['not-available'] ?></option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
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
				<h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $language['edit-product'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only"><?php echo $language['loading'] ?>...</span>
				</div>

				<div class="div-result">

					<!-- Nav tabs -->
					<div class="form-group ">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#menuEdit1"> <?php echo $language['photo'] ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menuEdit2"> <?php echo $language['information'] ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menuEdit3"> <?php echo $language['description'] ?></a>
							</li>
						</ul>
					</div>

					<!-- Tab panes -->
					<div class="tab-content border border-top-0">
						<div id="menuEdit1" class="tab-pane active" >
							<form action="php_action/ctrl_product.php?action=updateImage" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

								<br />
								<div id="edit-productPhoto-messages"></div>

								<div class="form-group">
									<label for="editProductImage" class="col-sm-4 control-label"><?php echo $language['product-image'] ?>: </label>
									<div class="col-sm-8">							    				   
										<img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
									</div>
								</div> <!-- /form-group-->	     	           	       
								
								<div class="form-group editProductPhotoFooter">
									<label for="editProductImage" class="col-sm-4 control-label"><?php echo $language['select-photo'] ?>: </label>
									<div class="col-sm-8">
										<!-- the avatar markup -->
										<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
										<div class="kv-avatar center-block">					        
											<input type="file" class="form-control" id="editProductImage" placeholder="<?php echo $language['product-name'] ?>" name="editProductImage" class="file-loading" style="width:auto;"/>
										</div>
									</div>
									
								</div> <!-- /form-group-->
								<div class="editProductPhotoFooter">
									
								</div>	     	           	       
							</form> <!-- /form -->
						</div>
						<div id="menuEdit2" class="tab-pane fade" >
							<form class="form-horizontal" id="editProductForm" action="php_action/ctrl_product.php?action=update" method="POST">				    
								<div id="edit-product-messages"></div>
								<div class="form-group">
									<label for="editProductName" class="col-sm-4 control-label"><?php echo $language['product-name'] ?>: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editProductName" placeholder="<?php echo $language['product-name'] ?>" name="editProductName" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	    

								<div class="form-group">
									<label for="editQuantity" class="col-sm-4 control-label"><?php echo $language['quantity'] ?>: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editQuantity" placeholder="<?php echo $language['quantity'] ?>" name="editQuantity" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	        	 

								<div class="form-group">
									<label for="editRate" class="col-sm-4 control-label"><?php echo $language['price'] ?>: </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="editRate" placeholder="<?php echo $language['price'] ?>" name="editRate" autocomplete="off">
									</div>
								</div> <!-- /form-group-->	     	        

								<div class="form-group">
									<label for="editBrandName" class="col-sm-4 control-label"><?php echo $language['brand-name'] ?>: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editBrandName" style="width: 100%;" name="editBrandName">
											<option value="">~~<?php echo $language['select'] ?>~~</option>
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
								<label for="editCategoryName" class="col-sm-4 control-label"><?php echo $language['categ-name'] ?>: </label>
								<div class="col-sm-8">
									<select type="text" class="form-control" style="width: 100%;" id="editCategoryName" name="editCategoryName" >
										<option value="">~~<?php echo $language['select'] ?>~~</option>
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
									<label for="editProductStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
									<div class="col-sm-8">
										<select class="form-control" id="editProductStatus" name="editProductStatus">
											<option value="">~~<?php echo $language['select'] ?>~~</option>
											<option value="1"><?php echo $language['available'] ?></option>
											<option value="2"><?php echo $language['not-available'] ?></option>
										</select>
									</div>
								</div> <!-- /form-group-->	         	        

								<div class="editProductFooter m-3">
									<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
								</div> 
							</form>				     
						</div>

						<div id="menuEdit3" class="tab-pane fade" >
							<form class="form-horizontal" id="editProductDescriptionForm" action="php_action/ctrl_product.php?action=updateDescription" method="POST">				    
								
								<div id="edit-product-description-messages"></div>
								
								<div class="form-group">
									<label for="editProductDescription" class="col-sm-4 control-label"><?php echo $language['product-description'] ?>: </label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="7" id="editProductDescription" placeholder="<?php echo $language['product-description'] ?>" name="editProductDescription" autocomplete="off"></textarea>
									</div>
								</div> <!-- /form-group-->	 

								<div class="editProductDescriptionFooter m-3">
									<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
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
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-product'] ?></h4>
				<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div class="removeProductMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeProductFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeProductBtn" data-loading-text="Loading..."> <i class="fas fa-trash "></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

<script src="custom/js/product.js"></script>
<script src="custom/js/productDetails.js"></script>

<?php require_once 'includes/footer.php'; ?>