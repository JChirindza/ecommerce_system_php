<?php 
if( !(isset($_SESSION['userId']) && isset($_SESSION['userType'])) ) { ?>
	<!-- Access deined - sidebar -->
	<div class="border-right" id="sidebar-wrapper">
		<div class="list-group list-group-flush">
			<a id="navDashboard" href="dashboard.php" class="list-group-item list-group-item-action active"> 
				<div class="row">
					<div class="col-2"><i class="fa fa-desktop fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['dashboard']; ?></span></div>
				</div>
			</a>
			<a id="navAbout" href="eStore/about.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fa fa-cogs fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['about']; ?></span></div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-10 p-4 justify-content-center">
		<!-- Alert message -->
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-exclamation-triangle"></i>
			HTTP/1.1 403 - <?php echo $language['access-403']; ?>. | <a href="./sign-in.php" class="font-weight-bold"><?php echo $language['sign-in']; ?>.</a>
		</div>
		<!-- sign-in button -->
		<div class="d-flex justify-content-center">
			<a href="sign-in.php" class="btn btn-primary btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="<?php echo $language['sign-in-f-a-better-experience']; ?>"><i class="fas fa-unlock"></i> <?php echo $language['sign-in'] ?></a>
		</div>
	</div>	
	<?php
	die();
}else{ 
	?>
	<!-- Sidebar -->
	<div class="border-right" id="sidebar-wrapper">
		<div class="list-group list-group-flush">
			<a id="navDashboard" href="dashboard.php" class="list-group-item list-group-item-action"> 
				<div class="row">
					<div class="col-2"><i class="fa fa-desktop fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['dashboard']; ?></span></div>
				</div>
			</a>
			<a id="navOrder" href="orders.php?p=manord" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-cart-arrow-down fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['orders']; ?></span></div>
				</div>
			</a>
			<a id="navRequest" href="request.php?r=manreq" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-cart-plus fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['requests']; ?></span></div>
				</div>
			</a>
			<a id="navProduct" href="products.php?p=manprod" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fab fa-product-hunt fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['products']; ?></span></div>
				</div>
			</a>
			<a id="navBrand" href="brands.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-business-time fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['brands']; ?></span></div>
				</div>
			</a>
			<a id="navCategories" href="categories.php?c=manctg" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-clipboard fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['categories']; ?></span></div>
				</div>
			</a>
			<a id="navUser" href="users.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-users fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['users']; ?></span></div>
				</div>
			</a>
			<a id="navClient" href="clients.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-people-arrows fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['clients']; ?></span></div>
				</div>
			</a>
			<a id="navReport" href="reports.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-chart-line fa-lg"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['reports']; ?></span></div>
				</div>
			</a>
			<a id="navSetting" href="profile.php" class="list-group-item list-group-item-action">
				<div class="row">
					<div class="col-2"><i class="fas fa-user-cog fa-lg mr-2"></i></div>
					<div class="col-auto"><span class="item-name"><?php echo $language['profile']; ?></span></div>
				</div>
			</a>
		</div>
	</div>
	<?php 
} 
?>