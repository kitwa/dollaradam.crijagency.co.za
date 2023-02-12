<?php
require_once("includes/header.php");
require_once("includes/classes/HomeHandler.php");

// if (isset($_SESSION["userLoggedIn"]) || isset($_COOKIE["CrijCookie"])) {
if (!isset($_COOKIE["CrijC"])) {
  header("Location: signin.php");
}

$HomeHandler = new HomeHandler($con);
$userId = $userLoggedInObj->getUserId();
$city = $userLoggedInObj->getCity();

$du = "";
$au = "";
$text="";
$etat = "depot";
$villeagenceprovenance = "";
$villeagencedestination = "";

if (isset($_POST["du"])) {
  $du = $_POST["du"];
}
if (isset($_POST["au"])) {
  $au = $_POST["au"];
}

if (isset($_POST["text"])) {
  $text = $_POST["text"];
}

if (isset($_POST["etat"])) {
  $etat = $_POST["etat"];
}

if (isset($_POST["villeagenceprovenance"])) {
  $villeagenceprovenance = $_POST["villeagenceprovenance"];
}

if (isset($_POST["villeagencedestination"])) {
  $villeagencedestination = $_POST["villeagencedestination"];
}

$debutCompte = null;
$debutCompte = $HomeHandler->getDebutCompte($city);
if ($userId == 999) {
  $transactions = $HomeHandler->getTransactionsAll();
  $stats = $HomeHandler->getTransactionsStats($du = null, $au = null);
} else if (isset($_POST["voir"])) {
  $transactions = $HomeHandler->getTransactionsDuAu($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination);
  $stats = $HomeHandler->getTransactionsDuAuStats($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination);
} else if (isset($_POST["rechercher"])) {
  $transactions = $HomeHandler->getTransactionsSearch($text);
} else {
  // $transactions = $HomeHandler->getTransactions($userId, $city);

  $transactions = $HomeHandler->getTransactionsDuAu($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination);
  $stats = $HomeHandler->getTransactionsDuAuStats($du, $au, $etat, $city, $villeagenceprovenance, $villeagencedestination);

  $checkBalance = $HomeHandler->getTransactionsDuAuStats($du, $au, "nonretire", $city, $villeagenceprovenance, $villeagencedestination);
}

$transaction = new Transaction($con, $transactions, null);

?>

<div class="container mb-70">

    <?php 
    if(isset($checkBalance)) {
      $stat = $checkBalance[0]->sqlData;
      $montantEnvoyerGeneral = isset($stat['montantEnvoyerGeneral']) ? $montantEnvoyerGeneral = $stat['montantEnvoyerGeneral'] : $montantEnvoyerGeneral = 0;
      $debutCompte1 = $debutCompte[0]->sqlData;
      $debutC = $debutCompte1["debutCompte"];
      $restSurPlace = (int)$debutC - (int)$montantEnvoyerGeneral;

      if ($restSurPlace <= 5000000) {
    ?>
    <div class="red lighten-2 center-align" style="padding: 0.5em; margin-top: 1em;">
    Attention vous devez demander un approvisonnement avant la fin de la journée, Le reste sur place apres tous les restraits est de: 
    <h4>
    <?php
      echo $restSurPlace;
      echo '</h4>
      </div>'
    ?>

<?php }}; ?>

  <div class="row pt-10">
    <form class="col s12 " method="POST" action="home.php">
      <div class="row">
        <div class="input-field col s6">
          <input id="du" type="date" name="du" class="validate" value="<?php echo $du ?>">
          <!-- value="<?php // echo date("Y-m-d");
                      ?>" -->
          <label for="du">Du</label>
        </div>
        <div class="input-field col s6">
          <input id="au" type="date" name="au" class="validate" value="<?php echo $au ?>">
          <label for="au">Au</label>
        </div>
        <div class="input-field col s6">
          <select name="etat" style="display: block;">
            <!-- <option value="tout">Tout</option> -->
            <option value="depot">MES DEPOTS</option>
            <!-- <option value="retrait">List Transaction A Retirer</option> -->
            <option value="nonretire">NON RETRAITS</option>
            <option value="retire">RETRAITS</option>
          </select>
        </div>
        <div class="input-field col s6">
          <select name="villeagenceprovenance" style="display: block;">
            <!-- <option value="tout">Tout</option> -->
            <option value="">Agence Provenance</option>
            <option value="lubumbashi">Lubumbashi</option>
            <option value="pweto">Pweto</option>
            <option value="lukozolo">Lukozolo</option>
            <option value="kilwa">Kilwa</option>
            <option value="kolwezi">Kolwezi</option>
          </select>
        </div>
        <div class="input-field col s6">
          <select name="villeagencedestination" style="display: block;">
            <!-- <option value="tout">Tout</option> -->
            <option value="">Agence Destination</option>
            <option value="lubumbashi">Lubumbashi</option>
            <option value="pweto">Pweto</option>
            <option value="lukozolo">Lukozolo</option>
            <option value="kilwa">Kilwa</option>
            <option value="kolwezi">Kolwezi</option>
          </select>
        </div>
        <div class="col s6">
          <input id="voir" name="voir" type="submit" value="voir" class="btn btn-small">
        </div>
        
      </div>
    </form>
  </div>

  <div class="row pt-10">
    <form class="col s12 " method="POST" action="home.php">

    <div class="row">
    <div class="col s12">
     <h5 class="text-center">Rechercher par nom du recepteur ou par code</h5>
    </div></div>

      <div class="row">

        <div class="input-field col s6">
        <input placeholder="Entrer le nom ou le code ici" id="text" name="text" type="search" class="validate" required >
        </div>

        <div class="col s6">
          <input id="rechercher" name="rechercher" type="submit" value="Rechercher" class="btn btn-small">
        </div>

      </div>

    </form>
  </div>

  <div class="row">
      <div class="col s6">
          <a href="finjournee.php" class="btn red">Fin de journee</a>
        </div>
  </div>

  <div class="row">
    <div class="col s12">
      <h1 class="green-text"><?php
              switch ($etat) {
                case 'nonretire':
                  echo 'NON RETRAITS';
                  break;
                case 'retire':
                  echo 'RETRAITS';
                  break;
                default:
                  echo 'MES DEPOTS';
                  break;
              }
          ?></h1>
    </div>
  </div>

  <? //php }?>

  <table class="highlight">
    <thead>
      <tr>
        <th>N* Transaction</th>
        <th>Montant Envoyé</th>
        <th>Frais Transfert(%)</th>
        <th>Total</th>
        <th>Expediteur</th>
        <th>Recepteur</th>
        <th>Provenance</th>
        <th>Destination</th>
        <th>Ajouter Par</th>
        <th>Code</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

      <div class="row">

        <?php

        if(isset($stats)){
          echo $transaction->createStatRow($stats, $debutCompte);
        }

        echo $transaction->generateItemsFromTransactions($transactions); 
        ?>

      </div>

    </tbody>
  </table>

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large teal" href="publier.php">
      <i class="large material-icons">add</i>
    </a>
    <!-- <ul>
    <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>

  </ul> -->
  </div>


</div>

<?php // require_once("includes/appfooter.php"); 
?>


<?php require_once("includes/footer.php"); ?>