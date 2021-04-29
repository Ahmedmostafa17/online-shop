<?php session_start(); ?>
<?php require_once 'init.php';

?>

<?php $pageTitle = 'Category'; ?>

<div class="container">
    <h1 class="text-center"> <?php ?></h1>
    <div class="row">

        <?php

        if (isset($_GET['name']))
            $tage = $_GET['name'];
        //  echo  '<h1 class="text-center">' . str_replace('-', ' ', $_GET['name']) . '</h1>';
        $getTags = $conn->prepare("SELECT * FROM items where tags like '%$tage%'   ");

        $getTags->execute();
        $tages = $getTags->fetchAll();
        $count = $getTags->rowCount();
        if ($count > 0) {
            foreach ($tages as $item) {

                echo '<div class="col-sm-6 col-md-3 mr-3 box">';
                echo '<div class="thumbnail items">';
                echo '<span class="price">$' . $item['price'] . '</span>';
                echo "<img  class='zoom img-responsive img-thumbnail1 img-circle' src='admin/uploads/items/" . $item['image'] . " '/> ";
                echo '<div class=" text-center caption">';
                echo '<a href="item.php?itemID=' . $item['itemID'] . '">' . $item['Name'] . '</a>';
                echo '<p>' . $item['Description'] . '</p>';
                echo '<div class="date"> ' . $item['Add_Date'] . '</div>';

                echo '</div>';

                echo '</div>';

                echo '</div>';
            }
        } else {
            $msg = '<div class="  alert alert-danger">No Items</div>';
            echo '<div>';
            redirectHome($msg, 'back', 1);
            echo '</div>';
        }

        ?>



    </div>
</div>

<?php require_once $temp . 'footer.php'; ?>