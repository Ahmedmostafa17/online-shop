<?php
session_start();
$pageTitle = 'Profile';
require_once 'init.php';

if (isset($_SESSION['user'])) {
        $getuser = $conn->prepare('SELECT *FROM users WHERE UserName= ?');
        $getuser->execute(array($sessionUser));
        $info = $getuser->fetch();


?>
<div class="container">
    <h1 class="text-center"> <?php echo $sessionUser ?> Profile </h1>
    <div class="row">
        <div class="col-md-7 offset-md-3">


            <div class="card mt-3">
                <div class="card-header card-primary">
                    Information
                </div>
                <div class="card-body information">
                    <ul class="list-unstyled">

                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name</span>: <?php echo $info['UserName']; ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>FullName</span>: <?php echo $info['FullName']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email</span>: <?php echo $info['Email']; ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Register Date</span>: <?php echo $info['Date']; ?>
                        </li>




                        <?php

                                                        echo "<a href='update.php?do=edit&userid=" . $info['userID'] . "'class='btn btn-success mt-1'> <i class='fa fa-edit'></i>Edit</a>";

                                                        ?>
                    </ul>





                </div>
            </div>
        </div>
        <div class=" col-md-7 offset-md-3">


            <div class="card mt-2">
                <div class="card-header card-primary">
                    Latest Add
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $items = getitems('Member_ID', $info['userID']);
                                                        if (!empty($items)) {

                                                                foreach ($items as $item) {

                                                                        echo '<div class="col-sm-6 col-md-4 mr-2 mt-2 box">';
                                                                        echo '<div class="thumbnail items">';

                                                                        echo '<span class="price ">$' . $item['price'] . '</span>';

                                                                        echo "<img  class='item-img  img-circle' src='admin/uploads/items/" . $item['image'] . " '/> ";

                                                                        echo '<div class="  caption">';
                                                                        echo '<a  class=" ahmed" href="item.php?itemID=' . $item['itemID'] . '">' . $item['Name'] . '</a>';
                                                                        echo '<p>' . $item['Description'] . '</p>';
                                                                        echo '<div class="date my-date"> ' . $item['Add_Date'] . '</div>';
                                                                        if ($item['Approve'] == 0) {
                                                                                echo '<div class=" pinding alert alert-danger"> Item Pending </div>';
                                                                        }

                                                                        echo '</div>';

                                                                        echo '</div>';

                                                                        echo '</div>';
                                                                }
                                                        } else {
                                                                echo '<div class=" alert alert-warning   w-100">Sorry No Add To Show  </div>';
                                                        }


                                                        ?>


                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-7 offset-md-3">


            <div class="card mt-2 mb-3">
                <div class="card-header card-primary">
                    Latest Comment
                </div>
                <div class="card-body">

                    <?php
                                                $stmt = $conn->prepare("SELECT comment from comments WHERE member_ID = ?");

                                                //execute
                                                $stmt->execute(array($info['userID']));
                                                //Assign to Variable
                                                $comments = $stmt->fetchAll();
                                                if (!empty($comments)) {
                                                        foreach ($comments as $comment)
                                                                echo '<p> ' . $comment['comment'] . '</p>';
                                                } else {
                                                        echo '<div class=" alert alert-warning  w-100">There is No Comments Show </div>';
                                                }


                                                ?>
                </div>


            </div>
        </div>
    </div>
</div>

<?php } else {
        header('loation:login.php');
        exit();
}
?>
<?php require_once $temp . 'footer.php';
?>