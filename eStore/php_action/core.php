<?php 
session_start();

require_once '../php_action/db_connect.php';
require_once '../php_action/ctrl_functions_general.php';
require_once '../php_action/init.php';

if(isset($_SESSION['userType']) && $_SESSION['userType'] != 2) {
	header('location: ../dashboard.php');
}
?>