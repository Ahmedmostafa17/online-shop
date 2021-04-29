<?php
session_start();
$pageTitle = 'Show Items';
require_once 'init.php';
$itemid = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
$stmt = $conn->prepare("SELECT  items.* , categories.Name  AS category_name ,users.UserName as member
From items  INNER JOIN categories on categories.CateID = items.Category_ID INNER JOIN users on users.userID = Member_ID WHERE itemID = ?  AND Approve =1");
$stmt->execute(array($itemid));
$item = $stmt->fetch();
$count = $stmt->rowCount();

if ($count > 0) {

?>
<div class="container show-items">
    <div class="row">

        <div class="col-md-5 mt-5 photo">
            <?php echo "<img  class='zoom  img-thumbnail2  ' src='admin/uploads/items/" . $item['image'] . " '/> ";
                ?>


        </div>
        <div class="col-md-7 item-info ">
            <h3 class="mt-3 "> <?php echo $item['Name']; ?></h3>
            <p><?php echo $item['Description']; ?></p>
            <ul class="list-unstyled">
                <li>
                    <span><i class="fa fa-money fa-fw"></i> $</span><?php echo $item['price']; ?>
                </li>
                <li>
                    <span><i class="fa fa-building fa-fw"></i>Made In:</span> <?php echo $item['Country_Made']; ?>
                </li>

                <li>
                    <span><i class="fa fa-calendar fa-fw"></i>Add_Date :</span> <?php echo $item['Add_Date']; ?>
                </li>
                <li>
                    <span><i class="fa fa-tags fa-fw"></i>Category:</span> <a
                        href="categories.php?pageID=<?php echo $item['Category_ID'] ?> "><?php echo $item['category_name']; ?></a>
                </li>
                <li>

                    <span><i class="fa fa-user fa-fw"></i><?php echo $item['member']; ?></span>
                </li>
                <li>

                    <span>Tage </span> :
                    <?php

                        $allTags = explode(',', $item['tags']);
                        if (empty($item['tags'])) {
                            echo '<p class="no-tags"> No Tags</p>';
                        } else {


                            foreach ($allTags as $tage) {
                                $tag = str_replace(' ', '', $tage);
                                $tag = strtolower($tag);
                                echo "<a  class='tages' href='tags.php?name={$tage}'>" . $tage . " </a>  ";
                            }
                        }


                        ?>
                </li>
            </ul>
        </div>

    </div>
    <hr class="custom-hr">
    <?php if (isset($_SESSION['user'])) { ?>

    <div class="row">

        <div class="col-md-6  comments">
            <h3 class=""> Review this product</h3>
            <p>Share your thoughts with other customers</p>
            <form action="<?PHP $_SERVER['PHP_SELF'] . '?itemID=' . $item['itemID']  ?>" method="POST">


                <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="3"
                    required></textarea>
                <button type="submit" class="btn btn-primary ml-3 "><i class="fa fa-plus">Add Review</i></button>

            </form>

        </div>

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
    </div>



    <?php } else {


            echo ' <div class="m-2">';
            echo ' <a class="loginandsign text-uppercase" href="login.php">';

            echo '<span>login/Register</span>';

            echo '</a>';
            echo '</div>';
        } ?>

    <hr class="custom-hr">
    <?php
        $stmt = $conn->prepare("SELECT comments.* , users.UserName    AS member
    from comments  INNER JOIN users ON userID = comments.member_ID WHERE item_ID = ? AND  `status` = 1

    ORDER BY comment_ID DESC 
    ");

        //execute
        $stmt->execute(array($item['itemID']));

        $comments = $stmt->fetchAll();






        ?>

    <?php

        foreach ($comments as $comment) { ?>

    <div class="comment-box">


        <div class="row">

            <div class="col-sm-2 text-center">
                <img class="img-thumbnail img-responsive img-circle" src="layout/images/ahmed.jpg" alt="" />
                <span> <?php echo $comment['member'] ?></span>

            </div>
            <div class="col-sm-10">
                <p> <?php echo $comment['comment'] ?></p>

            </div>

        </div>

    </div>
    <hr class="custom-hr ">
    <?php } ?>




    <?php } else {
    $msg = '<div class="alert alert-danger">No ID</div>';
    redirectHome($msg, 'back', 1);
    echo '</div>';
} ?>

    <?php require_once $temp . 'footer.php';
    ?>