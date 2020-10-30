<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists
			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				// set session
				$_SESSION['userId'] = $user_id;

				header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
			} else{
				
				$errors[] = "Incorrect username/password combination";
			} // /else
		} else {		
			$errors[] = "Username doesnot exists";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Venda e Gestão de Stock</title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/fontawesome.min.css">
	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/style.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">
	<!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
	<!-- jquery ui -->  
	<link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
	<script src="assests/jquery-ui/jquery-ui.min.js"></script>

	
</head>
<body>
	<div class="container">
		<div class="row vertical ">
			<div class="col-md-4 col-md-offset-4 m-auto">
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
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" />
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
										<a href="esqueceuSenha.php" id="esqueceuSenha">Esqueceu a senha?</a>
									</div>
								</div>
							</fieldset>
							<hr>
							<div class="form-group">
								<div class="col-sm-offset-0 col-sm-12">
									<button type="submit" class="btn btn-primary btn-block"> <i class="fas fa-sign-in-alt"></i> Criar conta</button>
								</div>
								<div class="col-sm-12 text-center">
									<a href="index.php" id="back">Voltar</a>
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







