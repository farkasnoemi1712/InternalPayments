<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once 'database.class.php';

class PaymentDetails extends Database{
 
    function create($idPayment, $sourceIban, $destinationIban, $amount, $company, $details)
    {
        $data = [
            'idPayment' => $idPayment,
            'sourceIban' => $sourceIban, 
            'destinationIban' => $destinationIban,
            'amount' => $amount,
            'company' => $company,
            'details' => $details,
        ];

        $query = $this->connection->prepare("insert into payment_details (id_payment, source_iban, destination_iban, amount, company, details) values
        (:idPayment, :sourceIban, :destinationIban, :amount, :company, :details)");
        $query->execute($data);
    }

    function get($id)
    {
        $data =[
            'id' => $id,
        ];

        $query = $this->connection->prepare("select * from payment_details where id= :id");
        $query->execute($data);

        return $query->fetch(); 
    }

    function getAll($id_payment)
    {
        $data = [
            'id_payment' => $id_payment,
        ];

        $query = $this->connection->prepare("select * from payment_details where id_payment= :id_payment");
        $query->execute($data);
        return $query->fetchAll();
    }

    function delete($id)
    {
        $data = [
            'id'=> $id,
        ]; 

        $query = $this->connection->prepare("delete from payment_details where id = :id");
        $query->execute($data);
    }

    function update($idPayment, $sourceIban, $destinationIban, $amount, $company, $details, $id)
    {
        $data = [
            'idPayment' => $idPayment,
            'sourceIban' => $sourceIban, 
            'destinationIban' => $destinationIban,
            'amount' => $amount,
            'company' => $company,
            'details' => $details,
            'id' => $id,
        ];
        
        $query = $this->connection->prepare("update payment_details set id_payment= :idPayment, source_iban= :sourceIban, 
        destination_iban= :destinationIban, amount= :amount, company= :company, details= :details where id= :id");
        $query->execute($data);
    }
}

// $paymentDetailsDb = new PaymentDetails();
// $paymentDetailsDb->create(2,'dasdas','dasd', 12.3, 'dsadas', 'dsadas');

// $paymentDetailsGet = $paymentDetailsDb->get(1);
// print_r($paymentDetailsGet);

// $paymentDetailsGetAll = $paymentDetailsDb->getAll();
// print_r($paymentDetailsGetAll);

// $paymentDetailsDb->delete(4);
// $paymentDetailsDb->update(8,'dasdas','dasd', 56.3, 'dsadas', 'dsadas',5);