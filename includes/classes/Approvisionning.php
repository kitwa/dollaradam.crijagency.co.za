<?php

class Approvisionning
{
  private $con, $sqlData, $userLoggedInObj;

  public function __construct($con, $input, $userLoggedInObj)
  {
    $this->con = $con;
    $this->userLoggedInObj = $userLoggedInObj;

    if (is_array($input)) {
      $this->sqlData = $input;
    } else {
      $query = $this->con->prepare("SELECT * FROM approvisionning WHERE approvisionning.id = :id ");
      $query->bindParam(":id", $input);
      $query->execute();
      $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
  }
  

  public function createApprovisionningRow($transaction)
  {

    $transactionId = $transaction->getId();
    $montantEnvoyer =  $transaction->montantEnvoyer();
    $provenance = $transaction->provenance();
    $destination = $transaction->destination();

    $class = "";

    $uploadedBy = $transaction->uploadedBy();
    $date = $transaction->date();

    return "
        <tr class='$class'>
        <td>$transactionId</td>
        <td>$montantEnvoyer</td>
        <td>$provenance</td>
        <td>$destination</td>
        <td>$uploadedBy</td>
        <td>$date</td>
        </tr>
    ";
  }

  public function createDesapprovisionningRow($transaction)
  {

    $transactionId = $transaction->getId();
    $montantRetirer =  $transaction->montantRetirer();
    $provenance = $transaction->provenance();
    $destination = $transaction->destination();
    $commentaire = $transaction->commentaire();

    $class = "";

    $uploadedBy = $transaction->uploadedBy();
    $date = $transaction->date();

    return "
        <tr class='$class'>
        <td>$transactionId</td>
        <td>$montantRetirer</td>
        <td>$provenance</td>
        <td>$destination</td>
        <td>$commentaire</td>
        <td>$uploadedBy</td>
        <td>$date</td>
        </tr>
    ";
  }

  public function generateItemsFromTransactions($transactions)
  {
    $elementsHtml = "";

    foreach ($transactions as $transaction) {
      $elementsHtml .= $this->createApprovisionningRow($transaction);
    }

    return $elementsHtml;
  }

  public function generateItemsDesapprovisionning($transactions)
  {
    $elementsHtml = "";

    foreach ($transactions as $transaction) {
      $elementsHtml .= $this->createDesapprovisionningRow($transaction);
    }

    return $elementsHtml;
  }

  public function getId()
  {
    return $this->sqlData["id"];
  }

  public function uploadedBy()
  {
    return $this->sqlData["uploadedBy"];
  }

  public function montantEnvoyer()
  {
    return $this->sqlData["montantEnvoyer"];
  }

  public function provenance()
  {
    return $this->sqlData["provenance"];
  }
  public function destination()
  {
    return $this->sqlData["destination"];
  }

  public function date()
  {
    return $this->sqlData["date"];
  }

  public function getUserId()
  {
    return $this->sqlData["userId"];
  }

  public function getEtat()
  {
    return $this->sqlData["etat"];
  }

  public function montantRetirer()
  {
    return $this->sqlData["montantRetirer"];
  }

  public function commentaire()
  {
    return $this->sqlData["commentaire"];
  }

  public function deleteApprovisionning()
  {
        // delete code here
  }
}
