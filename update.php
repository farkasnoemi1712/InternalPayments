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

if(isset($_POST['submit']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])
    &&  $_POST['password'] == $_POST['confirm_password']){
        try {
            $userDb = new User();
            $userDb->updatePassword($_GET['id'], sha1($_POST['password']) );
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
}


$username = new User();
$user = $username->get($_GET['id']);

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

            <div class="wrapper">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputDate">Username</label>
                        <input type="text"  name="username" class="form-control" disabled="disabled" value="<?php echo $user["user"] ?>" placeholder="User">
                    </div>
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Confirm new password</label>
                        <input type="password" name="confirm_password" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary" >Submit</button>
                    </div>
                </form>
            </div>
            <div class="form-group">
                <br>
            </div>
        </div>
    </div>
</body>
