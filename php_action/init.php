<?php  
// Multi-lingual

// Valid Lang only => en/pt
$sys['langs'] = array(
    'en' => 'English',
    'pt' => 'Português',
);

$lang = 'en';
if (isset($_SESSION['lang'])) {
	$lang = Sys_Secure($_SESSION['lang']);
}

if (isset($_COOKIE['lang'])) {
	$lang = Sys_Secure($_COOKIE['lang']);
}

// Check if GET lang value is valid.
if (isset($_GET['lang'])) {

	if (array_key_exists(strtolower($_GET['lang']), $sys['langs'])) {
		$lang = Sys_Secure($_GET['lang']);

		$cookie_name = "lang";
		$cookie_value = strtolower($lang);
	    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
}

$filename = 'includes/language/lang.'.$lang.'.php';

// Check if concatenated path exists
if (file_exists($filename)) {
	$filename = 'includes/language/lang.'.$lang.'.php';
}else{
	// Default lang - english
	$filename = 'includes/language/lang.en.php';
}
require_once "{$filename}";
// /Multi-lingual

?>
