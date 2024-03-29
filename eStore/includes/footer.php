<?php if (!isset($_SESSION['userId'])){ ?>
	<div class="d-flex justify-content-center m-4">
		<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="<?php echo $language['sign-in-f-a-better-experience']; ?>"><i class="fas fa-unlock"></i> <?php echo $language['sign-in'] ?></a>
	</div>
<?php } ?>

<?php

$url = Sys_current_url();  

if (isset($_GET['lang'])) {
	$url = removeqsvar($url, "lang");
}

if ($_GET) {
	// append
	$url .=	"&lang=";
}else{
	// append
	$url .=	"?lang=";
}
?>
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
						<a class="language_link_item" <?php if($lang == 'en'){ ?> style="font-weight: bold;" <?php } ?> href="<?php echo $url; ?>en" ><?php echo $sys['langs']['en']; ?>
						</a> | 
						<a class="language_link_item" <?php if($lang == 'pt'){ ?> style="font-weight: bold;" <?php } ?> href="<?php echo $url; ?>pt" ><?php echo $sys['langs']['pt']; ?>
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

