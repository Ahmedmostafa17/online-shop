<?php


session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = 'Member'; // page title

    require_once 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'manage'; // make route

    if ($do == 'manage') {

        $query = ' ';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') // to get peopele not active 

        {

            $query = 'AND RegStatus = 0';
        }

        //select all data
        $stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query AND Deletes=0 ");

        //execute
        $stmt->execute();
        //Assign to Variable
        $row = $stmt->fetchAll();
        if (!empty($row)) {
?>

<div class="container">
    <div class="row">

        <div class="col-md-12 col-sm-6  mt-5">

            <div class="card">
                <div class="card-header">
                    <h5 class=" text-center">Manage Members</h5>
                </div>
                <div class="card-body">

                    <!--  <input type="text" class="form-control w-25 float-right mt-3 mb-3" placeholder="Search" id='SearchInput'>-->
                    <a href="member.php?do=trash" class="btn btn-outline-danger pull-right mb-2"><i
                            class="fa fa-trash"></i>Trash</a>
                    <a href="member.php?do=files" class="btn btn-outline-info pull-right mb-2 mr-2"><i
                            class="fa fa-upload"></i> Import/Export</a>
                    <table class="table text-center manage-members table-bordered" id="items">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>image</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>FullName</th>
                                <th>Registerd Date</th>
                                <th>Control </th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                        foreach ($row as $show) {

                                            echo "<tr> ";
                                            echo "<td> " . $show['userID'];
                                            " </td>";
                                            echo "<td>";
                                            if (empty($show['image'])) {
                                                echo "<img  class='user-img' src='uploads/image/user.png '/> ";
                                            } else {
                                                echo "<img  class='user-img' src='uploads/image/" . $show['image'] . " '/> ";
                                            }
                                            echo " </td>";
                                            echo "<td> " . $show['UserName'];
                                            " </td>";
                                            echo "<td> " . $show['Email'];
                                            " </td>";
                                            echo "<td> " . $show['FullName'];
                                            " </td>";
                                            echo "<td>"  . $show['Date'];
                                            "</td>";
                                            echo "<td>    

                                                <a href='member.php?do=edit&userid=" . $show['userID'] . "'class='btn btn-success mt-1'> <i class='fa fa-edit'></i>Edit</a>
                                                <a href='member.php?do=delete&userid=" . $show['userID'] . "'class=' confirm btn btn-danger mt-1'><i class='fa fa-trash '></i>Delete</a>";

                                            if ($show['RegStatus'] == 0) {
                                                echo "<a href='member.php?do=activate&userid=" . $show['userID'] . "'class=' btn btn-info mt-1 ml-1'><i class='fa fa-close '></i>Active</a>";
                                            }

                                            echo "</td>";

                                            echo "</tr> ";
                                        }

                                        ?>

                        </tbody>
                    </table>

                    <a href="member.php?do=add" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>Add Member</a>


                </div>

            </div>
        </div>

    </div>
    <?php } else {
            echo '<div class="container">';

            echo "<div class='nice-message'> There's No Record</div>";
            echo '<a href="member.php?do=add" class="btn btn-primary ml-4"><i class="fa fa-plus"></i>Add Member</a>';



            echo '</div>';
        }




            ?>






    <?php } elseif ($do == 'add') {







        ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-4">
                <div class="card">
                    <div class="card-header bg-dark text-white text-center font-weight-bold ">
                        Add Members
                    </div>
                    <!--onsubmit='return addValidations()'-->
                    <div class="card-body">
                        <form action="?do=insert" method='POST' enctype='multipart/form-data'
                            onsubmit='return addValidations()'>
                            <div id="error1" class="  "></div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">User Name</label>
                                <input type="text" class="form-control  " name="username" id="username"
                                    autocomplete='off' placeholder="Please Enter Username">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full Name</label>
                                <input type="text" class="form-control  " name="fullname" id="fullname"
                                    autocomplete='off' placeholder="Please  Enter FllName ">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" placeholder="Please Enter Email Adresses">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Password</label>
                                <input type="password" class=" password form-control  " name="password" id="password"
                                    autocomplete='new-Password' placeholder="Please Enter Password">
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> User Image</label>

                                <input type='file' name='image'>



                            </div>

                            <button type="submit" class="btn btn-success w-100">Add</button>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php




            ?>

    <?php



        } elseif ($do == 'insert') {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $fullname = $_POST['fullname'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $hashPass = sha1($password);
                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imagetemp = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];
                // file types
                $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

                $tmp = explode('.', $imageName);
                $imageExtention = strtolower(end($tmp));



                //validation

                $formError = array();
                if (empty($username)) {
                    $formError[] = 'please full the user name ';
                }
                if (strlen($username) < 4) {
                    $formError[] = 'please full username more than 6 character';
                }
                if (empty($fullname)) {
                    $formError[] = 'please enter the fullname  ';
                }
                if (strlen($fullname) < 6) {
                    $formError[] = 'please full fullname more than 6 character';
                }

                if (empty($email)) {
                    $formError[] = 'please full the email ';
                }
                if (empty($password)) {
                    $formError[] = 'please full the password ';
                }
                if (strlen($password) < 4) {
                    $formError[] = 'please enter the  password more than 4 charachter ';
                }
                if (!in_array($imageExtention, $imageAllowExtention)) {
                    $formError[] = 'This Extention is not <strong> Allowed</strong> ';
                }
                // if ($imageType != 'jpeg'  || $imageType != 'jpg'  || $imageType != 'png') {
                //     $formError[] = 'Image is required</strong> ';
                // }
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
                    // check if user exixt or not

                    $image = rand(0, 10000000) . '_' . $imageName;
                    move_uploaded_file($imagetemp, "uploads\image\\" . $image);


                    $check = checkItem('UserName', 'users', $username);

                    if ($check == 1) {
                        echo '<div class="container mt-3">';
                        $msg = '<div class="alert alert-danger">Sorry The Username is Here</div>';
                        redirectHome($msg, 'back', 2);
                        echo '</div>';
                        header("location:member.php?do=add");
                    } else {

                        //insert userinfo in database

                        $stmt = $conn->prepare("INSERT INTO 
                      users(UserName,Password,Email,FullName,RegStatus,Date,`image`)
                      VALUES(:user, :pass, :email, :full, 1, now() ,:imge)");
                        $stmt->execute(array('user' => $username, 'pass' => $hashPass, 'email' => $email, 'full' => $fullname, 'imge' => $image));

                        echo '<div class="container">';
                        //echo success message
                        $msg = '<div class="alert alert-success">' . $stmt->rowCount() .
                            'Record Update</div>';
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
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $stmt = $conn->prepare("Select * From users WHERE userID = ? ");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($stmt->rowCount() > 0) { ?>
    <!--start 2-->

    <div class="container mt-5">

        <div class="row">

            <div class="col-md-5  col-sm-6 ">

                <div class="card">
                    <div class="card-header bg-dark text-white text-center font-weight-bold ">
                        Update Information
                    </div>
                    <div class="card-body">
                        <form action="?do=update" method='POST' onsubmit='return validations()'
                            enctype='multipart/form-data'>
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                            <div id="error1" class="  "></div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">User Name</label>
                                <input type="text" class="form-control  " name="username" id="username"
                                    autocomplete='off' value="<?php echo $row['UserName']; ?>">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" value="<?php echo $row['Email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full Name</label>
                                <input type="text" class="form-control  " name="fullname" id="fullname"
                                    autocomplete='off' value="<?php echo $row['FullName']; ?>">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> User Image</label>

                                <input type='file' name='image' value="<?php echo $row['image']; ?>">



                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" id='clear'>Clear</button>

                        </form>
                    </div>
                </div>

            </div>

            <div class="col-md-5 col-sm-6  offset-md-2 p-3">

                <div class="card">
                    <div class="card-header bg-dark text-white text-center font-weight-bold">
                        Update Password
                    </div>
                    <div class="card-body">
                        <form action="?do=pass/update" method='POST' onsubmit='return validation()'>
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            <div id="error" class="  "></div>

                            <div class="form-group">
                                <label for="exampleInputPassword1"> New Password</label>
                                <input type="password" class="form-control  " name="password" id="password"
                                    autocomplete='new-Password'>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputPassword1"> Retry New Password</label>
                                    <input type="password" class="form-control  " name="r-password" id="conf-password">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                    </div>
                </div>

            </div>
            <!---->

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
        } // end 1  



        elseif ($do == 'update') // update page 
        {


            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                //get variable 
                $userid = $_POST['userid'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['fullname'];
                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imagetemp = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];
                // file types
                $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

                $tmp = explode('.', $imageName);
                $imageExtention = strtolower(end($tmp));

                //validation

                $formErrors = array();

                if (empty($username)) {

                    $formErrors[] = ' Please Enter the Username ';
                }
                if (strlen($username) < 4) {
                    $formErrors[] = ' Username cant not be less than 4 characters ';
                }
                if (strlen($username) > 20) {
                    $formErrors[] = ' Username cant not be More than 20 characters ';
                }

                if (empty($email)) {

                    $formErrors[] = ' Please Enter the Email ';
                }

                if (empty($fullname)) {

                    $formErrors[] = ' Please Enter the FullName ';
                }

                foreach ($formErrors as $error) {

                    echo $error .
                        ' <br/>';
                }

                // $check = checkItem('UserName', 'users', $username);
                $image = rand(0, 10000000) . '_' . $imageName;
                move_uploaded_file($imagetemp, "uploads\image\\" . $image);

                // if ($check == 1) {
                //     echo '<div class="container mt-3">';
                //     $msg = '<div class="alert alert-danger">Sorry The Username is Here</div>';
                //     redirectHome($msg, 'back', 2);
                //     echo '</div>';
                // } 
                if (empty($formErrors)) {
                    // update the database 
                    $stmt = $conn->prepare("UPDATE  users set UserName = ? , Email = ?, FullName= ? , `image` =? WHERE userID = ? ");
                    $stmt->execute(array($username, $email, $fullname,  $image, $userid));
                    echo '<div class="container mt-3">';
                    $msg = '<div class ="alert alert-success">' . $stmt->rowCount() .
                        'Record update Sccesfully </div>';

                    redirectHome($msg, 'back', 1);
                    echo '</div>';
                }
            } else {
                echo '<div class="container mt-3">';
                $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
                redirectHome($Msg, 1);
                echo '</div>';
            }
        } elseif ($do == 'pass/update') //For password only 
        {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                //get variable 
                $userid = $_POST['userid'];
                $password = $_POST['password'];
                $hashPass = sha1($password);

                //validation 

                $formError = array();

                if (empty($password)) {

                    $formError[] = ' Please Enter the New Password ';
                }

                foreach ($formError as $error) {

                    echo $error .
                        ' <br/>';
                }
                if (empty($formError)) {
                    $stmt = $conn->prepare("UPDATE  users set `Password` =? WHERE userID = ? ");
                    $stmt->execute(array($hashPass, $userid));
                    echo '<div class="container mt-3">';
                    $msg = '<div class ="alert alert-success">' . $stmt->rowCount() .
                        'Record update Sccesfully </div>';

                    redirectHome($msg, 'back', 1);
                    echo '</div>';
                }

                // update the database 

            } else {
                echo '<div class="container mt-3">';
                $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
                redirectHome($Msg, 1);
                echo '</div>';
            }
        } elseif ($do == 'delete') {
            echo '<h1 class="text-center">Delete Member</h1>';

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $check = checkItem('userID', 'users', $userid);

            if ($check > 0) {



                $stmt = $conn->prepare('UPDATE `users` SET `Deletes` = 1 WHERE `userID` = ? ');


                $stmt->execute(array($userid));
                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-danger">' . $stmt->rowCount() .
                    'Deleated Successfully</div>';

                redirectHome($msg, 'back', 1);
                echo '</di>';
            } else {
                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';

                redirectHome($msg);
                echo '</di>';
            }
        }





        if ($do == 'trash') {



            //select all data
            $stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1  AND Deletes=1 ");

            //execute
            $stmt->execute();
            //Assign to Variable
            $row = $stmt->fetchAll();
            if (!empty($row)) {
            ?>

    <div class="container">
        <div class="row">

            <div class="col-md-12 col-sm-6  mt-5">

                <div class="card">
                    <h5 class="card-header text-center">Manage Trash</h5>
                    <div class="card-body">
                        <!--  <input type="text" class="form-control w-25 float-right mt-3 mb-3" placeholder="Search" id='SearchInput'>-->

                        <table class="table text-center table-bordered" id="items">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>FullName</th>
                                    <th>Registerd Date</th>
                                    <th>Control </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                            foreach ($row as $show) {

                                                echo "<tr> ";
                                                echo "<td> " . $show['userID'];
                                                " </td>";
                                                echo "<td> " . $show['UserName'];
                                                " </td>";
                                                echo "<td> " . $show['Email'];
                                                " </td>";
                                                echo "<td> " . $show['FullName'];
                                                " </td>";
                                                echo "<td>"  . $show['Date'];
                                                "</td>";
                                                echo "<td>    

                                              <a href='member.php?do=restore&userid=" . $show['userID'] . "'class='btn btn-outline-info mt-1'> <i class='fa fa-undo'></i>Restore</a>
                                              <a href='member.php?do=primaryDelete&userid=" . $show['userID'] . "'class='   confirm btn btn-outline-danger mt-1' ><i class='fa fa-trash '></i> primary Delete</a>";



                                                echo "</td>";

                                                echo "</tr> ";
                                            }

                                            ?>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>
        <?php } else {
                echo '<div class="container">';

                echo "<div class='nice-message'> There's No Record</div>";
                echo '<a href="member.php?do=manage" class="btn btn-primary ml-4"><i class="fa fa-plus"></i>Back To Member</a>';



                echo '</div>';
            }




                ?>






        <?php } elseif ($do == 'restore') {



            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


            $stmt = $conn->prepare('UPDATE `users` SET `Deletes` = 0 WHERE `userID` = ? ');


            $stmt->execute(array($userid));
            echo '<div class="container mt-3">';
            $msg = '<div class= "alert alert-success">' . $stmt->rowCount() .
                'Restore Successfully</div>';

            redirectHome($msg, 'back', 1);
            echo '</di>';
        } elseif ($do == 'primaryDelete') {
            echo '<h1 class="text-center">Delete Members</h1>';


            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;



            $stmt = $conn->prepare('DELETE FROM users WHERE `userID`=?');
            $stmt->execute(array($userid));
            echo '<div class="container mt-3">';
            $msg = '<div class= "alert alert-success">' . $stmt->rowCount() .
                'Deleated Successfully</div>';

            redirectHome($msg, 'back', 1);
            echo '</di>';
        } elseif ($do == 'activate') {

            echo '<h1 class="text-center">Activate Member</h1>';

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $check = checkItem('userID', 'users', $userid);

            if ($check > 0) {

                $stmt = $conn->prepare('UPDATE users SET RegStatus=1 WHERE userID= ?');

                $stmt->execute(array($userid));
                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-sucess">' . $stmt->rowCount() .
                    'Activate Successfully</div>';

                redirectHome($msg, 'back', 1);
                echo '</di>';
            } else {
                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-danger">THESE NO SUCH ID </div>';

                redirectHome($msg, 1);
                echo '</di>';
            }
        } elseif ($do == 'files') { ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card mt-5">
                        <div class="card-header text-center">
                            Import Members To Database

                        </div>
                        <div class="card-body">
                            <form action="member.php?do=import" method='POST' enctype='multipart/form-data'>

                                <!-- <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFileLangHTML" name="uploadedfile">
            <label class="custom-file-label" for="customFileLangHTML" data-browse="Bestand kiezen"></label>
        </div> -->
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="uploadedfile"
                                            accept=".csv" required>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <button class="btn btn-secondary mt-3" type="submit" name="file">Submit</button>

                            </form>

                        </div>
                    </div>

                </div>
                <div class="col-lg-5 offset-md-2">
                    <div class="card mt-5">
                        <div class="card-header text-center">
                            Export Members

                        </div>
                        <div class="card-body">

                            <form action="export.php" method='POST' class="export">
                                <button type="submit" name='export' class="btn btn-secondary btn-lg "><i
                                        class="fa fa-right">Export</button>

                            </form>
                        </div>
                    </div>

                </div>

            </div>





        </div>



    </div>
    <?php } elseif ($do == 'import') {
            if (isset($_FILES['uploadedfile'])) {

                // get the csv file and open it up
                $file = $_FILES['uploadedfile']['tmp_name'];
                $handle = fopen($file, "r");
                try {
                    // prepare for insertion
                    $query_ip = $conn->prepare('INSERT INTO users ( UserName, `Password`, Email, FullName ,`Date`) VALUES
             ( :user, :pass, :full, :email, now())');
                    $data = fgetcsv($handle, 1000, ",", "'");
                    $query_ip->execute(array('user' => $data[0], 'pass' => $data[1], 'full' => $data[2], 'email' => $data[3]));
                    $count = $query_ip->rowCount();
                    fclose($handle);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-success">' . $count .
                    'Import Successfully</div>';

                redirectHome($msg, 'back', 1);
                echo '</di>';
            } else {
                echo '<div class="container mt-3">';
                $msg = '<div class= "alert alert-danger">can not Import </div>';

                redirectHome($msg);
                echo '</di>';
            }
        }

        require_once $temp . 'footer.php';
    } else {
        header('location:index.php');
        exit();
    }


        ?>