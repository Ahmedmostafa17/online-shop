<?php

$dns = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pass = '';
$options= array(

PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',// علشان يدعم عربي 


);
try{

$conn = new PDO($dns,$user,$pass,$options);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*
$q= "INSERT INTO users ( UserName, `Password`, `Email` ) VALUES ( 'mostafa  ', 'sssss', 'sasa@yahaaa') ";
$conn->exec($q);
*/
}
catch(PDOException $e){

echo ' filed'. $e->getMessage();

}






?>