<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once 'database.class.php';

class Payment extends Database{
 
    public function create($date, $details)
    {
        $data = [
            'date' => $date,
            'details' => $details,
        ];

        $query = $this->connection->prepare("insert into payments (date,details) values (:date, :details)");
        $query->execute($data);
    }

    function get($id)
    {
        $data = [
            'id' => $id,
        ];

        $query = $this->connection->prepare("select * from payments where id =:id ");
        $query->execute($data);
        
        return $query->fetch(); 
    }

    function getAll()
    {
        $query = $this->connection->query("select * from payments");

        return $query->fetchAll();
    }

    function delete($id)
    {
        $data = [
            'id'=> $id,
        ]; 

        $query = $this->connection->prepare("delete from payments where id = :id");
        $query->execute($data);
    }

    function update($date, $id, $details)
    {
        $data = [
            'details' => $details,
            'date' => $date,
            'id' => $id,
        ];
        
        $query = $this->connection->prepare("update payments set date= :date, details= :details where id= :id");
        $query->execute($data);
    }
}

// $paymentsDb = new Payment();
// $paymentsDb->create('2018/11/11');

// $paymentsGet = $paymentsDb->get(1);
// print_r($paymentsGet);

// $paymentsGetAll = $paymentsDb->getAll();
// print_r($paymentsGetAll);

// $paymentsDb->delete(1);

// $paymentsDb->update('2020-09-09',2);