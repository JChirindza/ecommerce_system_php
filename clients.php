<?php require_once 'includes/header.php'; ?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
		<li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
		<li class="breadcrumb-item active"><?php echo $language['clients'] ?></li>

	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['clients'] ?></h1>
</div>

<div class="row">
	<div class="col-md-12">
		
		<div class="row">
			<div class="col-md-4 pt-2">
				<div class="card ">
					<div class="card-body d-sm-flex align-items-center justify-content-between">
						<label class="pb-0 my-0 font-weight-bold">
							<span><?php echo $language['total-clients'] ?></span> 
							<br>
							<label class="text-muted m-0 p-0" style="font-size: 12px; font-weight: initial;">
								<?php echo $language['active'] ?>:
								<span id="totalClientsActive">0</span>
							</label>
						</label>
						<label class="badge-secondary badge-pill font-weight-bold" id="totalClients">0</label>	
					</div> 
				</div> 
			</div> <!--/col-md-4-->
		</div>

		<hr>
		<div class="card">
			<div class="card-header bg-white">
				<h6 class="m-0 font-weight-bold text-muted"><?php echo $language['manage-clients'] ?></h6>
			</div>

			<div class="card-body ">
				<div class="remove-messages"></div>

				<div class="table-responsive table-responsive-sm table-hover">
					<table class="table table-striped" id="manageClientsTable">
						<thead>
							<tr>
								<th style="width:10%;"><?php echo $language['photo'] ?></th>
								<th style="width:15%;"><?php echo $language['contact'] ?></th>
								<th style="width:25%;"><?php echo $language['name'] ?></th>
								<th style="width:15%;"><?php echo $language['province'] ?></th>
								<th style="width:15%;"><?php echo $language['district'] ?></th>
								<th style="width:10%;"><?php echo $language['requests'] ?></th>
								<th style="width:10%;"><?php echo $language['status'] ?></th>
								<th style="width:10%;"><?php echo $language['options'] ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- client details -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		

		<div class="modal-content p-1">

			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-folder-plus"></i> <?php echo $language['client-details'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<div class="bg-light p-4">
				
				<div class="card mb-4">
					asdasdas
					asdasd
					as
				</div>

				<div class="card mb-4">
					asdasdas
					asdasd
					as
				</div>

				<div class="card">
					asdasdas
					asdasd
					as
				</div>

			</div>    


			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark" data-dismiss="modal"> <i class="fas fa-times"></i></button>
			</div> <!-- /modal-footer -->	
		</div> <!-- /modal-content -->    
	</div> <!-- /modal-dailog -->
</div> 
<!-- /client details -->

<script src="custom/js/client.js"></script>
<?php require_once 'includes/footer.php'; ?>


