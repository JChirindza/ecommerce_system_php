<?php require_once 'includes/header.php'; ?>
<?php  
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<div class="p-4" style="height: 800px;">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			<?php echo $language['access-403'] ?>.
		</div>
		<div class="d-flex justify-content-center">
			<a href="../sign-in.php" class="btn btn-primary"><i class="fas fa-sign-in-alt pr-2"></i> <?php echo $language['sign-in'] ?></a>
		</div>
	</div>

	<?php
	require_once 'includes/footer.php';
	die();
}else{
	$user_id = Sys_Secure($_SESSION['userId']);
	$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
	$query = $connect->query($sql);
	$result = $query->fetch_assoc();
}

$connect->close();
?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['locations'] ?></li>
			</ol>
		</div>
		
		<div class="row mt-2 mt-md-0 mt-lg-0">
			<div class="col-sm-12 bg-white p-3 userSettings">
				<h4><i class="fas fa-map-marker-alt"></i> <?php echo $language['store-location'] ?></h4>
				<div class="col-md-12 p-0 mt-2">
					
				</div> <!-- /col-md-12 -->
			</div>
		</div>

		<div class="row mt-2 mt-md-3 mt-lg-4">
			<div class="col-sm-12 bg-white p-3 userSettings " id="delivery_address">
				<h4><i class="fas fa-shipping-fast"></i> <?php echo $language['delivery-locations'] ?> </h4>
				<div class="col-md-12 p-0 mt-2">
					
				</div>
			</div>
		</div>
	</div> <!-- / container-fluid -->
</div> <!-- / wrapper -->

<?php require_once 'includes/footer.php'; ?>