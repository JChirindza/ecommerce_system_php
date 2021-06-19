<?php require_once 'php_action/core.php'; ?>
<?php 
// Get username
if (isset($_SESSION['userId'])) {
	$userID = $_SESSION['userId'];
	$sql = "SELECT * FROM users WHERE user_id = '$userID' ";
	$result = $connect->query($sql);
	if($result->num_rows > 0) { 
		while($row = $result->fetch_array()) {
			$username = $row[1];
	 	} // /while 
	}// if num_rows
}

?>
<nav class="navbar navbar-expand-lg border-bottom shadow-sm" >
	<!-- Brand -->
	<div class="col-md">
		<a class="col-md  brand navbar-brand logo p-0 text-primary border" href="dashboard.php">ComputersOnly</a>
	</div>
	
	<div class="col-md-10">
		<div class="dropdown navbar-nav float-right">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="img-profile rounded-circle border border-info" id="getUserImageNav"  style="width: 35px; height: 35px;">
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<div class="dropdown-header disabled text-center p-0 m-0 text-gray">Hello, <?php echo $username; ?></div>
							<div class="dropdown-divider mt-0 mb-0 pb-0 pt-0"></div>
							<a id="topNavSetting" class="dropdown-item" href="profile.php"><i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
							<div class="dropdown-divider mt-0 mb-0 pb-0 pt-0"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#changeuserModal"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>Change user</a>
							<div class="dropdown-divider mt-0 mb-0 pb-0 pt-0"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Do you really want exit?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Select <label class="text-muted"><i class="fas fa-sign-out-alt"></i> Sign-out </label> if you want to end the session.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="sign-out.php?"><i class="fas fa-sign-out-alt mr-2"></i>Sign-out</a>
			</div>
		</div>
	</div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="changeuserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Do you really want to change this user?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Select <label class="text-muted"><i class="fas fa-sign-in-alt"></i> Change </label> if you want to end this session and sign-in with other user.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="changeUser.php"><i class="fas fa-sign-in-alt mr-2"></i>Change</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var userid = <?php echo $userID; ?>;
	if(userid) {
		$.ajax({
			url: 'php_action/ctrl_user.php?action=readSelected',
			type: 'post',
			data: {"userid": userid},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
			$("#getUserImageNav").attr('src', 'users/'+response.user_image);
			} // /success function
		}); // /ajax to fetch product image
	}
</script>