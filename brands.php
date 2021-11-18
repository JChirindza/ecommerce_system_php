<?php require_once 'includes/header.php'; ?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
	    <li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
	    <li class="breadcrumb-item active"><?php echo $language['brands'] ?></li>
	    
  	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['brands'] ?></h1>
	<button class="btn btn-primary btn-sm" data-toggle="modal" id="addBrandModalBtn" data-target="#addBrandModel"> <i class="fas fa-plus"></i> <?php echo $language['add-brand'] ?> </button>
</div>

<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold text-muted"><?php echo $language['manage-brands'] ?></h6>
			</div>

			<div class="card-body ">

				<div class="remove-messages"></div>

				<div class="table-responsive table-responsive-sm table-hover">
					<table class="table" id="manageBrandTable">
						<thead>
							<tr>							
								<th><?php echo $language['brand-name'] ?></th>
								<th><?php echo $language['status'] ?></th>
								<th style="width:10%;"><?php echo $language['options'] ?></th>
							</tr>
						</thead>
					</table><!-- /table -->
				</div>
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addBrandModel" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form class="form-horizontal" id="submitBrandForm" action="php_action/ctrl_brand.php?action=create" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-plus"></i> <?php echo $language['add-brand'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="add-brand-messages"></div>

					<div class="form-group">
						<label for="brandName" class="col-sm-4 control-label"><?php echo $language['brand-name'] ?>: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="brandName" placeholder="<?php echo $language['brand-name'] ?>" name="brandName" autocomplete="off">
						</div>
					</div> <!-- /form-group-->	         	        
					<div class="form-group">
						<label for="brandStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
						<div class="col-sm-8">
							<select class="form-control" id="brandStatus" name="brandStatus">
								<option value="">~~<?php echo $language['select'] ?>~~</option>
								<option value="1"><?php echo $language['available'] ?></option>
								<option value="2"><?php echo $language['not-available'] ?></option>
							</select>
						</div>
					</div> <!-- /form-group-->	         	        

				</div> <!-- /modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i></button>

					<button type="submit" class="btn btn-success" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off"><i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
				</div>
				<!-- /modal-footer -->
			</form>
			<!-- /.form -->
		</div>
		<!-- /modal-content -->
	</div>
	<!-- /modal-dailog -->
</div>
<!-- / add modal -->

<!-- edit brand -->
<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form class="form-horizontal" id="editBrandForm" action="php_action/ctrl_brand.php?action=update" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $language['edit-brand'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div id="edit-brand-messages"></div>

					<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only"><?php echo $language['loading'] ?>...</span>
					</div>

					<div class="edit-brand-result">
						<div class="form-group">
							<label for="editBrandName" class="col-sm-4 control-label">Brand Name: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="editBrandName" placeholder="Brand Name" name="editBrandName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->	         	        
						<div class="form-group">
							<label for="editBrandStatus" class="col-sm-4 control-label"><?php echo $language['status'] ?>: </label>
							<div class="col-sm-8">
								<select class="form-control" id="editBrandStatus" name="editBrandStatus">
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1"><?php echo $language['available'] ?></option>
									<option value="2"><?php echo $language['not-available'] ?></option>
								</select>
							</div>
						</div> <!-- /form-group-->	
					</div>         	        
					<!-- /edit brand result -->

				</div> <!-- /modal-body -->

				<div class="modal-footer editBrandFooter">
					<button type="button" class="btn btn-outline-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
					<button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
				</div>
				<!-- /modal-footer -->
			</form>
			<!-- /.form -->
		</div>
		<!-- /modal-content -->
	</div>
	<!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-brand'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeBrandFooter">
				<button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-outline-danger" id="removeBrandBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script src="custom/js/brand.js"></script>

<?php require_once 'includes/footer.php'; ?>