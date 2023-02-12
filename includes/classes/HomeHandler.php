<?php

class HomeHandler {

    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function getTransactions($userId, $city) {

        $query = $this->con->prepare("SELECT * FROM transaction  WHERE (userId = $userId OR provenance LIKE '%$city%' OR destination LIKE '%$city%') AND deleted = 0 ORDER BY id DESC");
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;
    }

    public function getTransactionsAll(){

        $where = " WHERE deleted = 0";

        if(!isset($_POST["voir"])){

            $date = date("Y-m-d");
            $where .= " AND date = '$date'";
        }

        $query = $this->con->prepare("SELECT * FROM transaction $where ORDER BY id DESC") ;
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;
    }

    // public function getTransactionsTotalNoRetraits() {
        

    //     $query = $this->con->prepare("SELECT sum(montantTotal)  FROM transaction WHERE etat = 1" ) ;
    //     $query->execute();

    //     $total = array();
    //     while($row = $query->fetch(PDO::FETCH_ASSOC)){
    //         array_push($comptes, $row);
    //     };

    //     return $total;
    // }

    public function getTransactionsDuAu($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination) {
        
        $where = " WHERE deleted = 0";

        if(!isset($_POST["voir"])){

            $date = date("Y-m-d");
            $where .= " AND date = '$date'";
        }

        if($etat != "tout") {
   
            if(isset($du) && $du != ""){
                $where .= " AND date >= '$du'";
            }
            if(isset($au) && $au != "" && isset($du) && $du != ""){
                $where .= " AND date <= '$au'";
            }

            if(isset($villeagenceprovenance) && $villeagenceprovenance != ""){
                $where .= " AND provenance LIKE '%$villeagenceprovenance%'";
            }

            if(isset($villeagencedestination) && $villeagencedestination != ""){
                $where .= " AND destination LIKE '%$villeagencedestination%'";
            }
    
            if(isset($etat) && $etat != ""){
    
                switch ($etat) {
                    case 'depot':
                        $where .= " AND provenance LIKE '%$city%'";
                        break;
                    case 'nonretire':
                        $where .= " AND etat = 0 AND destination LIKE '%$city%'";
                        break;
                    case 'retire':
                        $where .= " AND etat = 1 AND destination LIKE '%$city%'";
                        break;
                    case 'retrait':
                        $where .= " AND destination LIKE '%$city%'";
                        break;
                }
            }
        }


        $where .= " ORDER BY id DESC";

        $query = $this->con->prepare("SELECT * FROM transaction" . $where) ;
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;
    }

    public function getTransactionsSearch($text) {
        $query = $this->con->prepare("SELECT * FROM transaction WHERE recepteur LIKE CONCAT('%', :text, '%')
        OR code LIKE CONCAT('%', :text, '%')") ;

        $query->bindParam(":text", $text);
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;
    }

    public function getTransactionsDuAuStats($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination) {
        
        $where = " WHERE deleted = 0";
        if($etat != "tout") {
   
            if(isset($du) && $du != ""){
                $where .= " AND date >= '$du'";
            }
            if(isset($au) && $au != "" && isset($du) && $du != ""){
                $where .= " AND date <= '$au'";
            }

            if(isset($villeagenceprovenance) && $villeagenceprovenance != ""){
                $where .= " AND provenance LIKE '%$villeagenceprovenance%'";
            }
    
            if(isset($villeagencedestination) && $villeagencedestination != ""){
                $where .= " AND destination LIKE '%$villeagencedestination%'";
            }

            if(isset($etat) && $etat != ""){
    
                switch ($etat) {
                    case 'depot':
                        $where .= " AND provenance LIKE '%$city%'";
                        break;
                    case 'nonretire':
                        $where .= " AND etat = 0 AND destination LIKE '%$city%'";
                        break;
                    case 'retire':
                        $where .= " AND etat = 1 AND destination LIKE '%$city%'";
                        break;
                    case 'retrait':
                        $where .= " AND destination LIKE '%$city%'";
                        break;
                }
            }
        }

        $where .= " ORDER BY id DESC";

        $query = $this->con->prepare("SELECT count(*) as numberOfTransactions, sum(montantEnvoyer) as montantEnvoyerGeneral, sum(montantTotal) as monatantTotalGeneral, (sum(montantTotal) - sum(montantEnvoyer)) as Benefice FROM transaction" . $where) ;
        $query->execute();

        $stats = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $stat = new Transaction($this->con, $row, null);
            array_push($stats, $stat);
        }

        
        $query2 = $this->con->prepare("SELECT sum(montantTotal) as totalAdmin FROM transaction WHERE etat = 0") ;
        $query2->execute();

        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
        // get transaction data to be marque as retirer
        $query3 = $this->con->prepare("SELECT sum(debutCompte) as debutCompteAll FROM users WHERE id != 999");
        $query3->execute();
        $debutCompteTotal = $query3->fetch(PDO::FETCH_ASSOC);

        //  calculate new debutCompte
        $restTotal = (int)$debutCompteTotal["debutCompteAll"] - (int)$row2["totalAdmin"];

        array_push($stats, $restTotal);

        return $stats;
    }

    public function getTransactionsStats($du, $au) {

        $where =" WHERE deleted = 0";
        if(isset($du)){
            $where .= " AND date >= '$du'";
        }
        if(isset($au) && isset($du)){
            $where .= " AND date <= '$au'";
        }

        $query = $this->con->prepare("SELECT count(*) as numberOfTransactions, sum(montantEnvoyer) as montantEnvoyerGeneral, sum(montantTotal) as monatantTotalGeneral, (sum(montantTotal) - sum(montantEnvoyer)) as Benefice FROM transaction" . $where) ;
        $query->execute();

        $stats = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $stat = new Transaction($this->con, $row, null);
            array_push($stats, $stat);
        }

        $query2 = $this->con->prepare("SELECT sum(montantEnvoyer) as totalAdmin FROM transaction WHERE etat = 0") ;
        $query2->execute();

        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
        // get transaction data to be marque as retirer
        $query3 = $this->con->prepare("SELECT sum(debutCompte) as debutCompteAll FROM users WHERE id != 999");
        $query3->execute();
        $debutCompteTotal = $query3->fetch(PDO::FETCH_ASSOC);

        //  calculate new debutCompte
        $restTotal = (int)$debutCompteTotal["debutCompteAll"] - (int)$row2["totalAdmin"];

        array_push($stats, $restTotal);

        return $stats;

    }

    public function getTransactionsDuAuStatsAdmin($du, $au, $villeagence) {

        $where =" WHERE deleted = 0";
        if(isset($villeagence)){
            $where .= " AND  (provenance LIKE '%$villeagence%')";
        }

        if($du != ""){
            $where .= " AND date >= '$du'";
        }
        if($au != "" && $du != ""){
            $where .= " AND date <= '$au'";
        }

        $query = $this->con->prepare("SELECT count(*) as numberOfTransactions, sum(montantEnvoyer) as montantEnvoyerGeneral, sum(montantTotal) as monatantTotalGeneral, (sum(montantTotal) - sum(montantEnvoyer)) as Benefice FROM transaction" . $where) ;
        $query->execute();

        $stats = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $stat = new Transaction($this->con, $row, null);
            array_push($stats, $stat);
        }

        return $stats;

    }

    public function getTransactionsDuAuAdmin($du, $au, $villeagence) {

        $where = " WHERE deleted = 0";

        if(!isset($_POST["voir"])){
            $date = date("Y-m-d");
            $where .= " AND date = '$date'";
        }

        if($du != ""){
            $where .= " AND date >= '$du'";
        }
        if($au != "" && $du != ""){
            $where .= " AND date <= '$au'";
        }

        $where .= " AND (provenance LIKE '%$villeagence%') ";
        $where .= " ORDER BY id DESC";

        $query = $this->con->prepare("SELECT * FROM transaction" . $where) ;
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;

    }

    public function getDebutCompte($villeagence) {

        $query = $this->con->prepare("SELECT debutCompte FROM users WHERE city LIKE '%$villeagence%'") ;
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $transaction = new Transaction($this->con, $row, null);
            array_push($transactions, $transaction);
        }

        return $transactions;
    }
}
