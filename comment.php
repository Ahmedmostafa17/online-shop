<?php
session_start();
$pageTitle = 'Show Items';
require_once 'init.php';
$itemid = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
$stmt = $conn->prepare("SELECT  items.* , categories.Name  AS category_name ,users.UserName as member
From items  INNER JOIN categories on categories.CateID = items.Category_ID INNER JOIN users on users.userID = Member_ID WHERE itemID = ? ");
$stmt->execute(array($itemid));
$item = $stmt->fetch();
$count = $stmt->rowCount();

?>


        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
          $userid = $_SESSION['userID'];
          $itemid = $item['itemID'];


          if (!empty($comment)) {
            $stmt = $conn->prepare("INSERT INTO comments (comment,`status`,comment_date,item_ID,member_ID) 
        VALUES(:zcomment,0,now(),:zitem,:zmember)");
            $stmt->execute(array('zcomment' => $comment, 'zitem' => $itemid, 'zmember' => $userid));
          } else {
            echo '<div class="alert alert-danger"> You Must Add Cmment</div>';
          }
        }


        ?>



 


 


   
<?php require_once $temp . 'footer.php';
?>