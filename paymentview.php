<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
    
    
    session_start();
    if(!isset($_SESSION['auth'])) {
        header('Location: login.php');
    }

    include 'include/views/head.php';
    include 'include/db/payment_details.class.php';
    
    $paymentDetailsDb = new PaymentDetails();
    if(isset($_GET['id'])) {
        $payments= $paymentDetailsDb->getAll($_GET['id']); 
    } else {
        header("Location: paymenthistory.php");
        // $payments = [];
    }

    try {
        $paymentDetailsDb = new PaymentDetails();
        $payments= $paymentDetailsDb->getAll($_GET['id']);
      } catch(Exception $e) {
          $payments = [];
          $error = true;
    }
?>
<body>
  <div class="container-fluid">
        <div class="row">
            <div class="col-2" style="background: #eee;">
              <?php include 'include/views/menu.php'; ?>
            </div>
      
        <div class="col-10 p-5"> 
            <h2><p class="mt-4 mb-5">Payment view</p></h2>

            <?php if($payments):?>
                <a href="export_csv.php?id=<?=$_GET['id']?>" class="btn btn-primary">Export csv</a>
                <?php foreach($payments as $payment): ?>
                    <p><b>Source IBAN:</b>&nbsp<?php echo $payment["source_iban"]?></p>
                    <p><b>Destination IBAN:</b>&nbsp<?php echo $payment["destination_iban"]?></p>
                    <p><b>Company:</b>&nbsp<?php echo $payment["company"]?></p>
                    <p><b>Details:</b>&nbsp<?php echo $payment["details"]?></p>
                    <hr>
                <?php endforeach; ?>

            <?php else:?>    
                <p>Nu exista nici o plata atasata la lista curenta.</p>
            <?php endif;?>

        </div>
    </div>
</body>