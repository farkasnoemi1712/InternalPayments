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
    include 'include/db/payment.class.php';


    if(!empty($_POST['date']) && isset($_POST['details'])){
        
        try {
            
            $date = new DateTime($_POST['date']);
            $listDate = $date->format("Y-m-d"); 

            $paymentList = new Payment();
            $paymentList->create($listDate, $_POST['details']);

            header("Location: paymenthistory.php");

        } catch (Exception $e) {
            echo $e->getMessage();    
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
              <h3 class="mb-3">New payment</h3>
              <form method="post">
                <div class="form-group">
                    <label for="exampleInputPassword1">Date</label>
                    <input type="date" name="date" class="form-control" id="exampleInputPassword1" placeholder="Destination IBAN">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Details</label>
                    <input type="text" name="details" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Details">
                </div>
                <button type="submit" class="btn btn-primary">Add payment</button>
              </form>
              <div class="form-group">
                  <br>
              </div>
        </div>
    </div>
</body>