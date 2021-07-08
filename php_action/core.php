<?php 
session_start();

require_once 'db_connect.php';
require_once 'ctrl_functions_general.php';

if(isset($_SESSION['userType']) && $_SESSION['userType'] != 1) {
	header('location: http://localhost/SistemaDeVendas_ControleDeStock/index.php');	
} 
?>