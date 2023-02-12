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

$desapprovisionnings = $ApprovisionnerHandler->getDesapprovisionnementAll();

$desapprovisionning = new Desapprovisionning($con, $desapprovisionnings, null);
?>
<div class="container mb-70">

<div class="row">

</div>
<div class="row pt-2 mt-2">
<div class="col s8 ">
<h5 class="pt-2 mt-2">Listes des Desapprovisionnements</h5>
</div>

<?php          
if (isset($_COOKIE["CrijC"]) && $_COOKIE["CrijC"] == "0813516102") 
{
?>
  <div class="col s4 ">
  <a class="waves-effect waves-light btn pt-2 mt-2" href="desapprovisionner.php"><i class="material-icons right">remove_shopping_cart</i>Desapprovisionner</a>
  </div>
<?php
}
?>
</div>

  <table class="highlight ">
    <thead>
      <tr>
        <th>N*</th>
        <th>Montant</th>
        <th>Du Compte</th>
        <th>Fait Par</th>
        <th>Commentaire</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <div class="row">
        <?php
          echo $desapprovisionning->generateItemsDesapprovisionning($desapprovisionnings); 
        ?>
      </div>
    </tbody>
  </table>

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large teal" href="desapprovisionner.php">
      <i class="large material-icons">remove_shopping_cart</i>
      
    </a>
  </div>
</div>

<?php // require_once("includes/appfooter.php"); ?>

<?php require_once("includes/footer.php"); ?>