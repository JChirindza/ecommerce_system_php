<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="signupForm">
    <fieldset>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" class="form-control" id="usernamereg" name="usernamereg" placeholder="Nome do usuário" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" class="form-control" id="passwordreg" name="passwordreg" placeholder="Senha" autocomplete="off" />
            </div>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="confpasswordreg" name="confpasswordreg" placeholder="Confirmar Senha" autocomplete="off" />
            </div>
        </div>                              
        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-12">
                <button type="submit" class="btn btn-success btn-block"> <i class="glyphicon glyphicon-log-in"></i> Criar</button>
            </div>
        </div>
    </fieldset>
</form>