

<?php
ob_start();

session_start();
if(isset($_SESSION['Username']))

{

    $pageTitle = 'Admin Dashbored';
     include 'connect.php';
    include 'init.php';

    ?>

<div class="container">
  <h1 class="text-center mt-3 font-weight-bold"> Admin Dashbored</h1>
    <div class="row mt-4">

            
                <div class="col-lg-3  col-md-4 col-sm-6">
                    <div class="card p-4 t-members state" >
                                <div class="row no-gutters">
                                    <div class="col-lg-7 text-center">
                                        <h5>Total Members</h5>
                                        <a href="member.php"><span class="num"><?php echo CountMember('userID' ,'users');?></span></a>  
                                            </div>
                                            <div class="col-lg-5">
                                            <div class="card-body">
                                            <i class="fa fa-users icon"></i>

                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
          
            <div class="col-lg-3  col-md-4 col-sm-6">
               <div class="card p-4 pending state" >
                        <div class="row no-gutters">
                            <div class="col-lg-7 text-center">
                            <h5>Total Pending</h5>
                           <a href="member.php?do=manage&page=pending"><span class="num"><?php echo  contPendingItem('userID' ,'users')?></span></a> 
                                    </div>
                                    <div class="col-lg-5">
                                    <div class="card-body">
                                    <i class="fa fa-user-plus icon"></i>

                                    </div>
                        </div>
                        </div>
                </div>
            </div>
    
        <div class="col-lg-3  col-md-4 col-sm-6">
               <div class="card p-4 t-item state" >
                        <div class="row no-gutters">
                            <div class="col-lg-7 text-center">
                            <h5>Total Items</h5>
                            <a href="items.php"><span class="num"><?php echo contItem('itemID' ,'items');?></span></a>  
                                    </div>
                                    <div class="col-lg-5">
                                    <div class="card-body">
                                    <i class="fa fa-tag icon"></i>

                                    </div>
                        </div>
                        </div>
                </div>
       </div>
            
      <div class="col-lg-3  col-md-4 col-sm-6">
               <div class="card p-4 t-comments state" >
                        <div class="row no-gutters">
                            <div class="col-lg-7 text-center">
                            <h5>Total Comments</h5>
                            <a href="comments.php"><span class="num"><?php echo contItem('comment_ID' ,'comments');?></span></a>  
                                    </div>
                                    <div class="col-lg-5">
                                    <div class="card-body">
                                    <i class="fa fa-comments icon"></i>

                                    </div>
                        </div>
                        </div>
                </div>
     </div>




    </div>

     <div class="row mt-3">


                <div class="col-md-6 col-sm-3">
                        <?php $latestNum = 4?>
                        <div class="card">
                        <div class="card-header">
                        <h5 class="d-inline"><i class="fa fa-users"></i>  Lastest <?php echo $latestNum?> Registered Users</h5>

                        <span class=" toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                        </span>
                        </div>
                        <div class="card-body">
                                <ul class="list-unstyled lasted-user">
                                <?php
                                 $latest =  latestMember('*','users','userID', $latestNum) ;
                                if(!empty($latest))
                                {

                                  foreach($latest as $user)
                                  {
                                    echo '<li>';
                                  echo '<i class="fa fa-user"></i>'.' '.$user['UserName'];
                                  echo '<a href="member.php?do=edit&userid='.$user['userID']. '"<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit </span></a>';
                                  if($user['RegStatus'] == 0)
                                  {
                                    echo '<a href="member.php?do=activate&userid='.$user['userID'] . '"<span class="btn btn-info pull-right"><i class="fa fa-close"></i>Active  </span></a>';


                                  }
                                   

                                   echo '</li>';

                                  }
                                }
                                else
                                {

                                  echo '<div class="container">';
                                    
                                    echo "<div class='nice-message1'> There's No Record</div>";
                                    
                                    
                                    echo '</div>';
                                }
                             
                                
                                ?>     
                                </ul>   
                     </div>
                        </div>


                
                </div>


                <div class="col-md-6">
                <?php $latestNum = 3?>
                       <div class="card">

                       
                       <div class="card-header">
                        <h5 class="d-inline"><i class="fa fa-tags"></i>  Lastest <?php echo $latestNum?> Items</h5>
                        <span class=" toggle-info  pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                        </span>
                        </div>
                        <div class="card-body">
                        <ul class="list-unstyled lasted-user">
                                <?php
                                 $latest =  latestItem('*','items','itemID', $latestNum) ;
                                  if(!empty($latest))
                                  {
                                  foreach($latest as $item)
                                  {
                                    echo '<li>';
                                  echo '<i class="fa fa-user"></i>'.' '.$item['Name'];
                                 
                                  echo '<a href="items.php?do=edit&itemid='.$item['itemID']. '"<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit </span></a>';

                                  if($item['Approve'] ==0)
                                  {
                                    echo "<a href='items.php?do=approve&itemid=".$item['itemID'] ."'class=' btn btn-info pull-right'><i class='fa fa-check '></i>Approve</a>";

                                  }   

                                 

                                   echo '</li>';

                                  }
                                }
                                else
                                {

                                  echo '<div class="container">';
                                    
                                    echo "<div class='nice-message1'> There's No Record</div>";
                                    
                                    
                                    echo '</div>';
                                }
                             
                                
                                
                                ?>     
                                </ul> 
                           
                        </div>
                        </div>
                </div>

  </div>









  <div class="row mt-3">



<div class="col-md-6">
<?php $latestNum = 3?>
       <div class="card mb-5">

       
       <div class="card-header">
        <h5 class="d-inline"><i class="fa fa-comment-o"></i> Lastest Comments</h5>
        <span class=" toggle-info  pull-right">
        <i class="fa fa-plus fa-lg"></i>
        </span>
        </div>
        <div class="card-body">
 
                <?php
                $stmt = $conn->prepare("SELECT comments.* ,items.Name AS item_Name ,users.UserName 
                from comments 
                INNER JOIN items on itemID = comments.item_ID
                INNER JOIN users ON userID = comments.member_ID 
                ORDER BY comment_ID DESC 
                LIMIT $latestNum
                "); 
            
                //execute
                $stmt-> execute();
                //Assign to Variable
                $row = $stmt->fetchAll();
            if(!empty( $row)){
                foreach($row as $comment)
                {
                echo '<div class="comment-box">';
                echo '<span class="member-n ">'.$comment['UserName'].'</span>';
                echo '<p class="member-c ">'.$comment['comment'].'</p>';


                  
                echo '</div>';
                }

              }
              else
              {

                echo '<div class="container">';
                  
                  echo "<div class='nice-message1'> There's No Record</div>";
                  
                  
                  echo '</div>';
              }
           
                ?>    
               
             
        </div>
        </div>
</div>

</div>



</div>































<?php 
    include $temp.'footer.php';


}
else
{
    header('location:index.php');
    exit();

}
ob_end_flush();

?>

