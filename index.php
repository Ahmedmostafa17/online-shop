<?php
session_start();
$pageTitle = 'HomePage';
require_once 'init.php';

?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="layout/images/6.png" class="d-block w-100" alt="image">
        </div>
        <div class="carousel-item">
            <img src="layout/images/7.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="layout/images/4.png" class="d-block w-100" alt="...">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<hr>
<?php

$getItems = $conn->prepare("SELECT * FROM items  WHERE Approve= 1");
$getItems->execute();
$cates = $getItems->fetchAll();
$count = $getItems->rowCount();

if ($count > 0) { ?>
<div class="back">
    <div class="container mb-5  mt-2">

        <div class="row ">

            <?php foreach ($cates as $item) { ?>


            <div class="col-sm-6 col-md-3 mt-2   box ">
                <div class="thumbnail items">
                    <span class="price"> $ <?php echo $item['price'] ?></span>
                    <?php echo "<img  class='zoom img-responsive img-thumbnail1 img-circle' src='admin/uploads/items/" . $item['image'] . " '/> ";
                            ?>
                    <div class=" text-center caption">
                        <a href="item.php?itemID=<?php echo  $item['itemID'] ?> "> <?php echo $item['Name'] ?></a>
                        <p> <?php
                                    if (strlen($item['Description']) > 100) {
                                        echo substr($item['Description'], 0, 10);
                                    } else {
                                    }
                                    echo $item['Description'];



                                    ?></p>
                        <div class="date"> <?php echo $item['Add_Date'] ?> </div>

                    </div>

                </div>

            </div>



            <?php }
            } ?>
        </div>
    </div>
</div>


<?php require_once $temp . 'footer.php'; ?>