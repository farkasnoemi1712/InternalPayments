<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    session_start();
    if(!isset($_SESSION['auth'])) {
      header('Location: login.php');
    }

    if(!$_SESSION['admin']){
      header("Location: paymenthistory.php");
    }

    include 'include/views/head.php';
    include 'include/db/payment_details.class.php';
    include 'include/db/payment.class.php';
    
// daca lipseste $_GET[id] facem redirect catre paymenthistory
if(!isset($_GET['id'])) {
  header("Location: paymenthistory.php");
}

//  selectam tot din payment_details care au id_payment = $_GET['id']
$paymentDetailsDb = new PaymentDetails();
$paymentdetails = $paymentDetailsDb->getAll($_GET['id']);
//$paymentdelete = $paymentDetailsDb->delete($_GET['id']);


$paym = new Payment();
$pay = $paym->get($_GET['id']);
// $PaymentDate = $pay['date'];

// DELETE
if(!empty($_GET['delete_payment_details'])){
  // die($_GET['delete_payment_details']);

  // sterg din baza de date payment details de la id-ul respectiv
  $paymentDetailsDb->delete($_GET['delete_payment_details']);

  header("Location: editpayment.php?id=".$_GET['id']);
}

// UPDATE
if(!empty($_POST['update_payment']) && !empty($_POST['details']) ){
  // die('formular update lista plati');

  $paym->update($pay['date'], $pay['id'], $_POST['details']);
  header("Location: editpayment.php?id=".$_GET['id']);
}

// daca (if) e trimis formularul atunci introducem in baza de date payment_details si face redirect inapoi la editpayment.php?id=$_GET['id']
if (!empty($_POST['add_payment_details']) && !empty($_POST['source_iban']) && !empty($_POST['destination_iban']) && !empty($_POST['amount']) && !empty($_POST['company']) && isset($_POST['details']) ){ 
  try {
    $paymentDetailsDb = new PaymentDetails();
    $paymentDetailsDb->create($_POST['id_payment'],$_POST['source_iban'],$_POST['destination_iban'], $_POST['amount'],$_POST['company'],$_POST['details']);
    header("Location: editpayment.php?id=".$_POST['id_payment']);
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
          <h2>Plata noua</h2>
          <hr/>
          <h5>Detalii lista plati</h5>
            <form method="POST">
              <div class="form-group">
                <label for="exampleInputDate">Date</label>
                <input type="date" class="form-control" disabled="disabled" value="<?php echo $pay["date"] ?>" placeholder="Date">
              </div>
              <div class="form-group">
                <label for="exampleInputDetails">Details</label>
                <textarea name="details" class="form-control"><?php echo $pay["details"] ?></textarea>
              </div>
              <input type="hidden" name="update_payment" value="1" />
              <input type="hidden" name="id_payment" value="<?php echo $_GET['id']?>" /> 
              <div>
                <button type="submit" class="btn btn-primary">Modifica</button>
              </div>
            </form>

            <hr/>
            
            <button type="submit" class="btn btn-primary" onclick="showHideFormWrapper(); return false;">Adauga plata noua</button>
            <!-- <a href="#" onclick="showHideFormWrapper(); return false;">Adauga plata noua</a> -->
            <div style="display:none;" id="addNewPaymentFormWrapper">
            <br>
            <h5>Adauga plata noua</h5>
            <form method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Source IBAN</label>
                    <input type="text" name="source_iban" class="form-control" aria-describedby="emailHelp" placeholder="Source IBAN">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Destination IBAN </label>
                    <input type="text" name="destination_iban" class="form-control" placeholder="Destination IBAN">
                </div>
                <div class="form-group">
                        <label for="exampleInputPassword1">Amount</label>
                        <input type="text"  name="amount" class="form-control" placeholder="Amount">
                </div>
                <div class="form-group">
                        <label for="exampleInputPassword1">Company</label>
                        <input type="text"  name="company" class="form-control" placeholder="Company">
                </div>
                <div class="form-group">
                        <label for="exampleInputPassword1">Details</label>
                        <input type="text"  name="details" class="form-control"  placeholder="Details">
                </div>

                <input type="hidden" name="id_payment" value="<?php echo $_GET['id']?>" />    
                <input type="hidden" name="add_payment_details" value="1" />
                <button type="submit" class="btn btn-primary">Add payment</button>


            </form>
            <Br/><br/>
            </div>
        <?php if($paymentdetails):?>
            <a href="export_csv.php?id=<?=$_GET['id']?>" class="btn btn-primary">Export csv</a>
        <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Source IBAN</th>
                    <th scope="col">Destination IBAN</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Company</th>
                    <th scope="col">Details</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>

                <tbody>
                <?php foreach($paymentdetails as $payment): ?>
                  <tr>
                    <td>
                      <?php echo $payment['source_iban']?>
                    </td> 
                    <td>
                      <?php echo $payment['destination_iban']?>
                    </td>
                    <td>
                      <?php echo $payment['amount']?>
                    </td>
                    <td>
                      <?php echo $payment['company']?>
                    </td>  
                    <td>
                      <?php echo $payment['details']?>
                    </td>
                    <td>
                      <a href="editpayment.php?id=<?=$_GET['id']?>&delete_payment_details=<?=$payment['id']?>" class="btn btn-sm btn-primary">Delete</a>
                    </td>
                  <?php endforeach; ?>
                  </tr>
                </tbody>
           </table>
           <?php else:?>    
            <p>Nu exista nici o plata atasata la lista curenta.</p>
          <?php endif;?>      

</div> 
<script>

function showHideFormWrapper()
{
  var display = document.querySelector('#addNewPaymentFormWrapper').style.display;
  
  if(display == 'none') {
      document.querySelector('#addNewPaymentFormWrapper').style.display = 'block';
  } else {
      document.querySelector('#addNewPaymentFormWrapper').style.display = 'none';
  }

}

</script>
</body>
