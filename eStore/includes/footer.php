<?php if (!isset($_SESSION['userId'])){ ?>
	<div class="d-flex justify-content-center m-4">
		<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="Sign-in for a better experience."><i class="fas fa-unlock"></i> <?php echo $language['sign-in'] ?></a>
	</div>
<?php } ?>
<div class="d-flex mt-4" id="wrapper">
	<div class="container-fluid bg-white">
		<footer class="sticky-footer px-2 py-4" style="margin-bottom: auto!important;" id="footer">
			<div class="row">
				<div class="col-6 copyright">
					<span>Copyright <i class="fas fa-copyright"></i> ComputersOnly | 2020 - <?php echo $anoAtual = date('Y'); ?></span>
				</div>

				<div class="col-6 text-right d-flex justify-content-end">
					<div class="pr-2"><i class="fas fa-globe text-secondary"></i></div>
					<div class="language_link">
						<a class="language_link_item fw-bolder" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=en" >English
						</a> | 
						<a class="language_link_item" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=pt" >Portugues
						</a>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
</div> <!-- container -->

<!-- ToolTip JS -->
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<!-- Bootstrap core JavaScript -->
<!-- <script src="../assests/jquery/jquery.min.js"></script> -->
<script src="../assests/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- file input -->
<script src="../assests/plugins/fileinput/js/fileinput.min.js"></script>

<!-- DataTables -->
<script src="../assests/plugins/datatables/js/jquery.dataTables.min.js"></script>
</body>
</html>

