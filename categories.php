<?php session_start(); ?>
<?php require_once 'init.php';

?>

<?php $pageTitle = 'Category'; ?>

<div class="container">
    <h1 class="text-center"> <?php echo str_replace('-', ' ', $_GET['pagename']) ?></h1>
    <div class="row">

        <?php

      $catID = isset($_GET['pageID']) && is_numeric($_GET['pageID']) ? intval($_GET['pageID']) : 0;
      $getCat = $conn->prepare("SELECT * FROM items Where Category_ID = ? and Approve=1  ");
      $getCat->execute(array($catID));
      $cates = $getCat->fetchAll();
      $count = $getCat->rowCount();

      if ($count > 0) {
         foreach ($cates as $item) {

            echo '<div class="col-sm-6 col-md-3  box">';
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
         $msg = '<div class="alert alert-danger">No Items';
         redirectHome($msg, 'back', 1);
         echo '</div>';
      }

      ?>



    </div>
</div>

<?php require_once $temp . 'footer.php'; ?>