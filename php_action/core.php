<?php 
session_start();

require_once 'db_connect.php';
require_once 'ctrl_functions_general.php';
require_once 'init.php';

if(isset($_SESSION['userType']) && $_SESSION['userType'] != 1) {
	header('location: eStore/home.php');	
}
?>