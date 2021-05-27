<?php 

session_start();

require_once 'db_connect.php';

// echo $_SESSION['userId'];

if(isset($_SESSION['userType']) && $_SESSION['userType'] != 1) {
	header('location: http://localhost/SistemaDeVendas_ControleDeStock/index.php');	
} 



?>