<?php 

session_start();

require_once 'db_connect.php';

// echo $_SESSION['userId'];

if($_SESSION['userType'] != 1) {
	header('location: ../SistemaDeVendas_ControleDeStock/index.php');	
} 



?>