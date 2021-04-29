<?php
    include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
// check if user coming from http request
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashpaa = sha1($password);
//check if the user exist in data 
$stmt =$conn->prepare("Select userID ,UserName ,Password   From users WHERE UserName = ? AND Password = ? AND GroupID = 1 LIMIT 1");
$stmt->execute(array($username,  $hashpaa));
$row = $stmt->fetch();
$count=$stmt->rowCount();
/*echo $count;*/

// if count >0 this mean the database contain record this username 
if($count > 0)
{
    $_SESSION['Username'] = $username;
    $_SESSION['ID']= $row['userID'];
  

    header('location:dashbored.php');
    exit();
    
}
}

?>
