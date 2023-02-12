<?php 

require_once("includes/header.php");

// require_once("includes/classes/PropertyHandler.php");

if (!isset($_GET["id"])) {
  echo "<div class='card blue-grey darken-1'>
  <div class='card-content white-text'>
    <span class='card-title'>Oh la la, Une erreur s'est produite!</span>
    <p class='>La transaction que vous essayer de supprimer n'existe pas ou a été déjà supprimé par le propriétaire.</p>
    <hr>
    <p>Merci d'avoir choisi Ujisha. </p>
  </div>
  <div class='card-action'>
    <a href='home.php'>Cliquez ici pour aller à la page d'acceuil.</a>
  </div>
</div>";
  exit();
}

  $property = new Transaction($con, $_GET["id"], null);
  $_GET;
  $property->marquerCommeRetirer();

  if($property){
    header("Location: home.php");;
  }
else {
  echo "
  <div class='row'>
  <div class='col s12'>
    <div class='card white darken-1'>
      <div class='card-content green-text'>
        <h5 class='center-align'><span class='card-title '><i class='material-icons Large'>check_circle</i></span></h5><br>
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
  </div>
  
  ";
}


?>


