<?php

class Transaction
{
  private $con, $userLoggedInObj;
  public $sqlData;

  public function __construct($con, $input, $userLoggedInObj)
  {
    $this->con = $con;
    $this->userLoggedInObj = $userLoggedInObj;

    if (is_array($input)) {
      $this->sqlData = $input;
    } else {
      $query = $this->con->prepare("SELECT * FROM transaction WHERE transaction.id = :id ");
      $query->bindParam(":id", $input);
      $query->execute();
      $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function createStatRow($stats, $debutCompte)
  {

    $villeagence = "";

    if(isset($_POST["villeagence"])) {
      $villeagence = $_POST["villeagence"];
    };

    $totalRestPlace = "";
    $totalAdmin = "";
    if (isset($stats[1]) && $_COOKIE["CrijC"] == "0813516102") {
      $totalAdmin = $stats[1];
      $totalRestPlace = "<div class='col s6'>
      <div class='card grey darken-3'>
        <div class='card-content white-text'>
          <span class=''>Total Reste sur place (Capital)</span>
          <p>$totalAdmin</p>
        </div>
      </div>
    </div>";
    }

    $filterPost = "Envoyé";

    if(isset($_POST["etat"]) && $_POST["etat"] == "nonretire") {
      $filterPost = "Non Retiré";
    };

    if(isset($_POST["etat"]) && $_POST["etat"] == "retire") {
      $filterPost = "Retiré";
    };


    $stat = $stats[0]->sqlData;
    $numberOfTransactions = $stat['numberOfTransactions'];
    $montantEnvoyerGeneral = isset($stat['montantEnvoyerGeneral']) ? $montantEnvoyerGeneral = $stat['montantEnvoyerGeneral'] : $montantEnvoyerGeneral = 0;
    $montantTotalGeneral = isset($stat['monatantTotalGeneral']) ? $montantTotalGeneral = $stat['monatantTotalGeneral'] : $montantTotalGeneral = 0;
    $benefice = isset($stat['Benefice']) ? $benefice = $stat['Benefice'] : $benefice = 0;

    $debutC = "Choisir la ville de l'agence";
    $restSurPlace = "Choisir non retraits";
    $rest = "";
    if (isset($debutCompte)) {
      $debutCompte1 = $debutCompte[0]->sqlData;
      $debutC = $debutCompte1["debutCompte"];
      if (isset($_POST["etat"]) && $_POST["etat"] == "nonretire") {
        $restSurPlace = (int)$debutC - (int)$montantEnvoyerGeneral;
        $rest =   "<div class='col s6'>
        <div class='card grey darken-3'>
          <div class='card-content white-text'>
            <span class=''>Reste sur place $villeagence</span>
            <p>$restSurPlace</p>
          </div>
        </div>
      </div>";
      }
    }

    return "
        <div class='row'>
        <div class='col s6'>
          <div class='card grey darken-3'>
            <div class='card-content white-text'>
              <span class=''>Transactions</span>
              <p>$numberOfTransactions</p>
            </div>
          </div>
        </div>
        <div class='col s6'>
        <div class='card grey darken-3'>
          <div class='card-content white-text'>
            <span class=''>Total $filterPost</span>
            <p>$montantEnvoyerGeneral</p>
          </div>
        </div>
      </div>
      <div class='col s6'>
      <div class='card grey darken-3'>
        <div class='card-content white-text'>
          <span class=''>Sous Total</span>
          <p>$montantTotalGeneral</p>
        </div>
      </div>
    </div>
    <div class='col s6'>
    <div class='card grey darken-3'>
      <div class='card-content white-text'>
        <span class=''>Frais Transfert(%)</span>
        <p>$benefice</p>
      </div>
    </div>
  </div>

$rest

<div class='col s6'>
<div class='card grey darken-3'>
  <div class='card-content white-text'>
    <span class=''>Total General</span>
    <p>$debutC</p>
  </div>
</div>
</div>

$totalRestPlace

      </div>
        ";
  }

  public function createTransactionRow($transaction)
  {
    $urlDelete = "deletearticle.php?id=" . $transaction->getId();
    $withdraw = "withdraw.php?id=" . $transaction->getId();
    $transactionId = $transaction->getId();
    $montantEnvoyer =  $transaction->montantEnvoyer();
    $montantTotal = $transaction->montantTotal();
    $gain = $montantTotal - $montantEnvoyer;
    $expediteur =  $transaction->expediteur();
    $recepteur = $transaction->recepteur();
    $provenance = $transaction->provenance();
    $destination = $transaction->destination();
    $code = $transaction->code();
    $etat = $transaction->getEtat();

    $model1 = "model" . $transaction->getId();
    $model2 = "model" . $transaction->getId() . "2";

    $class = "";
    if ($etat == 1) {
      $class = "green lighten-4";
    }
    $uploadedBy = $transaction->uploadedBy();
    $date = $transaction->date();
    $deleteRow = "";
    $retirerRow = "<td><i class='material-icons'>close</i></td>";

    if ($_COOKIE["CrijC"] == "0813516102") {
      $deleteRow = "<td> <a class='secondary-content modal-trigger' data-target='$model1'><span class='waves-effect waves-light btn'>Supprimer</span></a></td>";
    }

    if ($_COOKIE["CrijC"] == "0640490820" && $destination == "lubumbashi") {
      if ($etat == 0) {
        $retirerRow = "<td> <a class='secondary-content modal-trigger' data-target='$model2' ><span class='waves-effect waves-light btn'>Retirer</span></a></td>";
      } else {
        $retirerRow = "<td><a class='waves-effect waves-light btn-small'>Déjà Retiré</a></td>";
      }
    }

    if ($_COOKIE["CrijC"] == "0640490821" && $destination == "pweto") {
      if ($etat == 0) {
        $retirerRow = "<td> <a class='secondary-content modal-trigger' data-target='$model2' ><span class='waves-effect waves-light btn'>Retirer</span></a></td>";
      } else {
        $retirerRow = "<td><a class='waves-effect waves-light btn-small'>Déjà Retiré</a></td>";
      }
    }

    if ($_COOKIE["CrijC"] == "0640490822" && $destination == "kilwa") {
      if ($etat == 0) {
        $retirerRow = "<td> <a class='secondary-content modal-trigger' data-target='$model2' ><span class='waves-effect waves-light btn'>Retirer</span></a></td>";
      } else {
        $retirerRow = "<td><a class='waves-effect waves-light btn-small'>Déjà Retiré</a></td>";
      }
    }

    if ($_COOKIE["CrijC"] == "0640490823" && $destination == "lukozolo") {
      if ($etat == 0) {
        $retirerRow = "<td> <a class='secondary-content modal-trigger' data-target='$model2' ><span class='waves-effect waves-light btn'>Retirer</span></a></td>";
      } else {
        $retirerRow = "<td><a class='waves-effect waves-light btn-small'>Déjà Retiré</a></td>";
      }
    }

    if ($_COOKIE["CrijC"] == "0640490824" && $destination == "kolwezi") {
      if ($etat == 0) {
        $retirerRow = "<td> <a class='secondary-content modal-trigger' data-target='$model2' ><span class='waves-effect waves-light btn'>Retirer</span></a></td>";
      } else {
        $retirerRow = "<td><a class='waves-effect waves-light btn-small'>Déjà Retiré</a></td>";
      }
    }

    return "
        <tr class='$class'>
        <td>$transactionId</td>
        <td>$montantEnvoyer</td>
        <td>$gain</td>
        <td>$montantTotal</td>
        <td>$expediteur</td>
        <td>$recepteur</td>
        <td>$provenance</td>
        <td>$destination</td>
        <td>$uploadedBy</td>
        <td>$code</td>
        <td>$date</td>
        $retirerRow
        $deleteRow
        </tr>
        <div id='$model1' class='modal'>
            <div class='modal-content'>
                <h4>Supprimer cette entree?</h4>
                <p>Voulez-vous vraiment supprimer cette entree?</p>
            </div>
            <div class='modal-footer'>
                <a class='modal-close waves-effect waves-green btn-flat'>Non</a>
                <a href='$urlDelete' class='modal-close waves-effect waves-green btn-flat'>Oui</a>
            </div>
        </div>
        <div id='$model2' class='modal'>
        <div class='modal-content'>
            <h4>Marquer comme retirer cette entree?</h4>
            <p>Voulez-vous vraiment marquer comme retirer cette transaction?</p>
        </div>
        <div class='modal-footer'>
            <a class='modal-close waves-effect waves-green btn-flat'>Non</a>
            <a href='$withdraw' class='modal-close waves-effect waves-green btn-flat'>Oui</a>
        </div>
    </div>
    ";
  }

  public function generateItemsFromTransactions($transactions)
  {
    $elementsHtml = "";

    foreach ($transactions as $transaction) {
      $elementsHtml .= $this->createTransactionRow($transaction);
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

  public function montantRetirer()
  {
    return $this->sqlData["montantRetirer"];
  }

  public function commentaire()
  {
    return $this->sqlData["commentaire"];
  }


  public function montantTotal()
  {
    return $this->sqlData["montantTotal"];
  }
  public function expediteur()
  {
    return $this->sqlData["expediteur"];
  }

  public function recepteur()
  {
    return $this->sqlData["recepteur"];
  }

  public function provenance()
  {
    return $this->sqlData["provenance"];
  }
  public function destination()
  {
    return $this->sqlData["destination"];
  }

  public function code()
  {
    return $this->sqlData["code"];
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

  public function deleteTransaction()
  {
    $userId = $this->getUserId();
    if (isset($userId)) {
      $transactionId = $this->getId();
      $query = $this->con->prepare("SELECT id FROM `transaction` WHERE id=$transactionId AND userId = $userId;");
      $transactionIdToDelete = $query->execute();
      if (isset($transactionIdToDelete)) {

        // get transaction data to delete
        $query3 = $this->con->prepare("SELECT montantTotal FROM transaction WHERE id = $transactionId");
        $query3->execute();
        $montantTotalTransaction = $query3->fetch(PDO::FETCH_ASSOC);

        // delete transaction
        $query1 = $this->con->prepare("DELETE FROM `transaction` WHERE `id`=$transactionId;");
        $result = $query1->execute();



        if (isset($result)) {


          $currentCity = $this->sqlData["provenance"];
          // get current user debutCompte
          $query2 = $this->con->prepare("SELECT debutCompte FROM users WHERE city LIKE '%$currentCity%'");
          $query2->execute();
          $debutCompteUser = $query2->fetch(PDO::FETCH_ASSOC);

          //  calculate new debutCompte
          $debutCompteUpdated = (int)$debutCompteUser["debutCompte"] - (int)$montantTotalTransaction["montantTotal"];

          // update debutCompte
          $query4 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteUpdated WHERE city LIKE '%$currentCity%'");
          $query4->execute();

          // get debutCompte total
          $query5 = $this->con->prepare("SELECT debutCompte FROM users WHERE id = 999");
          $query5->execute();
          $debutCompteAll = $query5->fetch(PDO::FETCH_ASSOC);

          //  calculate new debutCompte
          $debutCompteUpdatedAll = (int)$debutCompteAll["debutCompte"] - (int)$montantTotalTransaction["montantTotal"];

          // update debutCompteAll
          $query6 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteUpdatedAll WHERE id = 999");
          $query6->execute();
        }
        return true;
      } else {
        echo "  <div class='row'>
                <div class='col s12'>
                  <div class='card white darken-1'>
                    <div class='card-content green-text'>
                      <h5 class='center-align'><span class=' '><i class='material-icons Large'>check_circle</i></span></h5><br>
                      <h5 class='center-align'>Vous n'êtes pas autorisés à éffectué cette action.</h5>
                    </div>
                    <div class='card-action'>
                      <a href='articles.php' class='blue-text'>Cliquez Ici pour retourner aux articles.</a>
                    </div>
                  </div>
                </div>
                </div>
                <div class='progress'>
                <div class='indeterminate'></div>
                </div>";
        return false;
      }
      return true;
    } else {
      echo "  <div class='row'>
            <div class='col s12'>
              <div class='card white darken-1'>
                <div class='card-content green-text'>
                  <h5 class='center-align'><span class=' '><i class='material-icons Large'>check_circle</i></span></h5><br>
                  <h5 class='center-align'>Vous n'êtes pas autorisés à éffectué cette action.</h5>
                </div>
                <div class='card-action'>
                  <a href='articles.php' class='blue-text'>Cliquez Ici pour retourner aux articles.</a>
                </div>
              </div>
            </div>
            </div>
            <div class='progress'>
            <div class='indeterminate'></div>
            </div>";

      return false;
    }
  }

  public function marquerCommeRetirer()
  {
    $userId = $this->getUserId();
    if (isset($userId)) {
      $transactionId = $this->getId();
      $query = $this->con->prepare("SELECT id FROM `transaction` WHERE id=$transactionId AND userId = $userId;");
      $id = $query->execute();
      if (isset($id)) {
        $query1 = $this->con->prepare("UPDATE `transaction` SET `etat`='1' WHERE `id`=$transactionId;");
        $result = $query1->execute();

        if (isset($result)) {

          $currentCity = $this->sqlData["destination"];
          // get current user debutCompte
          $query2 = $this->con->prepare("SELECT debutCompte FROM users WHERE city LIKE '%$currentCity%'");
          $query2->execute();
          $debutCompteUser = $query2->fetch(PDO::FETCH_ASSOC);

          // get transaction data to be marque as retirer
          $query3 = $this->con->prepare("SELECT montantEnvoyer FROM transaction WHERE id = $transactionId");
          $query3->execute();
          $montantEnvoyerTransaction = $query3->fetch(PDO::FETCH_ASSOC);

          //  calculate new debutCompte
          $debutCompteUpdated = (int)$debutCompteUser["debutCompte"] - (int)$montantEnvoyerTransaction["montantEnvoyer"];

          // update debutCompte
          $query4 = $this->con->prepare("UPDATE users SET debutCompte = $debutCompteUpdated WHERE city LIKE '%$currentCity%'");
          $query4->execute();
        }
        return true;
      } else {
        echo "  <div class='row'>
                <div class='col s12'>
                  <div class='card white darken-1'>
                    <div class='card-content green-text'>
                      <h5 class='center-align'><span class=' '><i class='material-icons Large'>check_circle</i></span></h5><br>
                      <h5 class='center-align'>Vous n'êtes pas autorisés à éffectué cette action.</h5>
                    </div>
                    <div class='card-action'>
                      <a href='home.php' class='blue-text'>Cliquez Ici pour retourner aux transactions.</a>
                    </div>
                  </div>
                </div>
                </div>
                <div class='progress'>
                <div class='indeterminate'></div>
                </div>";
        return false;
      }
      return true;
    } else {
      echo "  <div class='row'>
            <div class='col s12'>
              <div class='card white darken-1'>
                <div class='card-content green-text'>
                  <h5 class='center-align'><span class=' '><i class='material-icons Large'>check_circle</i></span></h5><br>
                  <h5 class='center-align'>Vous n'êtes pas autorisés à éffectué cette action.</h5>
                </div>
                <div class='card-action'>
                  <a href='home.php' class='blue-text'>Cliquez Ici pour retourner aux transactions.</a>
                </div>
              </div>
            </div>
            </div>
            <div class='progress'>
            <div class='indeterminate'></div>
            </div>";

      return false;
    }
  }
}
