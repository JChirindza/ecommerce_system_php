
<?php 
$productId = Sys_Secure($_GET['i']);
?>
<div class="row mb-3">
	<div class="col-12">
		<div class="card rounded-0">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold"><?php echo $language['product-information'] ?> </h6>
			</div>
			
			<div class="card-body ">
				<div class="form-group col-12">
					<div class="row ">
						<div class="col-sm-12 col-md-6 col-lg-6" style="display: flex; justify-content: center;"> 
							<img class="img-fluid" id="product_img" style="max-height: 200px;">
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6" style="display: flex; align-items: center;">
							<style type="text/css">
								.prodName {
									overflow: hidden;
									display: -webkit-box;
									-webkit-line-clamp: 3;
									-webkit-box-orient: vertical;
								}
							</style>

							<label class="prodName" id="product_name" data-toggle="tooltip"></label>
						</div>
					</div>
				</div>
				
				<div class="view-more m-0 p-0" id="view-more" data-toggle="tooltip" title="<?php echo $language['view-more'] ?>" style="cursor: pointer;">
					<label class="text-muted p-0 m-0" style="cursor: pointer;"><i class="fas fa-angle-down"></i></label>
				</div>

				<!-- d-none -->
				<div class="product-info mb-3" id="product-info" style="display: none;"> 
					<div class="form-group row">
						<div class="form-group col-md-6 col-lg-6">
							<label for="quantity" class="col-12 control-label"><?php echo $language['available-quantity'] ?>: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="product_quantity" name="quantity" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	        	 

						<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
							<label for="rate" class="col-12 control-label"><?php echo $language['price'] ?>: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="product_rate" name="rate" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	     	        
					</div>
					
					<div class="form-group row">
						<div class="form-group col-md-6 col-lg-6">
							<label for="brand" class="col-12 control-label"><?php echo $language['brand-name'] ?>: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="product_brand" name="brand" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	

						<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
							<label for="category" class="col-12 control-label"><?php echo $language['categ-name'] ?>: </label>
							<div class="col-12">
								<input type="text" readonly class="form-control border-0" id="product_category" name="category" autocomplete="off">
							</div>
						</div> <!-- /form-group-->
					</div>	

					<div class="form-group row">
						<div class="form-group col-md-6 col-lg-6">
							<label for="quantity" class="col-12 control-label"><?php echo $language['description'] ?>: </label>
							<div class="col-12">
								<textarea readonly class="form-control border-0" rows="7" id="product_description" name="product_description"></textarea>
							</div>
						</div> <!-- /form-group-->	

						<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
							<label for="status" class="col-12 control-label"><?php echo $language['status'] ?>: </label>

							<!-- product active input -->
							<div class="form-group col-md-4 col-lg-6 product_activ"></div>
						</div> <!-- /form-group-->
					</div>					        	         	       

					<div class="view-less m-0 p-0" id="view-less" data-toggle="tooltip" title="<?php echo $language['view-less']; ?>" style="cursor: pointer;">
						<label class="text-muted p-0 m-0" style="cursor: pointer;"><i class="fas fa-angle-up"></i></label>
					</div>
				</div>

				<input type="hidden" name="product_id" id="product_id" value="<?php echo $productId; ?>">

				
				<button class="btn btn-primary btn-sm" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('<?php echo $productId; ?>')"> <i class="fas fa-edit"></i><?php echo $language['edit-product'] ?></button>

			</div> 
		</div>
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- Technical detail -->
<div class="row">
	<div class="col-12">
		<div class="card rounded-0">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold"> <?php echo $language['technical-details'] ?></h6>
			</div>
			
			<div class="card-body ">
				<button class="btn btn-primary btn-sm m-0" data-toggle="modal" id="addProductDetailsModalBtn" data-target="#addProductDetailModal"> <i class="fas fa-plus"></i> <?php echo $language['add-details'] ?> </button>
				<hr>

				<div class="remove-messages"></div>

				<div class="table-responsive table-responsive-sm table-hover">
					<table class="table" id="manageProductDetailsTable">
						<thead>
							<tr>							
								<th width="5%">#</th>
								<th width="40%"><?php echo $language['detail'] ?></th>
								<th width="40%"><?php echo $language['description'] ?></th>
								<th width="10%"><?php echo $language['status'] ?></th>
								<th width="5%" class="text-center"><?php echo $language['options'] ?></th>
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
				<h4 class="modal-title"><i class="fa fa-plus"></i> <?php echo $language['add-product-details'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">
				<form class="form-horizontal" id="submitProductDetailsForm" action="php_action/ctrl_productDetail.php?action=create" method="POST" enctype="multipart/form-data">

					<div id="add-product-detail-messages"></div>

					<div class="form-group">
						<label for="productDetail" class="col-sm-4 control-label"><?php echo $language['prod-details'] ?>: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="productDetail" placeholder="<?php echo $language['prod-details'] ?>" name="productDetail" autocomplete="off">
						</div>
					</div> <!-- /form-group-->

					<div class="form-group">
						<label for="detailDescription" class="col-sm-4 control-label"> <?php echo $language['detail-description'] ?>: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="detailDescription" placeholder="<?php echo $language['detail-description'] ?>" name="detailDescription" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="productDetailStatus" class="col-sm-4 control-label">Status: </label>
						<div class="col-sm-8">
							<select class="form-control" id="productDetailStatus" name="productDetailStatus">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1"><?php echo $language['available'] ?></option>
								<option value="2"><?php echo $language['not-available'] ?></option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="createProductDetailBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
						</div>
					</div>	
					<input type="hidden" name="productId" id="productId" value="<?php echo $productId; ?>">
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
				<h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $language['edit-product-details'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only"><?php echo $language['loading'] ?>...</span>
				</div>

				<div class="div-result">
					<form class="form-horizontal" id="editProductDetailForm" action="php_action/ctrl_productDetail.php?action=update" method="POST">				    
						<div id="edit-product-detail-messages"></div>
						<div class="form-group">
							<label for="editProductDetail" class="col-sm-4 control-label"><?php echo $language['product-detail'] ?>: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editProductDetail" placeholder="<?php echo $language['product-detail'] ?>" name="editProductDetail" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	    

						<div class="form-group">
							<label for="editDetailDescription" class="col-sm-4 control-label"> <?php echo $language['detail-description'] ?>: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editDetailDescription" placeholder="<?php echo $language['detail-description'] ?>" name="editDetailDescription" autocomplete="off">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="editDetailStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editDetailStatus" name="editDetailStatus">
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1"><?php echo $language['available'] ?></option>
									<option value="2"><?php echo $language['not-available'] ?></option>
								</select>
							</div>
						</div> <!-- /form-group-->	         	        

						<div class="editProductDetailFooter m-3">
							<button type="submit" class="btn btn-success" id="editProductDetailBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
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
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-product-detail'] ?></h4>
				<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div class="removeProductDetailMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeProductDetailFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeProductDetailBtn" data-loading-text="Loading..."> <i class="fas fa-trash "></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /produt detail -->

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