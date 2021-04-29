<?php


$temp = "include/templets/";
$language = "include/language/";
$css = "layout/css/";
$js="layout/js/";
$func = "include/functions/";
$image= "layout/images/";





// important files
require_once $func.'function.php';

require_once $language.'english.php';

require_once $temp.'header.php';
require_once 'connect.php';



// handling login 

 // include navbar in all pages exept the page has noNavbar 
 if(!isset($noNavbar))

 {
   require_once $temp .'navbar.php';

 }

?>



