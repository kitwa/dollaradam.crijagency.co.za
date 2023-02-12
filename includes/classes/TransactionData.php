<?php
class TransactionData {

    public $montantEnvoyer, $montantTotal, $expediteur, $recepteur, $provenance, $destination, $code, $userId, $uploadedBy;

    public function __construct($montantEnvoyer, $montantTotal, $expediteur, $recepteur, $provenance, $destination, $code, $userId, $uploadedBy){

        $this->montantEnvoyer = $montantEnvoyer;
        $this->montantTotal = $montantTotal;
        $this->expediteur = $expediteur;
        $this->recepteur = $recepteur;
        $this->provenance = $provenance;
        $this->destination = $destination;
        $this->code = $code;
        $this->userId = $userId;
        $this->uploadedBy = $uploadedBy;
        

    }

}

?>