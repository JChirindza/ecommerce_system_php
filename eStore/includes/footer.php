<?php if (!isset($_SESSION['userId'])){ ?>
	<div class="d-flex justify-content-center m-4">
		<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="Sign-in for a better experience."><i class="fas fa-unlock"></i> Login</a>
	</div>
<?php } ?>
<footer class="sticky-footer bg-white mt-1" style="margin-bottom: auto!important;">
	<div class="container my-auto ">
		<div class="copyright text-center my-auto">
			<span>Copyright <i class="fas fa-copyright"></i> ComputersOnly | 2020 - <?php echo $anoAtual = date('Y'); ?></span>
		</div>
	</div>
</footer>
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

