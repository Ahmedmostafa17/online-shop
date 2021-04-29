<?php
ob_start();
session_start();
$pageTitle= ' item';
if(isset($_SESSION['Username']))

{
    include 'connect.php';
include  'init.php';
$do = isset($_GET['do']) ? $_GET['do' ]: 'Manage' ;

if($do=='Manage')
{

    echo 'welcome';
}

include $temp.'footer.php';
}
else {
    
    header('location:index.php');
    exit();
}
ob_end_flush();
?>