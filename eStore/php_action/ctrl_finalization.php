<?php  
require_once 'db_connect.php';
require_once '../../php_action/ctrl_functions_general.php';
session_start();
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'pay':
		payment();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}

function payment(){
	global $connect;

	if($_POST) {


	}
}