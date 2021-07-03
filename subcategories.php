
<?php 
$categoryId = $_GET['i'];

$sql = "SELECT categories_id, categories_name, categories_active FROM categories WHERE categories_status = 1 AND categories_id = {$categoryId}";
$query = $connect->query($sql);
$categoryResult = $query->fetch_assoc();
?>
<div class="row mb-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold"><?php echo $language['category-details'] ?> </h6>
			</div>
			
			<div class="card-body ">
				<div class="form-group row">
					<div class="form-group col-md-6 col-lg-6">
						<label for="quantity" class="col-12 control-label"><?php echo $language['categ-name'] ?>: </label>
						<div class="col-12">
							<input type="text" readonly class="form-control border-0" id="quantity" name="quantity" autocomplete="off" value="<?php echo $categoryResult['categories_name']; ?>">
						</div>
					</div> <!-- /form-group-->	        	 

					<div class="form-group col-md-6 col-lg-6 pt-4 pt-md-0 pt-lg-0">
						<label for="rate" class="col-12 control-label"><?php echo $language['status'] ?>: </label>
						<div class="col-12">
							<?php $active = $categoryResult['categories_active']; ?>

							<?php if ($active == 1) { ?>
								<input type="text" readonly class="form-control border-0 text-success font-weight-bold" id="status" name="status" autocomplete="off" value="Available">
							<?php } elseif ($active == 2) { ?>
								<input type="text" readonly class="form-control border-0 text-danger font-weight-bold" id="status" name="status" autocomplete="off" value="Not Available">
							<?php } ?>
						</div>
					</div> <!-- /form-group-->	     	        
				</div>

				<div class="form-group row mb-0">
					<div class="form-group col-12">
						<label class="col-12 control-label mb-0"><?php echo $language['related-products'] ?>: </label>
						<hr class="mb-0">
						<div class="view-more m-0 p-0" id="view-more" data-toggle="tooltip" title="<?php echo $language['show-related-products'] ?>" style="cursor: pointer;">
							<label class="text-muted p-0 m-0" style="cursor: pointer;"><i class="fas fa-angle-down"></i></label>
						</div>

						<!-- d-none | related products -->
						<div class="product-info" id="product-info" style="display: none;"> 
							<div class="row ml-3">
								<?php

								$sql = "SELECT * FROM product WHERE active = '1' AND categories_id = {$categoryId} ORDER BY RAND() limit 4";
								$result = $connect->query($sql);

								$output = '';
								if($result->num_rows > 0) { 
									foreach($result as $row) {
										$brandID = $row['brand_id'];

										$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
										$query2 = $connect->query($sql2);
										$result2 = $query2->fetch_assoc();

										$output .= '
										<div class="col-auto col-lg-2 p-0 m-0 pr-5 pt-4">
										<a href="products.php?p=detail&i='. $row['product_id'] .'">
										<div class="product-entry">
										<div class="product-img">
										<img src="src/'. $row['product_image'] .'" class="img-fluid" style="height: 100px; " >
										</div>
										<div class="product-brand" style= "text-align: center;">Marca '. $result2['brand_name'] .' </div>

										<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
										</div>
										</a>
										</div>
										';
									}
								} else {
									$output = '<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
									<h5 class="p-5 text-muted">'.$language['no-data-found'].'</h5></div>';
								}
								echo $output;
								?>
							</div>

							<div class="view-less m-0 p-0" id="view-less" data-toggle="tooltip" title="<?php echo $language['hide-related-products'] ?>" style="cursor: pointer;">
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
					</div> <!-- /form-group-->	        	 
				</div>

				<button class="btn btn-primary btn-sm" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editCategories('<?php echo $categoryResult['categories_id']; ?>')"> <i class="fas fa-edit"></i><?php echo $language['change-data'] ?></button>
			</div> 
		</div>
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- Subcategories -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold"> <?php echo $language['subcategories'] ?> </h6>
			</div>
			
			<div class="card-body ">
				<button class="btn btn-primary btn-sm m-0" data-toggle="modal" id="addSubcategoryModalBtn" data-target="#addSubcategoryModal"> <i class="fas fa-plus"></i> <?php echo $language['add-subcategory'] ?> </button>
				<hr>
				<div class="remove-messages"></div>

				<div class="table-responsive table-responsive-sm table-hover">
					<table class="table" id="manageSubcategoriesTable">
						<thead>
							<tr>							
								<th width="5%">#</th>
								<th width="50%"><?php echo $language['subcateg-name'] ?></th>
								<th width="20%"><?php echo $language['status'] ?></th>
								<th width="10%"><?php echo $language['options'] ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div> 
		</div>
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- add sub_category -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-plus"></i> <?php echo $language['add-subcategory'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">
				<form class="form-horizontal" id="submitSubcategoryForm" action="php_action/ctrl_subcategory.php?action=create" method="POST" enctype="multipart/form-data">

					<div id="add-subcategory-messages"></div>

					<div class="form-group">
						<label for="subcategoryName" class="col-sm-4 control-label"> <?php echo $language['subcateg-name'] ?>: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="subcategoryName" placeholder="<?php echo $language['subcateg-name'] ?>" name="subcategoryName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	    

					<div class="form-group">
						<label for="subcategoryStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
						<div class="col-sm-8">
							<select class="form-control" id="subcategoryStatus" name="subcategoryStatus">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1"><?php echo $language['available'] ?></option>
								<option value="2"><?php echo $language['not-available'] ?></option>
							</select>
						</div>
					</div> <!-- /form-group-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success" id="createSubcategoryBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
						</div>
					</div>	
					<input type="hidden" name="categoryId" id="categoryId" value="<?php echo $categoryResult['categories_id']; ?>">
				</form> <!-- /.form -->	 
			</div> <!-- /modal-body -->

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div> <!-- /modal-footer -->	

		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /add product -->

<!-- edit Subcategory -->
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $language['edit-subcategory'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div class="div-loading">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only"><?php echo $language['loading'] ?>...</span>
				</div>

				<div class="div-result">
					<form class="form-horizontal" id="editSubcategoryForm" action="php_action/ctrl_subcategory.php?action=update" method="POST">				    
						<div id="edit-subcategory-messages"></div>
						<div class="form-group">
							<label for="editSubcategoryName" class="col-sm-4 control-label"><?php echo $language['subcateg-name'] ?>: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editSubcategoryName" placeholder="<?php echo $language['subcateg-name'] ?>" name="editSubcategoryName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group">
							<label for="editSubcategoryStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editSubcategoryStatus" name="editSubcategoryStatus">
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1"><?php echo $language['available'] ?></option>
									<option value="2"><?php echo $language['not-available'] ?></option>
								</select>
							</div>
						</div> <!-- /form-group-->	         	        

						<div class="editSubcategoryFooter m-3">
							<button type="submit" class="btn btn-success" id="editSubcategoryBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="removeSubcategoryModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-subcategory'] ?></h4>
				<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div class="removeSubcategoryMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeSubcategoryFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeSubcategoryBtn" data-loading-text="Loading..."><i class="fas fa-trash "></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /produt detail -->