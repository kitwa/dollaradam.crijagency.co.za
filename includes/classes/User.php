<?php

class User {
    private $con, $sqlData;

    public function __construct($con, $phoneNumber){
        $this->con = $con;
        $query = $this->con->prepare("SELECT * FROM users WHERE phone_number = :phone_number");
        $query->bindParam(":phone_number", $phoneNumber);
        $query->execute();
    
        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getFirstName(){
        return $this->sqlData["firstName"];
    }

    public function getUserId(){
        return $this->sqlData["id"];
    }

    public function getCity(){
        return $this->sqlData["city"];
    }

    public function getFullName(){
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
    }

    public function getProfilePic(){
        return $this->sqlData["profilePic"];
    }

    
}
