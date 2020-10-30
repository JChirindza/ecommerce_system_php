<?php require_once 'includes/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle">Categorias</h1>
	<button class="btn btn-primary btn-sm" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar Categoria </button>
</div>

<div class="row">
	<div class="col-md-12">

		<!-- <ol class="breadcrumb">
			<li><a href="dashboard.php">Home</a></li>		  
			<li class="active">Category</li>
		</ol> -->

		<div class="card">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-muted">Gerir Categorias</h6>
			</div>

			<div class="card-body ">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary btn-sm" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar Categoria </button>
				</div> <!-- /div-action -->				
				
				<div class="table-responsive">
					<table class="table" id="manageCategoriesTable">
						<thead>
							<tr>							
								<th>Categories Name</th>
								<th>Status</th>
								<th style="width:10%;">Options</th>
							</tr>
						</thead>
					</table><!-- /table -->
				</div>
			</div> 
		</div>	
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add categories -->
<div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="form-horizontal" id="submitCategoriesForm" action="php_action/createCategories.php" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add Categories</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="add-categories-messages"></div>

					<div class="form-group">
						<label for="categoriesName" class="col-sm-4 control-label">Categories Name: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="categoriesName" placeholder="Categories Name" name="categoriesName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	         	        
					<div class="form-group">
						<label for="categoriesStatus" class="col-sm-4 control-label">Status: </label>
						<div class="col-sm-8">
							<select class="form-control" id="categoriesStatus" name="categoriesStatus">
								<option value="">~~SELECT~~</option>
								<option value="1">Available</option>
								<option value="2">Not Available</option>
							</select>
						</div>
					</div> <!-- /form-group-->	         	        
				</div> <!-- /modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

					<button type="submit" class="btn btn-primary" id="createCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
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

			<form class="form-horizontal" id="editCategoriesForm" action="php_action/editCategories.php" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="edit-categories-messages"></div>

					<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

					<div class="edit-categories-result">
						<div class="form-group">
							<label for="editCategoriesName" class="col-sm-4 control-label">Category Name: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editCategoriesName" placeholder="Categories Name" name="editCategoriesName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	         	        
						<div class="form-group">
							<label for="editCategoriesStatus" class="col-sm-4 control-label">Status: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editCategoriesStatus" name="editCategoriesStatus">
									<option value="">~~SELECT~~</option>
									<option value="1">Available</option>
									<option value="2">Not Available</option>
								</select>
							</div>
						</div> <!-- /form-group-->	 
					</div>         	        
					<!-- /edit categories result -->

				</div> <!-- /modal-body -->

				<div class="modal-footer editCategoriesFooter">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

					<button type="submit" class="btn btn-success" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
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
				<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer removeCategoriesFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
				<button type="button" class="btn btn-primary" id="removeCategoriesBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories -->

<script src="custom/js/categories.js"></script>

<?php require_once 'includes/footer.php'; ?>