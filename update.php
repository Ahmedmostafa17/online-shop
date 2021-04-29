<?php session_start(); ?>
<?php
if (isset($_SESSION['user'])) {
    $pageTitle = 'update';
    require_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage'; // make route
    if ($do == 'manage') {
        echo 'ahmed';
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
                            <input type="text" class="form-control  " name="username" id="username" autocomplete='off'
                                value="<?php echo $row['UserName']; ?>">

                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                aria-describedby="emailHelp" value="<?php echo $row['Email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text" class="form-control  " name="fullname" id="fullname" autocomplete='off'
                                value="<?php echo $row['FullName']; ?>">

                        </div>
                        <div class="form-group">

                            <label for="exampleInputPassword1"> User Image</label>

                            <input type='file' name='image' ?>

                            <input type="hidden" name="image-name" value="<?php echo $row['image']; ?>" />



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
    } elseif ($do == 'update') // update page 
    {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //get variable 
            $userid = $_POST['userid'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];
            $image_name = $_POST['image-name'];

            // file types
            // $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

            // $tmp = explode('.', $imageName);
            // $imageExtention = strtolower(end($tmp));

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
            if (isset($_FILES['image'])) {
                //information 

                $error = $_FILES['image']['error'];
                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imagetemp = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];


                if ($imageType == 'image/png' || $imageType == 'image/jpg' || $imageType == 'image/jpeg' && $error == 0) {
                    //rename to image 
                    $NewImage = md5($imageName . date('U') . rand(1000, 100000)) . $imageName;

                    // move to file
                    if (move_uploaded_file($imagetemp, 'uploads/image-users/' . $NewImage)) {

                        unlink('uploads/image-users/' . $image_name);

                        $image_name =  $NewImage;
                    }
                }
            }


            // // $check = checkItem('UserName', 'users', $username);
            // $newimage = rand(0, 10000000) . '_' . $imageName;
            // move_uploaded_file($imagetemp, "admin/uploads/image//" . $newimage);



            // if ($check == 1) {
            //     echo '<div class="container mt-3">';
            //     $msg = '<div class="alert alert-danger">Sorry The Username is Here</div>';
            //     redirectHome($msg, 'back', 2);
            //     echo '</div>';
            // } 
            if (empty($formErrors)) {
                // update the database 
                $stmt = $conn->prepare("UPDATE  users set UserName = ? , Email = ?, FullName= ? , `image` =? WHERE userID = ? ");
                $stmt->execute(array($username, $email, $fullname,  $image_name, $userid));
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
    }
    require_once $temp . 'footer.php';
}
?>