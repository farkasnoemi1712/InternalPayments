<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);


session_start();
if(!isset($_SESSION['auth'])) {
  header('Location: login.php');
}

include 'include/views/head.php';
include 'include/db/payment.class.php';

try {
  $paymentsDb = new Payment();
  $payments= $paymentsDb->getAll();
} catch(Exception $e) {
    // echo $e->getMessage()."<br/>";
    // echo $e->getLine()."<br/>";
    // echo $e->getFile();
    $payments = [];
    $error = true;
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
            <h3>Payment history</h3>
              <br>
            <?php if(isset($error)):?>
            
              <div class="alert alert-danger">A aparut o eroare</div>

            <?php else:?>

              <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Details</th>
                      <?php if($_SESSION['admin']):?> 
                         <th>Action</th>
                      <?php endif;?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($payments as $payment): ?>
                      <tr>
                        <th scope="row"> <?php echo $payment['id']?> </th>
                        <td><a href="/aplicatie/paymentview.php?id=<?php echo $payment['id']?>"> <?php echo $payment["date"]?></a> </td>
                        <td><?php echo $payment["details"]?> </td>
                        <?php if($_SESSION['admin']):?> 
                            <td>
                              <a href="editpayment.php?id=<?=$payment['id']?>">Edit</a>
                            </td>
                        <?php endif;?>
                      </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>

            <?php endif;?>
        </div>
</body