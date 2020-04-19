<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
if(!isset($_SESSION['auth'])) {
    header('Location: login.php');
}

include 'include/db/payment_details.class.php';


if(isset($_GET['id'])) {
    $paymentDetailsDb = new PaymentDetails();
    try {
        $paymentDetailsDb = new PaymentDetails();
        $payments= $paymentDetailsDb->getAll($_GET['id']);
    } catch(Exception $e) {
        $payments = [];
    }

    $filepath = 'temp_'.uniqid().'.csv';

    $output = fopen($filepath, 'w+');
    fputcsv($output, ["Source IBAN", "Destination IBAN", "Amount", "Company", "Details"]);

    foreach($payments as $paymentDetail) {
        fputcsv($output, [$paymentDetail['source_iban'], $paymentDetail['destination_iban'], $paymentDetail['amount'], $paymentDetail['company'], $paymentDetail['details']]);
    }

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    @unlink($filepath);
    die();

} else {
    header("Location: paymenthistory.php");
}
?>