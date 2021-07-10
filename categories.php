<?php require_once 'includes/header.php'; ?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
		<li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
		<li class="breadcrumb-item active"><?php echo $language['categories'] ?></li>
		<li class="breadcrumb-item active" aria-current="page">
			<?php if($_GET['c'] == 'manctg') { 
				echo $language['manage']; 
			} else if($_GET['c'] == 'subc') {
				echo $language['details']; 
			} // /else manage ?>
		</li>
	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['categories'] ?></h1>
	<?php if($_GET['c'] == 'manctg') { // manage categories ?>
		<button class="btn btn-primary btn-sm" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCategoriesModal"> <i class="fas fa-plus"></i> <?php echo $language['add-category'] ?> </button>
	<?php } else if($_GET['c'] == 'subc') { // add categories ?>
		<a href="products.php?p=manprod" class="btn btn-primary btn-sm"> <i class="fas fa-cogs"></i> <?php echo $language['manage-categories'] ?> </a>
	<?php } ?>
	
</div>

<?php if($_GET['c'] == 'manctg') { // gerir produto ?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-white">
					<h6 class="m-0 font-weight-bold text-muted"><?php echo $language['manage-categories'] ?></h6>
				</div>

				<div class="card-body ">

					<div class="remove-messages"></div>
					<div class="table-responsive">
						<table class="table table-hover" id="manageCategoriesTable">
							<thead>
								<tr>			
									<th width="5%">#</th>				
									<th width="40%"><?php echo $language['categ-name'] ?></th>
									<th width="15%"><?php echo $language['subcategories'] ?></th>
									<th width="15%"><?php echo $language['products'] ?></th>
									<th width="15%"><?php echo $language['status'] ?></th>
									<th width="10%"><?php echo $language['options'] ?></th>
								</tr>
							</thead>
						</table><!-- /table -->
					</div>
				</div> 
			</div>	
		</div> <!-- /col-md-12 -->
	</div> <!-- /row -->
<?php } else if($_GET['c'] == 'subc') { // add subcategories
	// add subcategories
	require_once 'subcategories.php';
} ?>

<!-- add categories -->
<div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="form-horizontal" id="submitCategoriesForm" action="php_action/ctrl_category.php?action=create" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fas fa-plus"></i> <?php echo $language['add-category'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="add-categories-messages"></div>

					<div class="form-group">
						<label for="categoriesName" class="col-sm-4 control-label"><?php echo $language['categ-name'] ?>: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="categoriesName" placeholder="<?php echo $language['categ-name'] ?>" name="categoriesName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	         	        
					<div class="form-group">
						<label for="categoriesStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
						<div class="col-sm-8">
							<select class="form-control" id="categoriesStatus" name="categoriesStatus">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1"><?php echo $language['available'] ?></option>
								<option value="2"><?php echo $language['not-available'] ?></option>
							</select>
						</div>
					</div> <!-- /form-group-->	         	        
				</div> <!-- /modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
					<button type="submit" class="btn btn-success" id="createCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
				</div> <!-- /modal-footer -->	      
			</form> <!-- /.form -->	     
		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- edit categories -->
<div class="modal fade" id="editCategoriesModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="form-horizontal" id="editCategoriesForm" action="php_action/ctrl_category.php?action=update" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $language['edit-category'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="edit-categories-messages"></div>

					<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only"><?php echo $language['loading'] ?>...</span>
					</div>

					<div class="edit-categories-result">
						<div class="form-group">
							<label for="editCategoriesName" class="col-sm-4 control-label"><?php echo $language['categ-name'] ?>: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editCategoriesName" placeholder="Categories Name" name="editCategoriesName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	         	        
						<div class="form-group">
							<label for="editCategoriesStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editCategoriesStatus" name="editCategoriesStatus">
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1"><?php echo $language['available'] ?></option>
									<option value="2"><?php echo $language['not-available'] ?></option>
								</select>
							</div>
						</div> <!-- /form-group-->	 
					</div>         	        
					<!-- /edit categories result -->

				</div> <!-- /modal-body -->

				<div class="modal-footer editCategoriesFooter">
					<button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal"> <i class="fas fa-times"></i></button>
					<button type="submit" class="btn btn-success" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
				</div>
				<!-- /modal-footer -->
			</form>
			<!-- /.form -->
		</div>
		<!-- /modal-content -->
	</div>
	<!-- /modal-dailog -->
</div>
<!-- /categories -->

<!-- categories -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCategoriesModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-category'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeCategoriesFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeCategoriesBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories -->

<script src="custom/js/categories.js"></script>
<script src="custom/js/subcategories.js"></script>

<?php require_once 'includes/footer.php'; ?>