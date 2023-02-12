<?php

class DebutCompteProcessor
{

    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function insertDebutCompteData($debutCompteData)
    {
        $total = 0;
        foreach ($debutCompteData as $key => $value) {
            $query = $this->con->prepare("UPDATE users SET debutCompte = $value WHERE city LIKE '%$key%'");
            $query->execute();
            $total= $total + (int)$value;
        }

        $query = $this->con->prepare("UPDATE users SET debutCompte = $total WHERE city LIKE '%all%'");
        $query->execute();

        return true;
    }
}
