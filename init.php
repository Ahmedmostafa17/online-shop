<?php

//Errors  Reporting

ini_set('display_errors','On');
error_reporting('E_ALL');

//

$sessionUser = ' ';
if(isset($_SESSION['user']))
{
    $sessionUser = $_SESSION['user'];
}
// Routes

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

require_once 'admin/connect.php';

  

// handling login 


?>



