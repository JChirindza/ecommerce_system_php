<?php  
// Multi-lingual
$lang = 'en';
if (isset($_SESSION['lang'])) {
	$lang = Sys_Secure($_SESSION['lang']);
}
if (isset($_COOKIE['lang'])) {
	$lang = Sys_Secure($_COOKIE['lang']);
}
if (isset($_GET['lang'])) {
	$lang = Sys_Secure($_GET['lang']);
}
require_once 'includes/language/lang.' . $lang . '.php';
// /Multi-lingual


?>
