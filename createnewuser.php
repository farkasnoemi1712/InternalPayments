<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if(!isset($_SESSION['auth'])) {
    header('Location: login.php');
}

if(empty($_SESSION['admin'])){
    header("Location: paymenthistory.php");
}

include 'include/views/head.php';
include 'include/db/user.class.php';

if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])
    &&  $_POST['password'] == $_POST['confirm_password']){
    if (strlen($_POST['username'])>=5 ) {
        try {
            $isAdmin = isset($_POST['isAdmin'])?1:0;
            $userDb = new User();
            $userDb->create($_POST['username'], sha1($_POST['password']), $isAdmin);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    else {
        echo "<script>
                        alert('Username should be more than 8 characters');
              </script>";
//            echo "<span style='color: red;'>Username should be more than 8 characters</span>";
    }
}


?>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="background: #eee;">
            <?php
            include 'include/views/menu.php';
            ?>
        </div>

        <div class="col-10 p-5">
            <h3 class="mb-3">New user</h3>
            <div class="wrapper">
                <form method="post">
                    <div class="form-group">
                        <label>New username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Confirm new password</label>
                        <input type="password" name="confirm_password" class="form-control">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="isAdmin" class="form-check-input">
                        <label class="form-check-label"  for="exampleCheck1">Admin</label>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary" >Submit</button>
                        <!--<input type="submit" class="btn btn-primary" value="Submit">-->
                    </div>
                </form>
            </div>
            <div class="form-group">
                <br>
            </div>
        </div>
    </div>
</body>