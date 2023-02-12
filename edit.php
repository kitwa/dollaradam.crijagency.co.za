<?php
require_once("includes/headerback.php");
require_once("includes/classes/PropertyHandler.php");



if (!isset($_GET["id"])) {
    echo "<div class='card blue-grey darken-1'> 
    <div class='card-content white-text'>
      <span class='card-title'>Oh la la, Une erreur s'est produite!</span>
      <p class='>L'article que vous essayer de voir n'existe pas ou a été supprimé  par le propriétaire.</p>
      <hr>
      <p>Merci d'avoir choisi Ujisha. </p>
    </div>
    <div class='card-action'>
      <a href='home.php'>Cliquez ici pour aller à la page d'acceuil.</a>
 
    </div>
  </div>";
    exit();
}

?>


<div class="container">

    <?php
     $property = new Transaction($con, $_GET["id"], null);
    $PropertyHandler = new TransactionHandler($property);
    echo $PropertyHandler->edit();
    

    ?>
</div>
<?php require_once("includes/deleteModal.php"); ?>


<?php require_once("includes/footer.php"); ?>