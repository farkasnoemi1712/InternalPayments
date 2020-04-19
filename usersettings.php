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
            <?php if($_SESSION['admin']):?>
                <a href="createnewuser.php">Create new User</a>
                <br><br>
                <a href="editusers.php">Edit Users</a>
            <?php else: ?>
                <a href="update.php">Change password</a>
            <?php endif;?>
        </div>
    </div>
  </div>
</body>
