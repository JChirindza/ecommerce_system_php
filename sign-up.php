<?php 
require_once 'php_action/db_connect.php';

$lang = "en";
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}
require_once 'includes/Language/lang.' . $lang . '.php';

session_start();

if(isset($_SESSION['userId'])) {
    if ($_SESSION['userType'] == 1) {
        header('location: http://localhost/SistemaDeVendas_ControleDeStock/dashboard.php'); 
    }else{
        header('location: http://localhost/SistemaDeVendas_ControleDeStock/index.php'); 
    }
}

$errors = array();

if($_POST) {    

    $name       = $_POST['name'];
    $surname    = $_POST['surname'];
    $uemail     = strtolower($_POST['uemail']);
    $upassword  = $_POST['upassword'];
    $cpassword  = $_POST['cpassword'];
    $url        = '../assests/images/photo_default.png';
    
    // check if email exists
    $sql1       = "SELECT * FROM users WHERE email = '$uemail' AND active != 2";
    $query1     = $connect->query($sql1);
    $count      = $query1->num_rows;
    
    if ($count == 0) {
        if($upassword == $cpassword) {

            $sql = "INSERT INTO users (name, surname, email, password, user_image, type, permittion, active, status) 
            VALUES ('$name', '$surname', '$uemail', md5('$upassword'), '$url', 2, 0, 1, 1)";

            if($connect->query($sql) === TRUE) {
                $user_id = $connect->insert_id;
                // echo "New record created successfully. Last inserted ID is: " . $userId;

                // set session
                $_SESSION['userId'] = $user_id;
                $_SESSION['userType'] = 2;

                $errors[] = "Successfully Added"; 

                header('location: http://localhost/SistemaDeVendas_ControleDeStock/index.php'); 

            } else {
                $errors[] = "Error while adding the members";
            }
        } else {
            $errors[] = "New password does not match with Conform password";
        }
    } else {
        $errors[] = "Existing email, please type another one!";
    }
} // if in_array        
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
<body>
    <div class="container">
        <div class="row vertical ">
            <div class="col-md-6 col-md-offset-4 m-auto">
                <div class="col-md pb-2">
                    <a class="col-md navbar-brand logo p-0 text-primary" href="index.php">ComputersOnly</a>
                </div>
                <div class="card">
                    <div class="card-header text-center bg-white">
                        <h4 class="h4 text-gray-900"><?php echo $language['create-account'] ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="submitUserForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

                            <!-- <div id="add-user-messages"></div> -->

                            <div class="messages">
                                <?php if($errors) {
                                    foreach ($errors as $key => $value) {
                                        echo '<div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        '.$value.'</div>';                                      
                                    }
                                } ?>
                            </div>

                            <div class="p-4">
                                <form class="user">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control" id="name" placeholder="<?php echo $language['name'] ?>" name="name" autocomplete="off" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="surname" placeholder="<?php echo $language['surname'] ?>" name="surname" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="uemail" placeholder="<?php echo $language['email'] ?>" name="uemail" autocomplete="off" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="upassword" id="upassword" placeholder="<?php echo $language['password'] ?>" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="cpassword" id="cpassword" placeholder="<?php echo $language['confirm-password'] ?>" required>
                                        </div>
                                    </div>
                                    <button type="submit" id="createUserBtn" class="btn btn-success btn-user btn-block" data-loading-text="Loading..."><?php echo $language['register-account'] ?></button>
                                </form>
                                <hr>
                                
                                <div class="row mt-4">
                                    <div class="col-sm-12 text-center">
                                        <a href="sign-in.php" id="back" class="font-weight-light">
                                            <label class="text-muted"><?php echo $language['already-have-account'] ?>?</label>
                                            <i class="fas fa-sign-in-alt"></i> 
                                            <?php echo $language['sign-in'] ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="#"><?php echo $language['forgot-password'] ?>?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center p-4">
                    <label class="text-muted"><i class="fas fa-info-circle"></i> <?php echo $language['create-account-info-msg'] ?>.</label>

                </div>  
            </div>
        </div><!-- /row -->
    </div><!-- container -->  
</body>
</html>