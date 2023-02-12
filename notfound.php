<?php
require_once("includes/headerindex.php");
?>

<div class="container">
  <div class="row">
    <div class="col s12">

      <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">Oh la la, Une erreur s'est produite!</span>
          <p class="">Ceci apparait lorsque vous avez entré une mauvaise addresse ou le lien vers cette addresse est endommagée.</p>
          <hr>
          <p>Notre équipe est au courant et y travaille. Merci pour avoir choisi Ujisha. </p>
        </div>
        <div class="card-action">
          <a href="index.php">Cliquez ici pour aller à la page d'acceuil.</a>
          <!-- <a href="#">This is a link</a> -->
        </div>
      </div>
    </div>
  </div>
</div>



<?php require_once("includes/footer.php"); ?>