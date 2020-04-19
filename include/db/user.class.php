<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once 'database.class.php';

class User extends Database{
 
    public function create($user, $password, $isAdmin)
    {
        $data = [
            'isAdmin' => $isAdmin,
            'user' => $user,
            'password' => $password
        ];

        $query = $this->connection->prepare("insert into user (user, password,admin) values (:user, :password, :isAdmin)");
        $query->execute($data);
    }

    public function adminToBe($user, $password){ //Noemi

        $data = [
            'user' => $user,
            'password' => $password
        ];

        $query = $this->connection->prepare("insert into user (user, password, admin) values (:user, :password, 1)");
        $query->execute($data);
    }

    public function getLogin($user, $password) //isAdmin?
    {
        $passwordHash = sha1($password);

        $data = [
            'user' => $user,
            'password' => $passwordHash
        ];

        $query = $this->connection->prepare("select * from user where user = :user and  password = :password");
        $query->execute($data);
        
        return $query->fetch();
    }

    public function updatePassword($id, $password){

        $data = [
            'id' => $id,
            'password' => $password
        ];

        $query = $this->connection->prepare("update user set password= :password where id= :id");
        $query->execute($data);
    }
    public function isAdmin($user, $password){ //Noemi
        $passwordHash = sha1($password);

        $data = [
            'user' => $user,
            'password' => $passwordHash
        ];

        $query = $this->connection->prepare("select admin from user where user = :user and  password = :password");
        $query->execute($data);

        return $query->fetch();
    }

    public function get($id)
    {
        $data = [
            'id' => $id,
        ];

        $query = $this->connection->prepare("select * from user where id =:id ");
        $query->execute($data);
        
        return $query->fetch(); 
    }

    public function getAll()
    {
        $query = $this->connection->query("select * from user");

        return $query->fetchAll();
    }

    public function update($id, $user, $password)
    {
        $data = [
            'user' => $user,
            'password' => $password,
            'id' => $id,
        ];
        
        $query = $this->connection->prepare("update user set user= :user, password= :password where id= :id");
        $query->execute($data);
    }

    public function delete($id)
    {
        $data = [
            'id'=> $id,
        ]; 

        $query = $this->connection->prepare("delete from user where id = :id");
        $query->execute($data);
    }
}

// $userDb = new User();

// $userDb->create("Ionut", "Vasi");

// $userGet = $userDb->getAll();
// print_r($userGet);

// $userDb->delete(1);