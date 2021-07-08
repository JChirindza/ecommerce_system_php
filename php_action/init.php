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

	$cookie_name = "lang";
	$cookie_value = $lang;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}
require_once 'includes/language/lang.' . $lang . '.php';
// /Multi-lingual

?>
