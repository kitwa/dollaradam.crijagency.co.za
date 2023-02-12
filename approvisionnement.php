<?php
require_once("includes/header.php");
require_once("includes/classes/ApprovisionnerHandler.php");

// if (isset($_SESSION["userLoggedIn"]) || isset($_COOKIE["CrijCookie"])) {
if (!isset($_COOKIE["CrijC"])) {
  header("Location: signin.php");
}

$ApprovisionnerHandler = new ApprovisionnerHandler($con);
$userId = $userLoggedInObj->getUserId();
$city = $userLoggedInObj->getCity();

$approvisionnings = $ApprovisionnerHandler->getApprovisionnementAll();

$approvisionning = new Approvisionning($con, $approvisionnings, null);
?>
<div class="container mb-70">

<div class="row">

</div>
<div class="row pt-2 mt-2">
<div class="col s9 ">
<h5 class="pt-2 mt-2">Listes des Approvisionnements</h5>
</div>

<div class="col s3 ">
<a class="waves-effect waves-light btn pt-2 mt-2" href="approvisionner.php"><i class="material-icons right">add</i>Approvisionner</a>
</div>
</div>

  <table class="highlight">
    <thead>
      <tr>
        <th>N*</th>
        <th>Montant Approvionné</th>
        <th>Provenance</th>
        <th>Destination</th>
        <th>Ajouter Par</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>

      <div class="row">

        <?php

        echo $approvisionning->generateItemsFromTransactions($approvisionnings); 
        ?>

      </div>

    </tbody>
  </table>

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large teal" href="approvisionner.php">
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