<?php  

function Sys_Secure($string, $censored_words = 1, $br = true, $strip = 0) {
    
    $localhost = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loja";

    // db connection
    $connect = new mysqli($localhost, $username, $password, $dbname);

    $string = trim($string);
    $string = cleanString($string);
    $string = mysqli_real_escape_string($connect, $string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    if ($br == true) {
        $string = str_replace('\r\n', " <br>", $string);
        $string = str_replace('\n\r', " <br>", $string);
        $string = str_replace('\r', " <br>", $string);
        $string = str_replace('\n', " <br>", $string);
    } else {
        $string = str_replace('\r\n', "", $string);
        $string = str_replace('\n\r', "", $string);
        $string = str_replace('\r', "", $string);
        $string = str_replace('\n', "", $string);
    }
    if ($strip == 1) {
        $string = stripslashes($string);
    }
    return $string;
}

function cleanString($string) {
    return $string = preg_replace("/&#?[a-z0-9]+;/i","", $string); 
}

function Sys_Redirect($url) {
    return header("Location: {$url}");
}

?>