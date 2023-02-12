
<?php
class FinJourneeHandler
{

  private $con;

  public function __construct($con)
  {
    $this->con = $con;
  }

  public function postData()
  {
    $arrayCity = array("lubumbashi", "pweto", "kilwa", "lukozolo", "kolwezi");

    $query = $this->con->prepare("SELECT date FROM capital order by date DESC LIMIT 1");
    $query->execute();
    $date = $query->fetch(PDO::FETCH_ASSOC);

    if ($date == false || $date["date"] < date("Y-m-d")) {
      foreach ($arrayCity as $city) {
        $this->insertData($city);
      }
    } else {
      foreach ($arrayCity as $city) {
        $this->updateData($city);
      }
    }
  }

  private function updateData($city)
  {

    $date = date("Y-m-d");
    $where = " WHERE deleted = 0 AND etat = 0 AND destination LIKE '%$city%'";

    $query = $this->con->prepare("SELECT count(*) as numberOfTransactions, sum(montantEnvoyer) as montantEnvoyerGeneral, sum(montantTotal) as monatantTotalGeneral, (sum(montantTotal) - sum(montantEnvoyer)) as Benefice FROM transaction" . $where);
    $query->execute();

    $stat = $query->fetch(PDO::FETCH_ASSOC);

    $query1 = $this->con->prepare("SELECT (sum(montantTotal) - sum(montantEnvoyer)) as totalBeneficeEnvoyer FROM transaction WHERE deleted = 0 AND provenance LIKE '%$city%'");
    $query1->execute();

    $totalBeneficeEnvoyer = $query1->fetch(PDO::FETCH_ASSOC);

    $query2 = $this->con->prepare("SELECT sum(montantEnvoyer) as totalAdmin FROM transaction WHERE etat = 0");
    $query2->execute();

    $row2 = $query2->fetch(PDO::FETCH_ASSOC);
    // get transaction data to be marque as retirer
    $query3 = $this->con->prepare("SELECT sum(debutCompte) as debutCompteAll FROM users WHERE id != 999");
    $query3->execute();
    $debutCompteTotal = $query3->fetch(PDO::FETCH_ASSOC);

    //  calculate new debutCompte
    $restTotalCapital = (int)$debutCompteTotal["debutCompteAll"] - (int)$row2["totalAdmin"];


    // get debut de compte to calculate reste sur place city
    $query4 = $this->con->prepare("SELECT debutCompte FROM users WHERE city LIKE '%$city%'");
    $query4->execute();

    $row4 = $query4->fetch(PDO::FETCH_ASSOC);
    $restePlaceCity = (int)$row4["debutCompte"] - (int)$stat["montantEnvoyerGeneral"];

    $numberOfTransactions = $stat["numberOfTransactions"];
    $benefice = $stat["Benefice"];
    $totalBeneficeEnvoyer = $totalBeneficeEnvoyer["totalBeneficeEnvoyer"];
    $montantEnvoyerGeneral = $stat["montantEnvoyerGeneral"];
    $montantTotalGeneral = $stat["monatantTotalGeneral"];


    $query4 = $this->con->prepare("UPDATE `capital` SET
        `uploadedBy` = '$city',
        `numberOfTransactions` = '$numberOfTransactions',
        `montantEnvoyerGeneral` = '$montantEnvoyerGeneral',
        `montantTotalGeneral` = '$montantTotalGeneral',
        `Benefice` = '$benefice',
        -- `totalBeneficeEnvoyer` = '$totalBeneficeEnvoyer',
        `restTotalCapital` = '$restTotalCapital',
        `restePlaceCity` = '$restePlaceCity' WHERE `date` = '$date' AND uploadedBy LIKE '%$city%'");

    $success = $query4->execute();

    return $success;
  }

  private function insertData($city)
  {

    $date = date("Y-m-d");
    $where = " WHERE deleted = 0 AND etat = 0 AND destination LIKE '%$city%'";

    $query = $this->con->prepare("SELECT count(*) as numberOfTransactions, sum(montantEnvoyer) as montantEnvoyerGeneral, sum(montantTotal) as monatantTotalGeneral, (sum(montantTotal) - sum(montantEnvoyer)) as Benefice FROM transaction" . $where);
    $query->execute();

    $stat = $query->fetch(PDO::FETCH_ASSOC);

    $query1 = $this->con->prepare("SELECT (sum(montantTotal) - sum(montantEnvoyer)) as totalBeneficeEnvoyer FROM transaction WHERE deleted = 0 AND provenance LIKE '%$city%'");
    $query1->execute();

    $totalBeneficeEnvoyer = $query1->fetch(PDO::FETCH_ASSOC);

    $query2 = $this->con->prepare("SELECT sum(montantEnvoyer) as totalAdmin FROM transaction WHERE etat = 0");
    $query2->execute();

    $row2 = $query2->fetch(PDO::FETCH_ASSOC);
    // get transaction data to be marque as retirer
    $query3 = $this->con->prepare("SELECT sum(debutCompte) as debutCompteAll FROM users WHERE id != 999");
    $query3->execute();
    $debutCompteTotal = $query3->fetch(PDO::FETCH_ASSOC);

    //  calculate new debutCompte
    $restTotalCapital = (int)$debutCompteTotal["debutCompteAll"] - (int)$row2["totalAdmin"];


    // get debut de compte to calculate reste sur place city
    $query4 = $this->con->prepare("SELECT debutCompte FROM users WHERE city LIKE '%$city%'");
    $query4->execute();

    $row4 = $query4->fetch(PDO::FETCH_ASSOC);
    $restePlaceCity = (int)$row4["debutCompte"] - (int)$stat["montantEnvoyerGeneral"];

    $numberOfTransactions = $stat["numberOfTransactions"];
    $benefice = $stat["Benefice"];
    $totalBeneficeEnvoyer = $totalBeneficeEnvoyer["totalBeneficeEnvoyer"];
    $montantEnvoyerGeneral = $stat["montantEnvoyerGeneral"];
    $montantTotalGeneral = $stat["monatantTotalGeneral"];


    $query4 = $this->con->prepare("INSERT INTO `capital` (
        `uploadedBy`,
        `numberOfTransactions`,
        `montantEnvoyerGeneral`,
        `montantTotalGeneral`,
        `Benefice`,
        -- `totalBeneficeEnvoyer`,
        `restTotalCapital`,
        `restePlaceCity`,
        `date`)
        VALUES
        ('$city',
        '$numberOfTransactions',
        '$montantEnvoyerGeneral',
        '$montantTotalGeneral',
        '$benefice',
        -- '$totalBeneficeEnvoyer',
        '$restTotalCapital',
        '$restePlaceCity',
        '$date'
        ); ");

    $success = $query4->execute();

    return $success;
  }

  public function getData()
  {
    $query = $this->con->prepare("SELECT * FROM capital ORDER BY id DESC LIMIT 100");
    $query->execute();

    $result = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      array_push($result, $row);
    }

    return $this->generateItemsFromTransactions($result);
  }

  public function generateItemsFromTransactions($transactions)
  {
    $elementsHtml = "";

    foreach ($transactions as $transaction) {
      $elementsHtml .= $this->createRow($transaction);
    }

    return $elementsHtml;
  }

  public function createRow($transaction)
  {

    $uploadedBy = $transaction["uploadedBy"];
    // $numberOfTransactions = $transaction["numberOfTransactions"];
    $montantEnvoyerGeneral =  $transaction["montantEnvoyerGeneral"];
    $montantTotalGeneral = $transaction["montantTotalGeneral"];
    $Benefice = $transaction["Benefice"];
    $restePlaceCity = $transaction["restePlaceCity"];
    $restTotalCapital = $transaction["restTotalCapital"];
    $date = $transaction["date"];
    $class = "";

    return "
        <tr class='$class'>
        <td>$uploadedBy</td>
        <td>$montantEnvoyerGeneral</td>
        <td>$montantTotalGeneral</td>
        <td>$Benefice</td>
        <td>$restePlaceCity</td>
        <td>$restTotalCapital</td>
        <td>$date</td>
        </tr>
    ";
  }
}



?>