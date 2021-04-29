<?php 
session_start();
$noNavbar = ' ';
$pageTitle = 'Login';
if(isset($_SESSION['Username']))  // sessions
{
    header('location:dashbored.php');
}
require_once 'connect.php';
require_once 'init.php';
require_once 'handling/loginHand.php';



/*
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashpaa = sha1($password);
    echo $username . ' ' . $hashpaa;
}
*/

?>



<section>
    <div class="container-fluid">
            <div class="row">

         <div class="back">
    
  
   


         <div class="offset-md-6 col-lg-5 col-md-7 col-sm-12 col-xs-12  mt-5 ">
                

                <div class="card w-75 admin  ">
                
                <div class="card-head "> 
         
                <img class="pic" src="<?php echo $image?>admin.png">
                </div>
                
                <div class="card-body login  ">
                
                             <form   action ="<?php echo $_SERVER['PHP_SELF'] ;?>"  method ="POST" >
                                     
                                     <div class="form-group">
                                         <label >User Name</label>
                                     <input  class="form-control  "type="text" name="user" placeholder="User Name " autocomplete="off" />
         
                                     </div>
                                     <div class="form-group">
                                     <label >Password</label>
                                     <input  class="form-control "type="password" name="pass"  placeholder="Password "autocomplete="new-password"/>
                                     </div>
                                     <div class="form-group">
                                     
                                     <input class="btn btn-primary w-100 " type="submit" value="Login"/>
         
                                     </div>
                         
         
                                     </div>
                                 
                         </form>
               
               
                
                
                
                   </div>
                   </div>
                     </div>


</div>

   </div>




   </div>
    
    


</section>





<?php 

require_once $temp.'footer.php';
?>