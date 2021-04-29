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

    $stmt = $conn->prepare("SELECT comments.* ,items.Name AS item_Name ,users.UserName 
    from comments 
    INNER JOIN items on itemID = comments.item_ID
    INNER JOIN users ON userID = comments.member_ID 
    
    ORDER BY comment_ID DESC 
    "); 

    //execute
    $stmt->execute();
    //Assign to Variable
    $row = $stmt->fetchAll();
    if(!empty($row))
    {

    ?>
                    
    <div class="container-fluid">
     <div class="row">
 
         <div class="col-lg-12 col-md-10  col-sm-6  mt-4">
 
             <div class="card ">
                 <h5 class="card-header text-center">Manage Comments</h5>
                 <div class="card-body">
                 <!--  <input type="text" class="form-control w-25 float-right mt-3 mb-3" placeholder="Search" id='SearchInput'>-->
                 <div class="col-lg-12 col-md-10  col-sm-10  ">
                     <table class="table text-center table-bordered "  >   
                         <thead class="thead-dark">
                             <tr>
                                 <th>#ID</th>
                                 <th>Comment </th>
                                 <th>Item Name</th>
                                 <th>User Nmae</th>
                                 <th>Add_Date </th>
                                 <th>Control </th>
 
                             </tr>
                         </thead>
                         <tbody>
 
                             <?php
 
                                         foreach($row as $show){
 
                                         echo "<tr> ";
                                         echo "<td> " .$show['comment_ID'];   " </td>";
                                         echo "<td> " .$show['comment']; " </td>";
                    
                                         echo "<td> " .$show['item_Name'];     " </td>";
                                         echo "<td> " .$show['UserName'];  " </td>";
                                         echo "<td> " .$show['comment_date'];  " </td>";
                                        
                                          echo "<td>    
                                           
                                          <a href='comments.php?do=edit&commentid=".$show['comment_ID'] ."'class='btn btn-success mt-1'> <i class='fa fa-edit'></i>Edit</a>
                                          <a href='comments.php?do=delete&commentid=".$show['comment_ID'] ."'class=' confirm btn btn-danger mt-1'><i class='fa fa-trash '></i>Delete</a>";
 
                                          if($show['status'] ==0)
                                          {
                                           echo "<a href='comments.php?do=approve&commentid=".$show['comment_ID'] ."'class=' btn btn-info py-1 mt-1 ml-1'><i class='fa fa-check '></i>Active</a>";

                                         }                         
 
                                              echo "</td>";
 
                                         echo "</tr> ";
 
                                         }
                                         ?>
 
                         </tbody>
                     </table>
                   </div>
                 </div>
 
             </div>
     </div>
</div>
  <?php }
  
  
  else
  {

    echo '<div class="container">';
      
      echo "<div class='nice-message    '> There's No Record</div>";
      
      
      echo '</div>';
  }

  ?>
 
 <?php }

elseif($do == 'edit')

{

    $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
            $stmt =$conn->prepare("SELECT  * From comments WHERE comment_ID = ? ");
        $stmt->execute(array($commentid));
        $row = $stmt->fetch(); 
   if($stmt->rowCount() > 0 ) { ?>




        <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 mt-4 ">
                        <div class="card ">
                            <div class="card-header bg-dark text-white text-center font-weight-bold ">
                                Update  Comment
                            </div>
                            <div class="card-body  " >
                    
                    
                        <form action="comments.php?do=update" method='POST'>
                        <input type="hidden" name="comment_ID" value ="<?php echo $commentid ?>" />

                            <div id="error1" class="  "></div> 
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Name:</label>
                                <input type="text" class="form-control  " name="comment" id="comment"  autocomplete='off' placeholder="Comment"  required  value ="<?php echo $row['comment']?>">
                            </div>
                            <!--End falied-->
                            
                            </div>
                            <!--End falied-->

                                                        
                            <button type="submit" class="btn btn-info w-100 mt-1">Update Comment</button>

                        </form>
                     
                    </div>

                   
                </div>

            </div>

        </div>
    </div>





  <?php }

   else
   {
    echo '<div class="container mt-3">';
    $Msg="<div class='alert alert-danger'>THERE NO such ID  </div>";
    redirectHome($Msg,2);
    echo '</div>';

   }




}
elseif($do== 'update')
{

if($_SERVER['REQUEST_METHOD'] =='POST')
{

$comment_ID = $_POST['comment_ID'];
$comment = $_POST['comment'];
$formerror=array();
if(empty($comment))
$formerror[]='please full the comment filed';

foreach($formerror as $error)
{
    echo '<div class="alert alert-dangee">'.$error.'</div>';
}

if(empty($formerror)){


    $stmt = $conn-> prepare(" UPDATE  comments  set  `comment` = ? WHERE comment_ID = ? ");
    $stmt->execute(array($comment, $comment_ID));
    echo '<div class="container mt-3">';
    $msg = '<div class ="alert alert-success">'.$stmt-> rowCount().
    'Record update Sccesfully </div>';

    redirectHome($msg, 'back', 1);
    echo '</div>';
}
}
else
{
    echo '<div class="container mt-3">';
    $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
    redirectHome($Msg, 1);
    echo '</div>';
}

}
elseif($do=='delete')
{

    echo '<h1 class="text-center">Delete Comments</h1>';

    $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
    $check = checkItem('comment_ID', 'comments', $commentid );
    
    if ($check > 0) {
    
        $stmt = $conn->prepare('DELETE FROM comments WHERE comment_ID = :comment');
        $stmt->bindParam(':comment', $commentid);
        $stmt->execute();
        echo '<div class="container mt-3">';
        $msg = '<div class= "alert alert-success">'.$stmt->rowCount().
        'Deleated Successfully</div>';
    
        redirectHome($msg, 'back', 1);
        echo '</di>';
    } else {
        echo '<div class="container mt-3">';
        $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';
    
        redirectHome($msg, 1);
        echo '</di>';
    
    }
}
elseif($do =='approve')
{
    echo '<h1 class="text-center">Activate Member</h1>';
    
    $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
    $check = checkItem('comment_ID', 'comments', $commentid);

    if ($check > 0) {

        $stmt = $conn->prepare('UPDATE comments SET `status` =1 WHERE comment_ID= ?');

        $stmt->execute(array($commentid));
        echo '<div class="container mt-3">';
        $msg = '<div class= "alert alert-success">'.$stmt->rowCount().
        'Activate Successfully</div>';

        redirectHome($msg, 'back', 1);
        echo '</di>';
    } else {
        echo '<div class="container mt-3">';
        $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';

        redirectHome($msg, 1);
        echo '</di>';

    }
}

include $temp.'footer.php';
}
else {
    
    header('location:index.php');
    exit();
}
ob_end_flush();
?>
