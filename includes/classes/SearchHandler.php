<?php

class SearchHandler {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

    }

    public function getProperties($text, $orderBy) {
        $query = $this->con->prepare("SELECT * 

         FROM transaction WHERE title LIKE CONCAT('%', :text, '%')
        OR uploadedBy LIKE CONCAT('%', :text, '%') OR description LIKE CONCAT('%', :text, '%')  ORDER BY $orderBy DESC") ;

        $query->bindParam(":text", $text);
        $query->execute();

        $properties = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $property = new Transaction($this->con, $row, $this->userLoggedInObj);
            array_push($properties, $property);
        }

        return $properties;
    }
}
