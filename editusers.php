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

try {
    $userDb = new User();
    $users= $userDb->getAll();
} catch(Exception $e) {
    $users = [];
    $error = true;
}

// DELETE
if(!empty($_GET['delete_user'])){
    $userDb->delete($_GET['delete_user']);
    header("Location: editusers.php?id=".$_GET['id']);
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
            <h3>Edit Users</h3>
            <br>
            <?php if(isset($error)):?>

                <div class="alert alert-danger">A aparut o eroare</div>

            <?php else:?>

                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>IsAdmin</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $us): ?>
                            <tr>
                                <td> <?php echo $us['id']?></td>
                                <td> <?php echo $us['user']?></td>
                                <td> <?php echo $us['admin']?></td>
                                <td>
                                    <a href="update.php?id=<?=$us['id']?>">Update</a>
                                </td>
                                <td>
                                    <a href="editusers.php?id=<?=$us['id']?>&delete_user=<?=$us['id']?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                </table>
            <?php endif;?>
        </div>
</body>