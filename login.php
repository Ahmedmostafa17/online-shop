<?php
session_start();

$pageTitle = 'Login';

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {

        // check if user coming from http request
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashpaa = sha1($password);

        $formError = array();
        if (isset($username)) {
            $filtername = filter_var($username, FILTER_SANITIZE_STRING);

            if (empty($username)) {
                $formError[] = 'please full the UserName ';
            }
        }
        if (empty($password)) {
            $formError[] = 'please full the password ';
        } else {

            //check if the user exist in data 
            $stmt = $conn->prepare("SELECT  userID, UserName ,`Password`   From users WHERE UserName = ? AND Password = ? ");
            $stmt->execute(array($username,  $hashpaa));
            $get = $stmt->fetch();
            $count = $stmt->rowCount();
            /*echo $count;*/

            // if count >0 this mean the database contain record this username 
            if ($count > 0) {
                $_SESSION['user'] = $username;
                $_SESSION['userID'] = $get['userID'];


                header('location:index.php');
                exit();
            }
        }
    }

    // else{
    //     $formError = array();
    //     if(isset($_POST['username'])){
    //     $filtername =filter_var( $_POST['username'] ,FILTER_SANITIZE_STRING);

    //     if(empty($filtername))
    //     {
    //         $formError[]='please Full the UserName ';
    //     }
    //     if(strlen($filtername)< 4)
    //     {
    //         $formError[]='Username cant not be less than 4 characters ';
    //     }

    //     }

    // }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {

        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hashPass = sha1($password);
        //validation

        $formError = array();
        if (isset($username)) {
            $filtername = filter_var($username, FILTER_SANITIZE_STRING);

            if (empty($username)) {
                $formError[] = 'please full the UserName ';
            }
        }
        if (empty($password)) {
            $formError[] = 'please full the password ';
        }


        if (empty($formError)) {


            // check if user exixt or not

            $check = checkItem('UserName', 'users', $username);

            if ($check == 1) {
                $formError[] = 'Sorry The Username is Here';
            } else {

                //insert userinfo in database

                $stmt = $conn->prepare("INSERT INTO 
                        users(UserName,Password,Email,FullName,RegStatus,Date)
                        VALUES(:user, :pass, :email, :full, 1, now())");
                $stmt->execute(array('user' => $username, 'pass' => $hashPass, 'email' => $email, 'full' => $fullname));
            }
        }
    }
}




// 
?>

<div class="container login-page">



    <div class="row ">

        <div class=" col-lg-4  col-md-6 col-sm-6  mt-3  backs ">
            <h1 class="text-center design"> <span class="selected" data-class='login'>Login</span> <span
                    data-class='register'>Register</span></h1>

            <div class="ground">
                <div class="errors">
                    <?php

                    if (!empty($formError)) {
                        foreach ($formError as $error) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                    }
                    ?>

                </div>
                <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                    <div class="form-group">
                        <lable> <i class="fa fa-user"> UserName</i> </lable>
                        <input class="form container" type="text" name='username' autoComplete='off'
                            placeholder="please write UserName">
                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-eye"> Password</i> </lable>
                        <input class="form container" type="password" name='password' autoComplete='new-password'
                            placeholder="please write Password">

                    </div>
                    <button type="submit" name='login' class="btn btn-info w-100"> <i class='fa fa-lock'> Login </i>
                    </button>
                </form>
                <!-- onsubmit='return addValidations()'-->
                <form class="register" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"
                    onsubmit='return addValidations()'>
                    <div id="error1">


                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-user"> UserName</i> </lable>
                        <input class="form container" type="text" name='username' id="username" autoComplete='off'
                            placeholder="please write UserName">
                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-user"> FullName</i> </lable>
                        <input class="form container" type="text" name='fullname' id="fullname" autoComplete='off'
                            placeholder="please write UserName">
                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-envelope-square "> Email</i> </lable>
                        <input class="form container" type="email" name='email' id="email" autoComplete='off'
                            placeholder="please write Email">
                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-eye"> Password</i> </lable>
                        <input class="form container" type="password" name='password' id="password"
                            autoComplete='new-password' placeholder="please write Password">

                    </div>
                    <div class="form-group">
                        <lable> <i class="fa fa-eye"> Confirm Password</i> </lable>
                        <input class="form container" type="password" name='confirm' id="confirm"
                            autoComplete='new-password' placeholder="please write  Confirm Password">

                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100"> <i class='fa fa-pencil'>
                            Register </i>

                </form>

            </div>

        </div>

    </div>







</div>


<?php require_once $temp . 'footer.php'; ?>