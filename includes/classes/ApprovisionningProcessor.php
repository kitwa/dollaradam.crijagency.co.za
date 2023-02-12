<?php

class ApprovisionningProcessor {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function insertApprovisionningData($transaction) {
        $query = $this->con->prepare("INSERT INTO approvisionning (userId, uploadedBy, montantEnvoyer, provenance, destination, date)
        VALUES(:userId, :uploadedBy, :montantEnvoyer, :provenance, :destination, :date)");

        $date = date("Y-m-d");

        $query->bindParam(":userId", $transaction->userId);
        $query->bindParam(":uploadedBy", $transaction->uploadedBy);
        $query->bindParam(":montantEnvoyer", $transaction->montantEnvoyer);
        $query->bindParam(":provenance", $transaction->provenance);
        $query->bindParam(":destination", $transaction->destination);
        $query->bindParam(":date", $date);
        $query->execute();

        $query2 = $this->con->prepare("SELECT debutCompte FROM users WHERE firstName LIKE '%$transaction->destination%'");
        $query2->execute();
        $rowDestination = $query2->fetch(PDO::FETCH_ASSOC);

        $debutCompteProvenance = (int)$transaction->montantEnvoyer + (int)$rowDestination["debutCompte"];

        $query3 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteProvenance WHERE firstName LIKE '%$transaction->destination%'");

        $query3->execute();

        $query4 = $this->con->prepare("SELECT debutCompte FROM users WHERE firstName LIKE '%$transaction->provenance%'");
        $query4->execute();
        $rowProvenance = $query4->fetch(PDO::FETCH_ASSOC);

        $debutCompteUpdated = (int)$rowProvenance["debutCompte"] - (int)$transaction->montantEnvoyer;

        $query5 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteUpdated WHERE firstName LIKE '%$transaction->provenance%'");

        return $query5->execute();
    }

    public function insertDesapprovisionningData($transaction) {
        $query = $this->con->prepare("INSERT INTO desapprovisionning (userId, uploadedBy, montantRetirer, provenance, destination, commentaire, date)
        VALUES(:userId, :uploadedBy, :montantRetirer, :provenance, :destination, :commentaire, :date)");

        $date = date("Y-m-d");

        $query->bindParam(":userId", $transaction->userId);
        $query->bindParam(":uploadedBy", $transaction->uploadedBy);
        $query->bindParam(":montantRetirer", $transaction->montantRetirer);
        $query->bindParam(":provenance", $transaction->provenance);
        $query->bindParam(":destination", $transaction->destination);
        $query->bindParam(":commentaire", $transaction->commentaire);
        $query->bindParam(":date", $date);
        $query->execute();

        $query2 = $this->con->prepare("SELECT debutCompte FROM users WHERE firstName LIKE '%$transaction->destination%'");
        $query2->execute();
        $rowDestination = $query2->fetch(PDO::FETCH_ASSOC);

        $debutCompteProvenance = (int)$rowDestination["debutCompte"] - (int)$transaction->montantRetirer;

        $query3 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteProvenance WHERE firstName LIKE '%$transaction->destination%'");

        $query3->execute();

        // $query4 = $this->con->prepare("SELECT debutCompte FROM users WHERE firstName LIKE '%$transaction->provenance%'");
        // $query4->execute();
        // $rowProvenance = $query4->fetch(PDO::FETCH_ASSOC);

        // $debutCompteUpdated = (int)$rowProvenance["debutCompte"] - (int)$transaction->montantEnvoyer;

        // $query5 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteUpdated WHERE firstName LIKE '%$transaction->provenance%'");

        return $query3->execute();
    }

}
