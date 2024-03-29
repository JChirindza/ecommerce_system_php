<?php  
if(isset($_SESSION['userId'])) {

	// Get username
	$userID = Sys_Secure($_SESSION['userId']);
	$sql = "SELECT * FROM users WHERE user_id = '$userID' ";
	$result = $connect->query($sql);
	if($result->num_rows > 0) { 
		while($row = $result->fetch_array()) {
			$username = $row[1];
			$user_image_url = $row[5];

			// Destroi sessao caso nao tenha carrinho na db
			if (isset($_SESSION['cartId'])) {
				// Veriifca se o carrinho com a sessao iniciada existe na Base de Dados
				$sql = "SELECT * FROM cart WHERE cart_id = {$_SESSION['cartId']}";
				$userCartResult = $connect->query($sql);

				if ($userCartResult->num_rows <= 0) {
					unset($_SESSION['cartId']);
				}
			}

			// verifica se o usuario autenticado tem um carrinho iniciado.
			if(!isset($_SESSION['cartId'])){
				// busca por um carrinho do usuario logado que nao tenha sido pago(2) e que esteja activo(1)
				$sql = "SELECT * FROM cart WHERE user_id = {$userID} AND payment_status = 2 AND active = 1 limit 1";
				$userCartResult = $connect->query($sql);
				if ($userCartResult && $userCartResult->num_rows > 0) {
					$userCart = $userCartResult->fetch_array();
					$_SESSION['cartId'] = $userCart['cart_id'];
				}elseif(!isset($_SESSION['cartId'])){
					// Se nao tiver um carrinho activo(disponivel), cria um novo carrinho vazio para usuario.
					$sql = "INSERT INTO `cart` (`user_id`, `payment_status`, `active`, `status`) VALUES ('$userID', '2', '1', '1')";
					if($newCartResult = $connect->query($sql)) {
						$cart_id = $connect->insert_id;
						// echo "New record created successfully. Last inserted ID is: " . $cart_id;
						$_SESSION['cartId'] = $cart_id;
					} 
				}
			}
 		} // /while 
	}// if num_rows
	
	if (isset($_SESSION['cartId'])) {
		$cartId = Sys_Secure($_SESSION['cartId']);
		$countItemSql = "SELECT * FROM cart_item WHERE cart_id = {$cartId}";
		$itemCountResult = $connect->query($countItemSql);
		$itemCountRow = $itemCountResult->num_rows;
	}
}


?>

<nav class="navbar navbar-expand-lg border-bottom shadow-sm bg-dark">
	<!-- Brand -->
	<div class="col-sm-2 col-md-4 col-lg-3">
		<a class="navbar-brand logo p-0 border pr-1 pl-1" href="../index.php">ComputersOnly</a>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-6">
		<div class="input-group col-12 m-auto">
			<input type="text" class="col-10 rounded-left border-0" id="myInput" placeholder="<?php echo $language['search'] ?>..." name="search">
			<div class="col-2 p-0 input-group-append">
				<button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
			</div>
		</div>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-3 d-flex justify-content-end">
		<div class="row">
			<div class="col-10 collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item border-primary navHome">
						<a class="nav-link text-white" href="home.php">
							<i class="fas fa-home fa-lg"></i>
						</a>
					</li>
					<?php 
					if (isset($_SESSION['userId'])){ ?>
						<li class="nav-item border-primary navCart pl-2">
							<a href="cart.php?c=cartItems&i=<?php echo $_SESSION['cartId']; ?>" class="nav-link text-white">
								<i class="fas fa-cart-arrow-down fa-lg"></i>
								<span id="cart_count_items" class="badge badge-warning m-0"></span>
							</a>
						</li>
						<?php 
					}else{ ?>
						<li class="nav-item border-primary navLogin pl-4">
							<a class="nav-link text-white border btn pl-4 pr-4 d-flex justify-content-center" href="../sign-in.php"><i class="fas fa-unlock fa-lg mr-2"></i> <?php echo $language['sign-in']; ?></a>
						</li>
						<?php
					} ?>
				</ul>
			</div>
			<?php if (isset($_SESSION['userId'])){ ?>
				<div class="col-2">
					<div class="dropdown navbar-nav float-right ">
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<img class="img-profile rounded-circle border border-info" id="getUserImageNav"  style="width: 35px; height: 35px;">
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<div class="dropdown-header disabled text-center p-0 m-0 text-gray"><?php echo $language['hello'] ?>, <?php echo $username; ?></div>
										<div class="dropdown-divider my-0 py-0"></div>
										<a id="topNavSetting" class="dropdown-item" href="setting.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i><?php echo $language['settings'] ?></a>
										<div class="dropdown-divider my-0 py-0"></div>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i><?php echo $language['sign-out'] ?></a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>

</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><?php echo $language['do-you-r-w-to-exit'] ?>?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"><?php echo $language['select'] ?> <label class="text-muted"><i class="fas fa-sign-out-alt"></i> <?php echo $language['sign-out'] ?> </label> <?php echo $language['if-y-w-end-session'] ?>.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="../sign-out.php"><i class="fas fa-sign-out-alt mr-2"></i><?php echo $language['sign-out'] ?></a>
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
			$("#getUserImageNav").attr('src', '../users/'+response.user_image);
			$("#getUserImage").attr('src', '../users/'+response.user_image);
			} // /success function
		}); // /ajax to fetch product image
	}

	setCartItemQuantity();
	// set cart item quantity
	function setCartItemQuantity(){
		$.ajax({
			url: 'php_action/ctrl_cart.php?action=readItemQuant',
			type: 'post',
			dataType: 'json',
			success:function(response) {		
				$('#cart_count_items').text(response.totalQuantity);
				} // /success function
		}); // /ajax to fetch product image
	}
</script>