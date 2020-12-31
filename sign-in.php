<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	if ($_SESSION['userType'] == 1) {
		header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
	}
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
				$user_type = $value['type'];

				// set session
				$_SESSION['userId'] = $user_id;
				$_SESSION['userType'] = $user_type;

				if ($_SESSION['userType'] == 1) {
					header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php');	
				}else{
					header('location: http://localhost/SistemaDeVendas_ControleDeStock/index.php');	
				}
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
				<?php require_once 'loginForm.php'; ?>
			</div>
		</div>
	</div>
	<!-- container -->	
</body>
</html>







