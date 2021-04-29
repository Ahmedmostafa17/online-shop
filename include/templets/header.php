<?php require_once 'admin/connect.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">


</head>

<body>
    <nav>

        <nav class="navbar  navbar-expand-lg  mt-1">



            <?php

            if (isset($_SESSION['user'])) {
                $getuser = $conn->prepare('SELECT *FROM users WHERE UserName= ?');
                $getuser->execute(array($sessionUser));
                $info = $getuser->fetch();

                echo '<div class="container-fluid my-image">';
                if (empty($info['image'])) {
                    echo "<img  class='user-img img-thumbnail img-circle' src='admin/uploads/image/user.png '/> ";
                } else {
                    echo "<img  class='user-img img-thumbnail img-circle' src='uploads/image-users/" . $info['image'] . " '/> ";
                }

                echo '</div>';
            }

            ?>









            <?php

            if (isset($_SESSION['user'])) { ?>




            <div>



            </div>


            <div class="dropdown mr-5">

                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $sessionUser ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink mr-2">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="addItem.php">New Item</a>
                    <a class="dropdown-item" href="logout.php">Logout </a>
                </div>
            </div>


            </div>

            <?php } else {


            ?>
            <div class="m-2">
                <a class="loginandsign text-uppercase" href="login.php">

                    <span>login/Register</span>

                </a>
            </div>

            <?php } ?>
            </div>

        </nav>



        <nav class="navbar navbar-nav   navbar-expand-lg   ">

            <div class="container-fluid">
                <a class="logo-link" href="index.php"> <img class="logo" src="layout/images/logo.png">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php"><?php echo lang('homepage'); ?> </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <?php
                        $categories = getCats();

                        foreach ($categories as $show) {

                            echo '<li class="nav-item"><a class="nav-link"  href="categories.php?pageID=' . $show['CateID'] . '">' . $show['Name'] . ' </a></li>';

                            // echo  '<div class="dropdown">';
                            // echo '<a class="  dropdown-toggle nav-link " href="categories.php?pageID=' . $show['CateID'] . '"  role="button" id="dropdownMenuLink" data-toggle="dropdown" ">
                            //  ' . $show['Name'] . '
                            // </a>';

                            // echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                            // $sub = getSubCat($show['CateID']);
                            // foreach ($sub as $subShow) {
                            //     echo '<a class="dropdown-item" href="categories.php?pageID=' . $show['CateID'] . '">' . $subShow['Name'] . '</a>';
                            // }
                            // echo '</div>';
                            // echo '</div>';
                        }









                        ?>

                    </ul>



                </div>
        </nav>