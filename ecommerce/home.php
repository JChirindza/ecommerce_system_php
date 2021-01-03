<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
	<div class="container-fluid bg-light m-4">

		<div class="row">
			<div class="col-sm-3 bg-white p-3">
				<h4 class=""><i class="fas fa-list"></i> Categorias</h4>
				<div class="list-group list-group-flush border">
					<a href="#computadores" class="list-group-item list-group-item-action border-0">Computadores</a>
					<a href="#hardware" class="list-group-item list-group-item-action border-0">Hardware e pecas de Redes</a>
					<a href="#componentes" class="list-group-item list-group-item-action border-0">Componentes de computadores</a>
				</div>
			</div>

			<div class="col-sm-6">
				<div id="demo" class="carousel slide border" data-ride="carousel">

					<!-- Indicators -->
					<ul class="carousel-indicators">
						<li data-target="#demo" data-slide-to="0" class="active"></li>
						<li data-target="#demo" data-slide-to="1"></li>
						<li data-target="#demo" data-slide-to="2"></li>
						<li data-target="#demo" data-slide-to="3"></li>
						<li data-target="#demo" data-slide-to="4"></li>
					</ul>

					<!-- The slideshow -->
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="../assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
						</div>
						<div class="carousel-item">
							<img src="../assests/images/slide/s2.jpg" style="width:100%;height:250px;" alt="">
						</div>
						<div class="carousel-item">
							<img src="../assests/images/slide/s3.jpg" style="width:100%;height:250px;" alt="">
						</div>
						<div class="carousel-item">
							<img src="../assests/images/slide/s4.jpg" style="width:100%;height:250px;" alt="">
						</div>
						<div class="carousel-item">
							<img src="../assests/images/slide/s5.jpg" style="width:100%;height:250px;" alt="">
						</div>
					</div>

					<!-- Left and right controls -->
					<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>
				</div>					
			</div>

			<div class="col-sm-3 border bg-white p-3">
				<h4><i class="fas fa-list"></i> Categorias</h4>
			</div>
		</div>

		<div class="row mt-4" id="computadores">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-list"></i> Computadores </h4>

				<!-- fetch Computers -->
				<div class="row fetch_computers"></div>
			</div>
			<div class="col-sm-12 view-more">
				<a href="productFilters.php?category_id=1">+ view more</a>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-sm-3 border bg-white p-3">
				<h4><i class="fas fa-list"></i> Categorias</h4>
				<div class="list-group list-group-flush">
					<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
					<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
					<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
				</div>
			</div>

			<div class="col-sm-3 border bg-white p-3">
				<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>

			</div>

			<div class="col-sm-3 border bg-white p-3">
				<h4><i class="fas fa-list"></i> Categorias</h4>

			</div>
			<div class="col-sm-3 border bg-white p-3">
				<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>
				<div class="list-group list-group-flush">
					<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
					<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
					<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
				</div>
			</div>
		</div>

		<div class="row mt-4" id="hardware">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-network-wired"></i> Hardware e Pecas de Rede </h4>

				<!-- fetch Hardware and network parts -->
				<div class="row fetch_hardware"></div>
			</div>
			<div class="col-sm-12 view-more">
				<a href="productFilters.php?category_id=2">+ view more</a>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-sm-3 border bg-white p-3">
				<h4><i class="fas fa-list"></i> Categorias</h4>
				<div class="list-group list-group-flush">
					<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
					<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
					<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
				</div>
			</div>

			<div class="col-sm-3 border bg-white p-3">
				<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>

			</div>

			<div class="col-sm-3 border bg-white p-3">
				<h4><i class="fas fa-list"></i> Categorias</h4>

			</div>
			<div class="col-sm-3 border bg-white p-3">
				<h4 class="text-muted"><i class="fas fa-list"></i> Categorias</h4>
				<div class="list-group list-group-flush">
					<a id="navClient" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-people-arrows fa-lg mr-2"></i>Computadores</a>
					<a id="navReport" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-chart-line fa-lg mr-2"></i>Hardware e pecas de Redes</a>
					<a id="navSetting" href="#" class="list-group-item list-group-item-action border-0"><i class="fas fa-cogs fa-lg mr-2"></i>Componentes de computadores</a>
				</div>
			</div>
		</div>

		<div class="row mt-4" id="componentes">
			<div class="col-sm-12 bg-white p-3">
				<h4><i class="fas fa-network-wired"></i> Componentes de computador</h4>

				<!-- Computer components -->
				<div class="row fetch_components"></div>
			</div>
			<div class="col-sm-12 view-more border-top">
				<a href="productFilters.php?category_id=3">+ view more</a>
			</div>
		</div>
	</div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Deseja realmente sair?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Selecione <label class="text-muted"><i class="fas fa-sign-out-alt"></i> Sair </label> se deseja terminar a sessao.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<a class="btn btn-primary" href="../sign-out.php"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
			</div>
		</div>
	</div>
</div>

<!-- ToolTip JS -->
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script>
	$(document).ready(function(){

		fetch_computers();

		function fetch_computers() {
			$('.fetch_computers').html('<div id="loading" style="" ></div>');
			var action = 'fetch_computers';
			$.ajax({
				url:"php_action/fetch_data.php?category_id=1",
				method:"POST",
				data:{action:action},
				success:function(data){
					$('.fetch_computers').html(data);
				}
			});
		}
	});
</script>

<script>
	$(document).ready(function(){

		fetch_hardware();

		function fetch_hardware() {
			$('.fetch_hardware').html('<div id="loading" style="" ></div>');
			var action = 'fetch_hardware';
			$.ajax({
				url:"php_action/fetch_data.php?category_id=2",
				method:"POST",
				data:{action:action},
				success:function(data){
					$('.fetch_hardware').html(data);
				}
			});
		}
	});
</script>

<script>
	$(document).ready(function(){

		fetch_components();

		function fetch_components() {
			$('.fetch_components').html('<div id="loading" style="" ></div>');
			var action = 'fetch_components';
			$.ajax({
				url:"php_action/fetch_data.php?category_id=3",
				method:"POST",
				data:{action:action},
				success:function(data){
					$('.fetch_components').html(data);
				}
			});
		}
	});
</script>

<?php require_once 'includes/footer.php'; ?>