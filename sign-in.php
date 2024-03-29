<?php 
require_once 'php_action/core.php';
require_once 'php_action/init.php';

if(isset($_SESSION['userId'])) {
	if ($_SESSION['userType'] == 1) {
		header('location: dashboard.php');	
	}else{
		header('location: index.php');	
	}
}

$errors = array();

if($_POST) {		

	$email = Sys_Secure($_POST['email']);
	$password = Sys_Secure($_POST['password']);

	if(empty($email) || empty($password)) {
		if($email == "") {
			$errors[] = "Email is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE email = '$email' AND active != 2";
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

				header('location: index.php'); 
                exit();
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

	<title>ComputersOnly - Web Store</title>

	<!-- bootstrap CSS 4.5.3 -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- fontawesome JS 5.15.1 -->
	<script type="text/javascript" src="assests/font-awesome/js/all.min.js"></script>
	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/style.css">
</head>
<body class="bg-light">
	<div class="border d-flex justify-content-end pr-4">
		<div><i class="fas fa-globe mr-4 text-secondary"></i></div>
		<div class="language-link mr-4">
			<a class="language-link-item" href="./sign-in.php?lang=en" <?php if($lang == 'en'){ ?> style="color: #1b00ff; font-weight: bold;" <?php } ?> >En
			</a> | 
			<a class="language-link-item" href="./sign-in.php?lang=pt" <?php if($lang == 'pt'){ ?> style="color: #1b00ff; font-weight: bold;" <?php } ?> >Pt
			</a>
		</div>
	</div>
	<div class="container">
		<div class="row vertical ">
			<div class="col-md-4 col-md-offset-4 m-auto">
				<div class="col-md pb-2">
					<a class="col-md navbar-brand logo p-0 text-primary" href="index.php">ComputersOnly</a>
				</div>
				<div class="card">
					<div class="card-header text-center bg-white">
						<h4><?php echo $language['login'] ?></h4>
					</div>
					<div class="card-body">
						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="fas fa-exclamation"></i>
									'.$value.'</div>';										
								}
							} ?>
						</div>
						<form class="form-horizontal" action="<?php echo Sys_Secure($_SERVER["PHP_SELF"]);?>" method="post" id="loginForm">
							<fieldset>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $language['email']; ?>" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required />
									</div> 
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $language['password']; ?>" autocomplete="off" required/>
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-0 col-sm-12">
										<button type="submit" class="btn btn-success btn-block"> <i class="fas fa-sign-in-alt"></i> <?php echo $language['sign-in']; ?></button>
										<a href="#" id="forgot-password" class="font-weight-light"> <?php echo $language['forgot-password']; ?>?</a>
									</div>
								</div>
							</fieldset>
							<hr>
							<div class="form-group">
								<div class="col-sm-offset-0 col-sm-12">
									<a href="sign-up.php" class="btn btn-primary btn-block" id="addUserModalBtn"> <i class="fas fa-sign-in-alt"></i> <?php echo $language['create-new-account']; ?></a>
								</div>
								<div class="col-sm-12 text-center">
									<a href="index.php" id="back" class="font-weight-light"><i class="fas fa-arrow-left"></i> <?php echo $language['back']; ?></a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div><!-- container -->	
</body>
</html>







