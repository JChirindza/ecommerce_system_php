<?php 
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<!-- Access deined - sidebar -->
	<div class="border-right" id="sidebar-wrapper">
		<div class="list-group list-group-flush">
			<a id="navDashboard" href="dashboard.php" class="list-group-item list-group-item-action border-0"> <i class="fa fa-desktop fa-lg mr-2"></i> Dashboard</a>
			<a id="navAbout" href="eStore/about.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i><?php echo $language['about']; ?></a>
		</div>
	</div>

	<div class="col-10 p-4">
		<!-- Alert message -->
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			HTTP/1.1 403 - <?php echo $language['access-403']; ?>. | <a href="./sign-in.php" class="font-weight-bold"><?php echo $language['sign-in']; ?>.</a>
		</div>
		<!-- sign-in button -->
		<div class="d-flex justify-content-center">
			<a href="./sign-in.php" class="btn btn-primary"><i class="fas fa-sign-in-alt pr-2"></i> <?php echo $language['sign-in']; ?></a>
		</div>
	</div>	
	<?php
	die();
}else{ 
	?>
	<!-- Sidebar -->
	<div class="border-right" id="sidebar-wrapper">
		<div class="list-group list-group-flush">
			<a id="navDashboard" href="dashboard.php" class="list-group-item list-group-item-action border-0"> <i class="fa fa-desktop fa-lg mr-2 "></i> <?php echo $language['dashboard']; ?></a>
			<a id="navOrder" href="orders.php?p=manord" class="list-group-item list-group-item-action border-0"><i class="fas fa-cart-arrow-down fa-lg mr-2"></i><?php echo $language['orders']; ?></a>
			<a id="navRequest" href="request.php?r=manreq" class="list-group-item list-group-item-action border-0"><i class="fas fa-cart-plus fa-lg mr-2"></i><?php echo $language['requests']; ?></a>
			<a id="navProduct" href="products.php?p=manprod" class="list-group-item list-group-item-action border-0"><i class="fab fa-product-hunt fa-lg mr-2"></i><?php echo $language['products']; ?></a>
			<a id="navBrand" href="brands.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-business-time fa-lg mr-2"></i><?php echo $language['brands']; ?></a>
			<a id="navCategories" href="categories.php?c=manctg" class="list-group-item list-group-item-action border-0"><i class="fas fa-clipboard fa-lg mr-2"></i><?php echo $language['categories']; ?></a>
			<a id="navUser" href="users.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-users fa-lg mr-2"></i><?php echo $language['users'] ?></a>
			<a id="navClient" href="clients.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i><?php echo $language['clients']; ?></a>
			<a id="navReport" href="reports.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i><?php echo $language['reports']; ?></a>
			<a id="navSetting" href="profile.php" class="list-group-item list-group-item-action border-0"><i class="fas fa-user-cog fa-lg mr-2"></i><?php echo $language['profile']; ?></a>
		</div>
	</div>
	<?php 
} 
?>