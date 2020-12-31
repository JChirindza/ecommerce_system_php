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
					<i class="fas fa-exclamation"></i>
					'.$value.'</div>';										
				}
			} ?>
		</div>
		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
			<fieldset>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required />
					</div> 
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="password" class="form-control" id="password" name="password" placeholder="Senha" autocomplete="off" required/>
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