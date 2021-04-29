</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashbored.php"><?php echo lang('homepage'); ?> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php"> <?php echo lang('category'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="items.php"> <?php echo lang('item'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member.php"> <?php echo lang('members'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php"> <?php echo lang('comments'); ?></a>
                </li>




            </ul>
            <ul class=" nav navbar-nav ml-auto">


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <?php echo  'Hallo ' . $_SESSION['Username']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../index.php">Visit Shop </a>
                        <a class="dropdown-item" href="member.php?do=edit&userid=<?php echo $_SESSION['ID']; ?>">Edit
                            profile</a>
                        <a class="dropdown-item" href="logout.php">Logout </a>

                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>