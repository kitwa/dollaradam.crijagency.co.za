<?php

class TransactionProcessor {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function insertTransactionData($transaction) {
        $query = $this->con->prepare("INSERT INTO transaction( userId, uploadedBy, montantEnvoyer, montantTotal, expediteur,  recepteur, provenance, destination, code, date)
        VALUES( :userId, :uploadedBy, :montantEnvoyer, :montantTotal, :expediteur, :recepteur, :provenance, :destination, :code, :date) ");

        $date = date("Y-m-d");

        $query->bindParam(":userId", $transaction->userId);
        $query->bindParam(":uploadedBy", $transaction->uploadedBy);
        $query->bindParam(":montantEnvoyer", $transaction->montantEnvoyer);
        $query->bindParam(":montantTotal", $transaction->montantTotal);
        $query->bindParam(":expediteur", $transaction->expediteur);
        $query->bindParam(":recepteur", $transaction->recepteur);
        $query->bindParam(":provenance", $transaction->provenance);
        $query->bindParam(":destination", $transaction->destination);
        $query->bindParam(":code", $transaction->code);
        $query->bindParam(":date", $date);
        $query->execute();

        $query2 = $this->con->prepare("SELECT debutCompte FROM users WHERE id = $transaction->userId");
        $query2->execute();
        $rowProvenance = $query2->fetch(PDO::FETCH_ASSOC);

        $debutCompteProvenance = (int)$transaction->montantTotal + (int)$rowProvenance["debutCompte"];

        $query3 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteProvenance WHERE id = $transaction->userId");

        $query3->execute();

        $query4 = $this->con->prepare("SELECT debutCompte FROM users WHERE id = 999");

        $query4->execute();
        
        $rowAll = $query4->fetch(PDO::FETCH_ASSOC);

        $debutCompteAll = (int)$transaction->montantTotal + (int)$rowAll["debutCompte"];

        $query5 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteAll WHERE id = 999");

        return $query5->execute();

    }
}
