<footer class="sticky-footer bg-white " style="margin-bottom: auto!important;">
	<div class="container my-auto ">
		<div class="copyright text-center my-auto">
			<span>Copyright <i class="fas fa-copyright"></i> Sitema de Vendas e Controle de Stock 2020 - <?php echo $anoAtual = date('Y'); ?></span>
		</div>
	</div>
</footer>
</div> <!-- container -->
<!-- Fetch User Image -->
<script type="text/javascript">
	var userid = <?php echo $userID; ?>;
	// userid = 2;
	if(userid) {
		$("#userid").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedUser.php',
			type: 'post',
			data: {"userid": userid},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');		

				$("#getUserImageNav").attr('src', 'users/'+response.user_image);

				$("#editUserImage").fileinput({		      
				});		

				

			} // /success function
		}); // /ajax to fetch product image
	}
</script>
<!-- Bootstrap core JavaScript -->
<!-- <script src="../assests/jquery/jquery.min.js"></script> -->
<script src="../assests/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="../assests/plugins/datatables/js/jquery.dataTables.min.js"></script>
</body>
</html>

