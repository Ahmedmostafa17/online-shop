<?php
ob_start();
session_start();
$pageTitle = ' Category';
if (isset($_SESSION['Username'])) {
    require_once 'connect.php';
    require_once  'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if ($do == 'Manage') {
        $sort = 'ASC';
        $srot_array = array('ASC', 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $srot_array)) {
            $sort = $_GET['sort'];
        }
        $state = $conn->prepare("SELECT * FROM Categories  where parent=0 ORDER BY ordering  $sort");
        $state->execute();
        $cate = $state->fetchAll();

        if (!empty($cate)) {

?>
            <div class="container-fluid">


                <h1 class="text-center mt-3">Manage Categories</h1>
                <div class="ordering  ">Ordering :
                    <a class="<?php if ($sort == 'ASC') {
                                    echo 'active';
                                } ?>" href="?sort=ASC"> Asc</a>
                    <a class="<?php if ($sort == 'DESC') {
                                    echo 'active';
                                } ?>" href="?sort=DESC"> Desc</a>



                </div>
                <a href="categories.php?do=add" class="btn btn-primary m-2"><i class="fa fa-plus"></i>Add Category</a>

                <div class="row">

                    <div class="col-md-10">




                        <?php
                        foreach ($cate as $show) {
                            echo '<div class="card m-2">';
                            echo ' <div class="card-body cats">';

                            echo   '<div class="hidden-button">';

                            echo "<a href='categories.php?do=edit&catid=" . $show['CateID'] . "'class=' btn  mt-1 ml-1'><i class='fa fa-edit tex-success  fa-2x '></i></a>";
                            echo "<a href='categories.php?do=delete&catid=" . $show['CateID'] . "'class=' btn confirm mt-1 ml-1'><i class='fa fa-trash text-danger fa-2x '></i></a>";

                            echo '</div>';
                            echo '<h2>' . $show['Name'] . '</h2>';
                            echo '<p>' . $show['Description'] . '</p>';


                            if ($show['Visability'] == 0) {
                                echo '<span class="visability"> <i class= "fa fa-eye-slash ">Hidden</i></span>';
                            }
                            if ($show['Allow_comment'] == 0) {
                                echo '<span class="comment"> <i class= "fa fa-times">Comment Disable</i></span>';
                            }
                            if ($show['Allow_Ads'] == 0) {
                                echo '<span class="Advertiser"> <i class="fa fa-times ">Ads Disable</i></span>';
                            }
                            $state = $conn->prepare('SELECT * FROM Categories  where parent = ' . $show['CateID'] . '   ');
                            $state->execute();
                            $cates = $state->fetchAll();
                            if (!empty($cates)) {
                                echo '<h4> Child Category</h4>';
                                echo '<ul class="list-unstyled child-cate">';
                                foreach ($cates as $cat) {
                                    echo "<li class='child-link'>
                                     <a href='categories.php?do=edit&catid=" . $cat['CateID'] . "'   class=' btn  mt-1 ml-1'>" . $cat['Name'] . " </a>";
                                    echo "<a class='show-link' href='categories.php?do=delete&catid=" . $cat['CateID'] . "'class=' btn confirm mt-1 ml-1'><i class='fa fa-trash text-danger fa-2x '></i></a>";
                                    echo ' <li>';
                                }
                                echo '</ul>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }




                        ?>





                    </div>
                </div>
            </div>

        <?php } else {

            echo '<div class="container">';

            echo "<div class='nice-message'> There's No Record</div>";

            echo ' <a href="categories.php?do=add" class="btn btn-primary ml-4"><i class="fa fa-plus"></i>Add Category</a>
        ';

            echo '</div>';
        }
        ?>
    <?php   }
    /* */ elseif ($do == 'add') { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 mt-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white text-center font-weight-bold ">
                            Add Categories
                        </div>
                        <div class="card-body">
                            <form action="categories.php?do=insert" method='POST' onsubmit='return addCategoryValidations()'>
                                <div id="error1" class="  "></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Name:</label>
                                    <input type="text" class="form-control  " name="name" id="name" autocomplete='off' placeholder="Name of the category">

                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Description:</label>
                                    <textarea class="form-control" name="Descripted" id="Descripted" rows="3" placeholder="please Descripe the Category"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ordering </label>
                                    <input type="text" class="form-control" name="ordering" id="ordering" aria-describedby="emailHelp" placeholder="Number to Arrange the Category ">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Parent </label>
                                    <select class="form-control" name='parent'>
                                        <option value='0'> None</option>
                                        <?php
                                        $statment = $conn->prepare("SELECT * FROM categories  WHERE parent=0 ");
                                        $statment->execute(array($value));
                                        $cats = $statment->fetchAll();

                                        foreach ($cats as $cat) {

                                            echo "<option value='" . $cat['CateID'] . "'>" . $cat['Name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class=" ">
                                        Allow commenting
                                    </label>

                                    <div class="btn btn-secondary  ">
                                        <div class="d-inline check">
                                            <input id="vis-yes" type="radio" name="comment" value="0" />
                                            <label for="vis-yes">Yes</label>
                                        </div>
                                        <div class="d-inline check">
                                            <input id="vis-no" type="radio" name="comment" value="1" />
                                            <label for="vis-no">No</label>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-group">

                                    <label>
                                        Allow ADS
                                    </label>

                                    <div class="btn btn-secondary  ">
                                        <div class="d-inline">
                                            <input id="vis-yes1" type="radio" name="ads" value="0" />
                                            <label for="vis-yes1">Yes</label>
                                        </div>
                                        <div class="d-inline">
                                            <input id="vis-no1" type="radio" name="ads" value="1" />
                                            <label for="vis-no1">No</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">

                                    <label>
                                        Allow Visability
                                    </label>

                                    <div class="btn btn-secondary  ">
                                        <div class="d-inline">
                                            <input id="vis-yes2" type="radio" name="visabile" value="0" />
                                            <label for="vis-yes2">Yes</label>
                                        </div>
                                        <div class="d-inline">
                                            <input id="vis-no2" type="radio" name="visabile" value="1" />
                                            <label for="vis-no2">No</label>
                                        </div>

                                    </div>
                                </div>





                                <button type="submit" class="btn btn-info w-100 mt-1">Add Category</button>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php } elseif ($do == 'insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $Descripe = $_POST['Descripted'];
            $parent = $_POST['parent'];
            $ordering = $_POST['ordering'];
            $comment = $_POST['comment'];

            $ads = $_POST['ads'];
            $visable = $_POST['visabile'];

            $formError = array();
            if (empty($name)) {
                $formError[] = 'please full the Category Name ';
            }
            if (strlen($name) < 4) {
                $formError[] = 'please fullCaregory Name  more than 6 character';
            }
            if (empty($Descripe)) {
                $formError[] = 'please enter the fullname  ';
            }
            if (strlen($Descripe) < 6) {
                $formError[] = 'please full Descripe more than 6 character';
            }

            if (empty($ordering)) {
                $formError[] = 'please full the Ordering ';
            }

            foreach ($formError as $error) {
                echo '<div class="alert alert-danger">' . $error .
                    '</div>';
            }
            if (empty($formError)) {

                $check = checkItem('Name', 'Categories', $name);

                if ($check == 1) {
                    echo '<div class="container mt-3">';
                    $msg = '<div class="alert alert-success">Sorry The Category  is Here</div>';
                    redirectHome($msg, 'back', 2);
                    echo '</div>';
                } else {

                    //insert userinfo in database

                    $stmt = $conn->prepare("INSERT INTO 
                Categories(Name,Description,parent,Ordering,Visability,Allow_comment,Allow_Ads)
                VALUES(:name, :desc,:parent, :order, :visable,:comment, :ads)");
                    $stmt->execute(array('name' => $name, 'desc' => $Descripe, 'parent' => $parent, 'order' => $ordering, 'visable' => $visable, 'comment' => $comment, 'ads' => $ads));

                    echo '<div class="container">';
                    //echo success message
                    $msg = '<div class="alert alert-success">' . $stmt->rowCount() .
                        'Record Add</div>';
                    redirectHome($msg, 'back', 1);
                    echo '</div>';
                }
            }
        } else {

            echo '<div class="container mt-3">';
            $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
            redirectHome($Msg, 1);
            echo '</div>';
        }
    } elseif ($do == 'edit') {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $stmt = $conn->prepare("SELECT  * From categories WHERE CateID = ? ");
        $stmt->execute(array($catid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($stmt->rowCount() > 0) { ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 mt-4">
                        <div class="card">
                            <div class="card-header bg-dark text-white text-center font-weight-bold ">
                                Edit Categories
                            </div>
                            <div class="card-body">
                                <form action="categories.php?do=update" method='POST'>
                                    <input type="hidden" name="CateID" value="<?php echo $row['CateID'] ?>" />

                                    <div id="error1" class="  "></div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Name:</label>
                                        <input type="text" class="form-control  " name="name" id="name" placeholder="Name of the category" value="<?php echo $row['Name'] ?>">

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description:</label>
                                        <input type='text' class="form-control " name="Descripted" id="Descripted" rows="3" placeholder="please Descripe the Category" value="<?php echo $row['Description'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ordering </label>
                                        <input type="text" class="form-control" name="ordering" id="ordering" aria-describedby="emailHelp" placeholder="Number to Arrange the Category " value="<?php echo $row['Ordering'] ?>">
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Parent </label>
                                            <select class="form-control" name='parent'>
                                                <option value='0'> None</option>
                                                <?php
                                                $statment = $conn->prepare("SELECT * FROM categories  WHERE parent=0 ");
                                                $statment->execute(array($value));
                                                $cats = $statment->fetchAll();

                                                foreach ($cats as $c) {

                                                    echo "<option value='" . $c['CateID'] . "'";

                                                    if ($row['CateID'] =  $c['CateID']) {
                                                        echo 'selected';
                                                    }

                                                    echo ">" . $c['Name'] . "</option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <label>
                                            Allow commenting
                                        </label>
                                        <div class="btn btn-secondary  ">
                                            <div class="d-inline check">
                                                <input id="vis-yes" type="radio" name="comment" value="0" <?php if ($row['Allow_comment'] == 0) {
                                                                                                                echo 'checked';
                                                                                                            } ?> />
                                                <label for="vis-yes">Yes</label>
                                            </div>
                                            <div class="d-inline check">
                                                <input id="vis-no" type="radio" name="comment" id="option2" value="1" <?php if ($row['Allow_comment'] == 1) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                                <label for="vis-no">No</label>
                                            </div>

                                        </div>


                                        <div>
                                            <label>
                                                Allow ADS
                                            </label>

                                            <div class="btn btn-secondary  ">
                                                <div class="d-inline">
                                                    <input id="vis-yes" type="radio" name="ads" value="0" <?php if ($row['Allow_Ads'] == 0) {
                                                                                                                echo 'checked';
                                                                                                            } ?> />
                                                    <label for="vis-yes">Yes</label>
                                                </div>
                                                <div class="d-inline">
                                                    <input id="vis-no" type="radio" name="ads" value="1" <?php if ($row['Allow_Ads'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?> />
                                                    <label for="vis-no">No</label>
                                                </div>

                                            </div>

                                        </div>


                                        <div>
                                            <label>
                                                Allow Visability
                                            </label>

                                            <div class="btn btn-secondary  ">
                                                <div class="d-inline">
                                                    <input id="vis-yes" type="radio" name="visabile" value="0" <?php if ($row['Visability'] == 0) {
                                                                                                                    echo 'checked';
                                                                                                                } ?> />
                                                    <label for="vis-yes">Yes</label>
                                                </div>
                                                <div class="d-inline">
                                                    <input id="vis-no" type="radio" name="visabile" value="1" <?php if ($row['Visability'] == 1) {
                                                                                                                    echo 'checked';
                                                                                                                } ?> />
                                                    <label for="vis-no">No</label>
                                                </div>

                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-info w-100 mt-1">Update Category</button>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

<?php

        } // end 2

        else {
            echo '<div class="container mt-3">';
            $Msg = "<div class='alert alert-danger'>THERE NO such ID  </div>";
            redirectHome($Msg, 2);
            echo '</div>';
        }
    } elseif ($do == 'update') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $catid = $_POST['CateID'];
            $name = $_POST['name'];
            $Descripe = $_POST['Descripted'];
            $ordering = $_POST['ordering'];
            $parent = $_POST['parent'];
            $comment = $_POST['comment'];
            $ads = $_POST['ads'];
            $visable = $_POST['visabile'];

            $formError = array();
            if (empty($name)) {
                $formError[] = 'please full the Category Name ';
            }
            if (strlen($name) < 4) {
                $formError[] = 'please fullCaregory Name  more than 6 character';
            }
            if (empty($Descripe)) {
                $formError[] = 'please enter the fullname  ';
            }
            if (strlen($Descripe) < 6) {
                $formError[] = 'please full Descripe more than 6 character';
            }

            if (empty($ordering)) {
                $formError[] = 'please full the Ordering ';
            }

            foreach ($formError as $error) {
                echo '<div class="alert alert-danger">' . $error .
                    '</div>';
            }
            if (empty($formError)) {

                $stmt = $conn->prepare("UPDATE  categories  set  `Name` = ? , `Description` = ?, Ordering= ?, parent = ? ,Visability = ? ,Allow_comment  =?,Allow_Ads=? 
                    WHERE CateID = ? ");
                $stmt->execute(array($name, $Descripe, $ordering, $parent, $visable, $comment, $ads, $catid));
                echo '<div class="container mt-3">';
                $msg = '<div class ="alert alert-success">' . $stmt->rowCount() .
                    'Record update Sccesfully </div>';

                redirectHome($msg, 'back', 1);
                echo '</div>';
            } else {

                echo '<div class="container mt-3">';
                $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
                redirectHome($Msg, 1);
                echo '</div>';
            }
        }
    } elseif ($do == 'delete') {

        echo '<h1 class="text-center">Delete Categories</h1>';

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $check = checkItem('CateID', 'categories', $catid);

        if ($check > 0) {

            $stmt = $conn->prepare('DELETE FROM Categories WHERE CateID = :cate');
            $stmt->bindParam(':cate', $catid);
            $stmt->execute();
            echo '<div class="container mt-3">';
            $msg = '<div class= "alert alert-danger">' . $stmt->rowCount() .
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




    require_once $temp . 'footer.php';
} else {

    header('location:index.php');
    exit();
}
ob_end_flush();

?>