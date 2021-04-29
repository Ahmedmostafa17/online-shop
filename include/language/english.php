<?php


function lang($phrase)

{

static $lang = array(

// Navbar Links
    'homepage'  =>'Home',
    'category'  => 'Category',
    'item'      =>'Items',
    'members'    =>'Members',
    'comments'    =>'Comments',
    'statistics' =>'Statistics',
    'logs'         =>'Logs'
);
return $lang[$phrase];

}


?>