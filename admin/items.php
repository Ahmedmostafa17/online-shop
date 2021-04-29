<?php
ob_start();
session_start();
$pageTitle = ' item';
if (isset($_SESSION['Username'])) {
    include 'connect.php';
    include  'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if ($do == 'Manage') {




        $stmt = $conn->prepare("SELECT items.* ,categories.Name AS Category_Name ,users.UserName
        from items 
        INNER JOIN categories on CateID = items.Category_ID
        INNER JOIN users ON userID = items.Member_ID ");

        //execute
        $stmt->execute();
        //Assign to Variable
        $row = $stmt->fetchAll();
        if (!empty($row)) {

?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-10  col-sm-6  mt-4">

            <div class="card ">
                <h5 class="card-header text-center">Manage Items</h5>
                <div class="card-body">
                    <!--  <input type="text" class="form-control w-25 float-right mt-3 mb-3" placeholder="Search" id='SearchInput'>-->
                    <div class="col-lg-12 col-md-10  col-sm-10  ">
                        <table class="table text-center table-bordered" id="items">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>image </th>
                                    <th>Item Name </th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Country Made</th>
                                    <!-- <th>Status</th> -->
                                    <th>Add_Date </th>
                                    <th>Category </th>
                                    <th>Member </th>
                                    <th>Control </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                            foreach ($row as $show) {

                                                echo "<tr> ";
                                                echo "<td> " . $show['itemID'];
                                                " </td>";
                                                echo "<td> " . $show['Name'];
                                                " </td>";
                                                echo "<td> ";

                                                if (empty($show['image'])) {
                                                    echo "<img  class='user-img' src='uploads/image/user.png '/> ";
                                                } else {
                                                    echo "<img  class='user-img' src='uploads/items/" . $show['image'] . " '/> ";
                                                }
                                                echo  " </td>";
                                                echo "<td> " . $show['Description'];
                                                " </td>";
                                                echo "<td> " . $show['price'];
                                                " </td>";
                                                echo "<td> " . $show['Country_Made'];
                                                " </td>";

                                                //   if($show['Status']==1)
                                                //   {
                                                //     echo "<td> New </td>";

                                                //   }
                                                //  elseif($show['Status']==2)
                                                //   {
                                                //     echo "<td> Like  New </td>";

                                                //   }
                                                //   elseif($show['Status']==3)
                                                //   {
                                                //     echo "<td> Copy  </td>";

                                                //   }
                                                //   elseif($show['Status']==4)
                                                //   {
                                                //     echo "<td> Old </td>";

                                                //   }

                                                echo "<td>"  . $show['Add_Date'];
                                                "</td>";
                                                echo "<td>"  . $show['Category_Name'];
                                                "</td>";
                                                echo "<td>"  . $show['UserName'];
                                                "</td>";
                                                echo "<td>    
                                            
                                          <a href='items.php?do=edit&itemid=" . $show['itemID'] . "'class='btn btn-success mt-1'> <i class='fa fa-edit'></i>Edit</a>
                                          <a href='items.php?do=delete&itemid=" . $show['itemID'] . "'class=' confirm btn btn-danger mt-1'><i class='fa fa-trash '></i>Delete</a>";

                                                if ($show['Approve'] == 0) {
                                                    echo "<a href='items.php?do=approve&itemid=" . $show['itemID'] . "'class=' btn btn-info mt-1 ml-1'><i class='fa fa-check '></i>Active</a>";
                                                }

                                                echo "</td>";

                                                echo "</tr> ";
                                            }

                                            ?>

                            </tbody>
                        </table>
                    </div>
                    <a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>Add Items</a>
                </div>

            </div>
        </div>
    </div>
    <?php } else {
            echo '<div class="container">';

            echo "<div class='nice-message'> There's No Record</div>";

            echo '<a href="items.php?do=add" class="btn btn-primary ml-4"><i class="fa fa-plus"></i>Add Items</a>';

            echo '</div>';
        }

            ?>

    <?php } elseif ($do == 'add') { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-4 ">
                <div class="card ">
                    <div class="card-header bg-dark text-white text-center font-weight-bold ">
                        Add Items
                    </div>
                    <div class="card-body  ">


                        <form action="items.php?do=insert" method='POST'>
                            <div id="error1" class="  "></div>
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Name:</label>
                                <input type="text" class="form-control  " name="name" id="name" autocomplete='off'
                                    placeholder="Name of the Item" required>
                            </div>
                            <!--End falied-->

                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Description:</label>
                                <input type="text" class="form-control  " name="Description" id="Description"
                                    autocomplete='off' placeholder="Fll the Description Field" required>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Price:</label>
                                <input type="text" class="form-control  " name="price" id="price" autocomplete='off'
                                    placeholder="Fll the Price Field" required>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Country Made:</label>
                                <input type="text" class="form-control  " name="country_made" id="country_made"
                                    autocomplete='off' placeholder="Fll the country Field" required>
                            </div>
                            <!--End falied-->

                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Status:</label>
                                <select class=" form-control" name="statue" required>
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Copy</option>
                                    <option value="4">Old</option>
                                </select>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Members:</label>
                                <select class=" form-control" name="member" required>
                                    <option value="0">...</option>
                                    <?php
                                            $stmt = $conn->prepare("SELECT * FROM users");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();

                                            foreach ($users as $user)
                                                echo "<option value= " . $user['userID'] . ">" . $user['UserName'] . "</option>"


                                            ?>

                                </select>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> categories:</label>
                                <select class=" form-control" name="category" required>
                                    <option value="0">...</option>
                                    <?php
                                            $stmt2 = $conn->prepare("SELECT * FROM categories");
                                            $stmt2->execute();
                                            $cats = $stmt2->fetchAll();

                                            foreach ($cats as $cat) {
                                                echo "<option value= " . $cat['CateID'] . ">" . $cat['Name'] . "</option>";

                                                /**child */
                                                $stmt2 = $conn->prepare("SELECT * FROM categories WHERE parent= ?");
                                                $stmt2->execute(array($cat['CateID']));
                                                $childs = $stmt2->fetchAll();
                                                foreach ($childs as $child) {
                                                    echo "<option value= " . $child['CateID'] . ">----" . $child['Name'] . "</option>";
                                                }
                                            }


                                            ?>

                                </select>
                            </div>
                            <!--End falied-->

                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Tage</label>
                                <input type="text" class="form-control  " name="tags" id="tags" autocomplete='off'
                                    placeholder="Seperate tage with comman (,)">
                            </div>
                            <!--End falied-->
                            <div class="form-group">
                                <label for="exampleInputPassword1"> item image</label>

                                <input type='file' name='image'>



                            </div>










                            <!-- start falied
                                <div class="form-group">
                                <label for="exampleInputEmail1"> Ratting:</label>
                                <select class=" form-control"name="ratting">
                                <option value="0">...</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>

                                </select>
                            </div> -->
                            <!--End falied-->











                            <button type="submit" class="btn btn-info w-100 mt-1">Add Items</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php } elseif ($do == 'insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $Description = $_POST['Description'];
                $price = $_POST['price'];
                $Country = $_POST['country_made'];
                $Status = $_POST['statue'];
                $member = $_POST['member'];
                $category = $_POST['category'];
                $tags = $_POST['tags'];

                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imagetemp = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];
                // file types
                $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

                $tmp = explode('.', $imageName);
                $imageExtention = strtolower(end($tmp));
                // Validation 
                $formError = array();
                if (empty($name)) {
                    $formError[] = 'please full the Item Name ';
                }
                if (strlen($name) < 4) {
                    $formError[] = 'please full Item Name  more than 4 character';
                }
                if (empty($Description)) {
                    $formError[] = 'please enter the Description  ';
                }
                if (strlen($Description) < 15) {
                    $formError[] = 'please full Description more than 15 character';
                }

                if (empty($price)) {
                    $formError[] = 'please Enter Price ';
                }
                if (empty($Country)) {
                    $formError[] = 'please Enter  the Country Made  ';
                }
                if ($Status == 0) {
                    $formError[] = 'You Must Choose The Status ';
                }

                if ($member == 0) {
                    $formError[] = 'You Must Choose The Member ';
                }
                if ($category == 0) {
                    $formError[] = 'You Must Choose The Category ';
                }
                if (!in_array($imageExtention, $imageAllowExtention)) {
                    $formError[] = 'This Extention is not <strong> Allowed</strong> ';
                }

                if (empty($imageName)) {
                    $formError[] = 'Image is required</strong> ';
                }
                if ($imageSize > (4 * 1024 * 1024)) {
                    $formError[] = 'Max size is 4 MB</strong> ';
                }

                foreach ($formError as $error) {
                    echo '<div class="alert alert-danger">' . $error .
                        '</div>';
                }
                if (empty($formError)) {

                    $image = rand(0, 10000000) . '_' . $imageName;
                    move_uploaded_file($imagetemp, "uploads\items\\" . $image);


                    //insert userinfo in database

                    $stmt = $conn->prepare("INSERT INTO 
                        items(`Name`,`Description`,Price,Country_Made,`Status`,Add_Date ,Category_ID,Member_ID,tags,`image`)
                        VALUES(:name, :desc, :price, :country,:status, now(),:category ,:member,:tags ,:img)");
                    $stmt->execute(array(
                        'name' => $name, 'desc' => $Description, 'price' => $price, 'country' => $Country, 'status' => $Status,
                        'category' => $category, 'member' => $member, 'tags' => $tags, 'img' => $image
                    ));

                    echo '<div class="container">';
                    //echo success message
                    $msg = '<div class="alert alert-success">' . $stmt->rowCount() .
                        'Record Add</div>';
                    redirectHome($msg, 'back', 1);
                    echo '</div>';
                }
            } else {

                echo '<div class="container mt-3">';
                $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
                redirectHome($Msg, 1);
                echo '</div>';
            }
        } elseif ($do == 'edit') {

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $stmt = $conn->prepare("SELECT  * From items WHERE itemID = ? ");
            $stmt->execute(array($itemid));
            $item = $stmt->fetch();
            if ($stmt->rowCount() > 0) { ?>


    x

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6 offset-md-3 mt-4 ">

                <div class="card ">
                    <div class="card-header bg-dark text-white text-center font-weight-bold ">
                        Edit Items
                    </div>
                    <div class="card-body  ">


                        <form action="items.php?do=update" method='POST' enctype="multipart/form-data">
                            <input type="hidden" name="itemID" value="<?php echo $itemid ?>" />

                            <div id="error1" class="  "></div>
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Name:</label>
                                <input type="text" class="form-control  " name="name" id="name" autocomplete='off'
                                    placeholder="Name of the Item" required value="<?php echo $item['Name'] ?>">
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Description:</label>
                                <input type="text" class="form-control  " name="Description" id="Description"
                                    autocomplete='off' placeholder="Fll the Description Field" required
                                    value="<?php echo $item['Description'] ?>">
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Price:</label>
                                <input type="text" class="form-control  " name="price" id="price" autocomplete='off'
                                    placeholder="Fll the Price Field" required value="<?php echo $item['price'] ?>">
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Country Made:</label>
                                <input type="text" class="form-control  " name="country_made" id="country_made"
                                    autocomplete='off' placeholder="Fll the country Field" required
                                    value="<?php echo $item['Country_Made'] ?>">
                            </div>
                            <!--End falied-->

                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Status:</label>
                                <select class=" form-control" name="statue" required>
                                    <option value='0'>...</option>
                                    <option value="1" <?php if ($item['Status'] == 1) {
                                                                        echo 'selected';
                                                                    } ?>>New</option>
                                    <option value="2" <?php if ($item['Status'] == 2) {
                                                                        echo 'selected';
                                                                    } ?>>Like New</option>
                                    <option value="3" <?php if ($item['Status'] == 3) {
                                                                        echo 'selected';
                                                                    } ?>>Copy</option>
                                    <option value="4" <?php if ($item['Status'] == 4) {
                                                                        echo 'selected';
                                                                    } ?>>Old</option>
                                </select>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Members:</label>
                                <select class=" form-control" name="member" required>
                                    <option value="0">...</option>
                                    <?php
                                                $stmt = $conn->prepare("SELECT * FROM users");
                                                $stmt->execute();
                                                $users = $stmt->fetchAll();

                                                foreach ($users as $user) {

                                                    echo "<option value='" . $user['userID'] . "'";

                                                    if ($item['Member_ID'] == $user['userID']) {
                                                        echo 'selected';
                                                    }
                                                    echo ">" . $user['UserName'] . "</option>";
                                                }
                                                ?>

                                </select>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> categories:</label>
                                <select class=" form-control" name="category" required>
                                    <option value="0">...</option>
                                    <?php
                                                $stmt2 = $conn->prepare("SELECT * FROM categories");
                                                $stmt2->execute();
                                                $cats = $stmt2->fetchAll();

                                                foreach ($cats as $cates) {


                                                    echo "<option value= '" . $cates['CateID'] . "'";
                                                    if ($item['Category_ID'] == $cates['CateID']) {
                                                        echo 'selected';
                                                    }
                                                    echo ">" . $cates['Name'] . "</option>";
                                                }
                                                ?>

                                </select>
                            </div>
                            <!--End falied-->
                            <!--start falied-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Tage</label>
                                <input type="text" class="form-control  " name="tags" id="tags" autocomplete='off'
                                    placeholder="Seperate tage with comman (,)" value="<?php echo $item['tags'] ?>">
                            </div>
                            <!--End falied-->
                            <div class="form-group">
                                <label for="exampleInputPassword1"> User Image</label>

                                <input type='file' name='image' value="<?php echo $item['image']; ?>">


                            </div>


                            <button type="submit" class="btn btn-info w-100 mt-1">Update Items</button>

                        </form>

                    </div>


                </div>

            </div>

            <div class="container-fluid">

                <?php

                            $stmt = $conn->prepare("SELECT comments.*  ,users.UserName 
                                from comments 
                        
                                INNER JOIN users ON userID = comments.member_ID
                                WHERE item_ID= ?
                                ");

                            //execute
                            $stmt->execute(array($itemid));
                            //Assign to Variable
                            $row = $stmt->fetchAll();
                            if (!empty($row)) {


                            ?>
                <div class="row">

                    <div class="col-lg-12 col-md-10  col-sm-6  mt-4">

                        <div class="card ">
                            <h5 class="card-header text-center">Manage [<?php echo $item['Name'] ?>] Comments</h5>
                            <div class="card-body">
                                <!--  <input type="text" class="form-control w-25 float-right mt-3 mb-3" placeholder="Search" id='SearchInput'>-->
                                <div class="col-lg-12 col-md-10  col-sm-10  ">
                                    <table class="table text-center table-bordered ">
                                        <thead class="thead-dark">
                                            <tr>

                                                <th>Comment </th>
                                                <th>User Nmae</th>
                                                <th>Add_Date </th>
                                                <th>Control </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php





                                                            foreach ($row as $show) {

                                                                echo "<tr> ";

                                                                echo "<td> " . $show['comment'];
                                                                " </td>";

                                                                echo "<td> " . $show['UserName'];
                                                                " </td>";
                                                                echo "<td> " . $show['comment_date'];
                                                                " </td>";

                                                                echo "<td>    
                                            
                                            <a href='comments.php?do=edit&commentid=" . $show['comment_ID'] . "'class='btn btn-success mt-1'> <i class='fa fa-edit'></i>Edit</a>
                                            <a href='comments.php?do=delete&commentid=" . $show['comment_ID'] . "'class=' confirm btn btn-danger mt-1'><i class='fa fa-trash '></i>Delete</a>";

                                                                if ($show['status'] == 0) {
                                                                    echo "<a href='comments.php?do=approve&commentid=" . $show['comment_ID'] . "'class=' btn btn-info py-1 mt-1 ml-1'><i class='fa fa-check '></i>Active</a>";
                                                                }

                                                                echo "</td>";

                                                                echo "</tr> ";
                                                            }

                                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>

                </div>



                <?php } else {
                    echo '<div class="container mt-3">';
                    $Msg = "<div class='alert alert-danger'>THERE NO such ID  </div>";
                    redirectHome($Msg, 2);
                    echo '</div>';
                }
            } elseif ($do == 'update') {


                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $itemID = $_POST['itemID'];
                    $name = $_POST['name'];
                    $Descripe = $_POST['Description'];
                    $price = $_POST['price'];
                    $country = $_POST['country_made'];
                    $statue = $_POST['statue'];
                    $member = $_POST['member'];
                    $category = $_POST['category'];
                    $tags = $_POST['tags'];
                    $imageName = $_FILES['image']['name'];
                    $imageSize = $_FILES['image']['size'];
                    $imagetemp = $_FILES['image']['tmp_name'];
                    $imageType = $_FILES['image']['type'];
                    // file types
                    $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

                    $tmp = explode('.', $imageName);
                    $imageExtention = strtolower(end($tmp));

                    $formError = array();
                    if (empty($name)) {
                        $formError[] = 'please full the Item Name ';
                    }

                    if (empty($Descripe)) {
                        $formError[] = 'please enter the Description  ';
                    }
                    if (strlen($Descripe) < 6) {
                        $formError[] = 'please full Descripe more than 6 character';
                    }

                    if (empty($price)) {
                        $formError[] = 'please full the price ';
                    }
                    if (empty($country)) {
                        $formError[] = 'please full the country ';
                    }
                    if (empty($statue)) {
                        $formError[] = 'please full the statue ';
                    }
                    if (empty($member)) {
                        $formError[] = 'please full the member ';
                    }
                    if (empty($category)) {
                        $formError[] = 'please full the category ';
                    }


                    foreach ($formError as $error) {
                        echo '<div class="alert alert-danger">' . $error .
                            '</div>';
                    }
                    if (empty($formError)) {
                        $image = rand(0, 10000000) . '_' . $imageName;
                        move_uploaded_file($imagetemp, "uploads\items\\" . $image);

                        $stmt = $conn->prepare(" UPDATE  items  set  `Name` = ? , 
                    `Description` = ?, price = ? 
                    ,Country_Made = ? ,`Status`  = ?
                    ,Category_ID= ? , Member_ID =  ?, tags=?, `image` =?
                    WHERE
                   itemID = ? ");
                        $stmt->execute(array($name, $Descripe, $price, $country, $statue, $category, $member, $tags, $image, $itemID));
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

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                $check = checkItem('itemID', 'items', $itemid);

                if ($check > 0) {

                    $stmt = $conn->prepare('DELETE FROM items WHERE itemID = :item');
                    $stmt->bindParam(':item', $itemid);
                    $stmt->execute();
                    echo '<div class="container mt-3">';
                    $msg = '<div class= "alert alert-success">' . $stmt->rowCount() .
                        'Deleated Successfully</div>';

                    redirectHome($msg, 'back', 1);
                    echo '</di>';
                } else {
                    echo '<div class="container mt-3">';
                    $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';

                    redirectHome($msg, 1);
                    echo '</di>';
                }
            } elseif ($do == 'approve') {

                echo '<h1 class="text-center">Approve Items</h1>';

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                $check = checkItem('itemID', 'items', $itemid);

                if ($check > 0) {

                    $stmt = $conn->prepare('UPDATE items SET Approve =1 WHERE itemID= ?');

                    $stmt->execute(array($itemid));
                    echo '<div class="container mt-3">';
                    $msg = '<div class= "alert alert-success">' . $stmt->rowCount() .
                        'Activate Successfully</div>';

                    redirectHome($msg, 'back', 1);
                    echo '</di>';
                } else {
                    echo '<div class="container mt-3">';
                    $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';

                    redirectHome($msg, 1);
                    echo '</di>';
                }
            }




            include $temp . 'footer.php';
        } else {

            header('location:index.php');
            exit();
        }
        ob_end_flush();
                    ?>