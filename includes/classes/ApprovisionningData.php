<?php
class ApprovisionningData {

    public $montantEnvoyer, $provenance, $destination, $userId, $uploadedBy;

    public function __construct($montantEnvoyer, $provenance, $destination, $userId, $uploadedBy){

        $this->montantEnvoyer = $montantEnvoyer;
        $this->provenance = $provenance;
        $this->destination = $destination;
        $this->userId = $userId;
        $this->uploadedBy = $uploadedBy;
    }
}


class DesapprovisionningData {

    public $montantRetirer, $provenance, $destination, $commentaire,  $userId, $uploadedBy;

    public function __construct($montantRetirer, $provenance, $destination, $commentaire, $userId, $uploadedBy){

        $this->montantRetirer = $montantRetirer;
        $this->provenance = $provenance;
        $this->destination = $destination;
        $this->commentaire = $commentaire;
        $this->userId = $userId;
        $this->uploadedBy = $uploadedBy;
    }
}
?>
