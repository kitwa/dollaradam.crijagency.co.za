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
$etat = "depot";
$villeagenceprovenance = "";
$etat = "";
$villeagence = "";
$debutCompte = null;
$total = null;

if (isset($_POST["du"])) {
  $du = $_POST["du"];
}

if (isset($_POST["au"])) {
  $au = $_POST["au"];
}

if (isset($_POST["villeagence"])) {
  $villeagence = $_POST["villeagence"];
}

if (isset($_POST["etat"])) {
  $etat = $_POST["etat"];
}

if ($userId == 999 && isset($_POST["voir"])) {
  $transactions = $HomeHandler->getTransactionsDuAuAdmin($du, $au, $villeagence);
  $stats = $HomeHandler->getTransactionsDuAuStats($du, $au, $etat, $villeagence, "", "");

  if (isset($_POST["villeagence"])) {
    $debutCompte = $HomeHandler->getDebutCompte($villeagence);
  }
} else {
  $transactions = $HomeHandler->getTransactionsAll();
  $stats = $HomeHandler->getTransactionsStats($du = null, $au = null);
}

$transaction = new Transaction($con, $transactions, null);

?>

<div class="container mb-70">

  <?php // if($userId == 999) { 
  ?>

  <div class="row pt-10">
    <form class="col s12 " method="POST" action="dashboard.php">
      <div class="row">
        <div class="input-field col s6">
          <input id="du" type="date" name="du" class="validate">
          <!-- value="<?php // echo date("Y-m-d");
                      ?>" -->
          <label for="du">Du</label>
        </div>
        <div class="input-field col s6">
          <input id="au" type="date" name="au" class="validate">
          <label for="au">Au</label>
        </div>

        <div class="input-field col s6">
          <select name="villeagence" style="display: block;" required>
            <!-- <option value="tout">Tout</option> -->
            <option value="">Choisir Ville Agence</option>
            <option value="lubumbashi">Lubumbashi</option>
            <option value="pweto">Pweto</option>
            <option value="lukozolo">Lukozolo</option>
            <option value="kilwa">Kilwa</option>
            <option value="Kolwezi">Kolwezi</option>
          </select>
        </div>
        <div class="input-field col s6"  >
          <select name="etat" style="display: block;" >
            <option value="nonretire" selected>NON RETRAITS</option>
            <option value="retire">RETRAITS</option>
            <option value="depot">DEPOTS</option>
          </select>
        </div>
        <div class="col s6">
          <input id="voir" name="voir" type="submit" value="voir" class="btn btn-small">
        </div>
        <div class="col s6">
          <a href="finjournee.php" class="btn red">Fin de journee</a>
        </div>
      </div>
    </form>
  </div>

  <div class="row">
    <div class="col s6">
      <h3 class="green-text"><?php
          switch ($villeagence) {
            case 'lubumbashi':
              echo 'LUBUMBASHI';
              break;
            case 'kilwa':
              echo 'KILWA';
              break;
            case 'lukozolo':
              echo 'LUKOZOLO';
              break;
            case 'kolwezi':
              echo 'KOLWEZI';
              break;
            case 'pweto':
              echo 'PWETO';
              break;
            default:
              echo 'TOUTES LES AGENCES';
              break;
          }
          ?></h3>
    </div>
  </div>

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

        echo $transaction->createStatRow($stats, $debutCompte);
        echo $transaction->generateItemsFromTransactions($transactions); 
        
        ?>

      </div>

    </tbody>
  </table>


</div>

<?php // require_once("includes/appfooter.php"); 
?>


<?php require_once("includes/footer.php"); ?>