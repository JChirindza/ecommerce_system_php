<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: ../SistemaDeVendas_ControleDeStock/dashboard.php');	
}

$errors = array();

if($_POST) {		

	$email = $_POST['email'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Email is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE email = '$email' and active != 2";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists
			$mainSql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				// set session
				$_SESSION['userId'] = $user_id;

				header('location: ../SistemaDeVendas_ControleDeStock/dashboard.php');	
			} else{
				
				$errors[] = "Incorrect Email/password combination";
			} // /else
		} else {		
			$errors[] = "Email doesnot exists";		
		} // /else
	} // /else not empty Email // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sistema de Vendas - Online</title>

	<!-- bootstrap CSS 4.5.3 -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- fontawesome JS 5.15.1 -->
	<script type="text/javascript" src="assests/font-awesome/js/all.min.js"></script>
	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/style.css">
	<!-- DataTables 1.10.22 -->
	<link rel="stylesheet" href="assests/plugins/datatables/css/jquery.dataTables.min.css">
	<!-- file input -->
	<link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
	<!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
	<!-- jquery ui 1.12.1 -->  
	<link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
	<script src="assests/jquery-ui/jquery-ui.min.js"></script>
	<!-- Select2 CDN -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
	<!-- Select2 - Custom JS -->
	<script type="text/javascript" src="assests/select2/select2Custom.js"></script>
</head>
<body>
	<div class="container">
		<div class="row vertical ">
			<div class="col-md-4 col-md-offset-4 m-auto">
				<div class="col-md pb-2">
					<a class="col-md navbar-brand logo p-0 text-primary" href="index.php">ComputersOnly</a>
				</div>
				<div class="card">
					<div class="card-header text-center">
						<h4>Autentique-se</h4>
					</div>
					<div class="card-body">
						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
								}
							} ?>
						</div>
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="password" class="form-control" id="password" name="password" placeholder="Senha" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-0 col-sm-12">
										<button type="submit" class="btn btn-success btn-block"> <i class="glyphicon glyphicon-log-in"></i> Entrar</button>
										<a href="esqueceuSenha.php" id="esqueceuSenha" class="font-weight-light">Esqueceu a senha?</a>
									</div>
								</div>
							</fieldset>
							<hr>
							<div class="form-group">
								<div class="col-sm-offset-0 col-sm-12">
									<a href="sign-up.php" class="btn btn-primary btn-block" id="addUserModalBtn"> <i class="fas fa-sign-in-alt"></i> Criar conta</a>
								</div>
								<div class="col-sm-12 text-center">
									<a href="index.php" id="back" class="font-weight-light"><i class="fas fa-arrow-left"></i> Voltar</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- container -->	
</body>
</html>







