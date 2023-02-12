<?php

class DashboardHandler {

    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function getTransactions() {
        $query = $this->con->prepare("SELECT * FROM agency.transaction LEFT JOIN users on users.id = transaction.userId WHERE userId = $userId AND users.city LIKE '%$city%' OR transaction.destination LIKE '%$city%' ORDER BY date DESC") ;
        $query->execute();

        $transactions = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $property = new Transaction($this->con, $row, null);
            array_push($transactions, $property);
        }

        return $transactions;

    }

}

?>