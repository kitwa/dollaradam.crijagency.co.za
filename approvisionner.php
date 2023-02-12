<?php require_once("includes/header.php"); ?>
<?php require_once("includes/classes/ApprovisionnerHandler.php"); ?>
<?php
// if (isset($_SESSION["userLoggedIn"]) || isset($_COOKIE["CrijCookie"])) {
if (!isset($_COOKIE["CrijC"])) {
  header("Location: signin.php");
}
?>

<div class="container mb-70">

  <?php

  $formBuilder = new ApprovisionnerHandler($con);
  echo $formBuilder->createApprovisionnerForm();
  ?>

  <div id="loading" class="modal">
    <div class='row'>
      <div class='col s12'>
        <div class="modal-content">
          <h4 class="center-align">Patientez svp.</h4>
          <h5 class="center-align">Ceci peut durer longtemps si votre connexion est lente.
            <br>
            <br>
            <img src="img/loading-spinner.gif" alt="patientez">
          </h5>

        </div>
      </div>
    </div>
  </div>

  <?php //require_once("includes/appfooter.php"); 
  ?>

  <?php require_once("includes/footer.php"); ?>

  <script>

    $(document).ready(function() {
      $('select').formSelect();
    });

    $("form").submit(function() {
      // var options = {

      //   opacity: 1
      // };
      //  $('.modal').modal('open');
      $('.modal').modal('open', {
        dismissible: false
      });
    })
  </script>