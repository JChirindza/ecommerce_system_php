<?php 
require_once 'php_action/db_connect.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {    

    $name       = $_POST['name'];
    $surname    = $_POST['surname'];
    $uemail     = $_POST['uemail'];
    $upassword  = md5($_POST['upassword']);
    $url        = '../assests/images/photo_default.png';
    
    $cpassword =  md5($_POST['cpassword']);
    
    $sql1 = "SELECT * FROM users WHERE email = '$uemail' ";
    $query1 = $connect->query($sql1);
    $count = $query1->num_rows;
    
    if ($count == 0) {
        if($upassword == $cpassword) {

            $sql = "INSERT INTO users (name, surname, email, password, user_image, type, permittion, active, status) 
            VALUES ('$name', '$surname', '$uemail', '$upassword', '$url', 2, 0, 1, 1)";

            if($connect->query($sql) === TRUE) {
                $valid['success'] = true;
                $valid['messages'] = "Successfully Added";  
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while adding the members";
            }
        } else {
            $valid['success'] = false;
            $valid['messages'] = "New password does not match with Conform password";
        }
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Existing email, please type another one!";
    }
} // if in_array        

$connect->close();

echo json_encode($valid);
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
</head>
<body>
    <div class="container">
        <div class="row vertical ">
            <div class="col-md-6 col-md-offset-4 m-auto">
                <div class="col-md pb-2">
                    <a class="col-md navbar-brand logo p-0 text-primary" href="index.php">ComputersOnly</a>
                </div>
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="h4 text-gray-900">Criar uma conta!</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="submitUserForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <div id="add-user-messages"></div>

                            <div class="p-4">
                                <form class="user">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control" id="name" placeholder="Nome" name="name" autocomplete="off" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="surname" placeholder="Apelido" name="surname" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="uemail" placeholder="Email" name="uemail" autocomplete="off" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" id="upassword" placeholder="Senha" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="cpassword" placeholder="Repetir a senha" required>
                                        </div>
                                    </div>
                                    <!-- user type >>> 1 - Funcionario -->
                                    <input type="text" name="" hidden="true" id="type" value="2">

                                    <button type="submit" id="createUserBtn" class="btn btn-success btn-user btn-block" data-loading-text="Loading...">Registar conta</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="forgot-password.html">Esqueceu senha?</a>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <a href="sign-in.php" id="back" class="font-weight-light">
                                            <label class="text-muted">Ja tem uma conta?</label>
                                            <i class="fas fa-sign-in-alt"></i> 
                                            Fazer Login
                                        </a>
                                    </div>
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
    <script src="custom/js/user.js"></script>
</body>
</html>