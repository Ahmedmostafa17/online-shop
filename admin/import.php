<?php


require_once 'connect.php';

require_once 'include/functions/function.php';
if (isset($_FILES['uploadedfile'])) {   

    // get the csv file and open it up
    $file = $_FILES['uploadedfile']['tmp_name']; 
    $handle = fopen($file, "r"); 
    try { 
        // prepare for insertion
        $query_ip =$conn->prepare('INSERT INTO users ( UserName, `Password`, Email, FullName ,`Date`) VALUES
         ( :user, :pass, :full, :email, now())');                                         
        $data = fgetcsv($handle,1000,",","'");
        $query_ip->execute(array('user'=>$data[0],'pass'=>$data[1],'full'=>$data[2],'email'=>$data[3]));
        $count = $query_ip->rowCount(); 
        fclose($handle);

    } catch(PDOException $e) {
        die($e->getMessage());
    }       

    echo '<div class="container mt-3">';
    $msg = '<div class= "alert alert-success">'.$count.
    'Deleated Successfully</div>';

    redirectHome($msg, 'back', 1);
    echo '</di>';


} else {
    echo '<div class="container mt-3">';
    $msg = '<div class= "alert alert-danger">can not Import </div>';

    redirectHome($msg);
    echo '</di>';
}



?>