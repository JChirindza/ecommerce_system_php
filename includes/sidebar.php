<div class="border-right" id="sidebar-wrapper">
	<!-- <div class="sidebar-heading">Start Bootstrap </div> -->
	<div class="list-group list-group-flush">
		<a id="navDashboard" href="dashboard.php" class="list-group-item list-group-item-action border"> <i class="fa fa-desktop fa-lg mr-2 "></i> Dashboard</a>
		<a id="navOrder" href="pedidos.php?p=manord" class="list-group-item list-group-item-action border"><i class="fas fa-cart-arrow-down fa-lg mr-2"></i>Pedidos</a>
		<a id="navxxx" href="#" class="list-group-item list-group-item-action border"><i class="fas fa-cart-plus fa-lg mr-2"></i>Compras</a>
		<?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
		<a id="navProduct" href="produto.php" class="list-group-item list-group-item-action border"><i class="fab fa-product-hunt fa-lg mr-2"></i>Produtos</a>
		<a id="navBrand" href="marca.php" class="list-group-item list-group-item-action border"><i class="fas fa-business-time fa-lg mr-2"></i>Marcas</a>
		<a id="navCategories" href="categoria.php" class="list-group-item list-group-item-action border"><i class="fas fa-clipboard fa-lg mr-2"></i>Categorias</a>
		<a id="navUser" href="usuario.php" class="list-group-item list-group-item-action border"><i class="fas fa-users fa-lg mr-2"></i>Usuarios</a>
		<?php } ?>
		<a id="navClient" href="cliente.php" class="list-group-item list-group-item-action border"><i class="fas fa-people-arrows fa-lg mr-2"></i>Clientes</a>
		<?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
		<a id="navReport" href="relatorio.php" class="list-group-item list-group-item-action border"><i class="fas fa-chart-line fa-lg mr-2"></i>Relatorios</a>
		<?php } ?>
		<a id="navSetting" href="config.php" class="list-group-item list-group-item-action border"><i class="fas fa-cogs fa-lg mr-2"></i>Configurações</a>
	</div>
</div>