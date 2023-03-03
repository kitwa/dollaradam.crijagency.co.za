<?php require_once("includes/header.php"); ?>
<?php require_once("includes/classes/UploadHandler.php"); ?>
<?php
// if (isset($_SESSION["userLoggedIn"]) || isset($_COOKIE["CrijCookie"])) {
if (!isset($_COOKIE["CrijC"])) {
  header("Location: signin.php");
}
?>

<div class="container mb-70">

  <?php

  $formBuilder = new UploadHandler($con);
  echo $formBuilder->createUploadForm();
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
    // set, get and erase cookies

    function setCookie(name, value, days) {
      var expires = "";
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }

    function eraseCookie(name) {
      document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    // cookies end here

    $(function() {
      $("#montantEnvoyer").keyup(function(e) {
        var montantEnvoyer = document.querySelector('#montantEnvoyer').value;

        var e = document.getElementById("destination");
        var destination = e.value;

        var gain = 0;
        var x = getCookie('CrijC');
        if (x == "0640490823" || destination == "lukozolo") {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.025;
        }else if (x == "0640490824" || destination == "kolwezi") {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.015;
        } 
        else {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.02;
        }

        document.querySelector('#montantTotal').value = parseInt(montantEnvoyer) + parseInt(gain);
      });

    });

    $('select').on('change', function() {
      var montantEnvoyer = document.querySelector('#montantEnvoyer').value;

      var gain = 0;
      if (this.value == "lukozolo") {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.025;
        }else if (this.value == "kolwezi") {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.015;
        }  
        else {
          gain = document.querySelector('#gain').value = montantEnvoyer * 0.02;
        }

        document.querySelector('#montantTotal').value = parseInt(montantEnvoyer) + parseInt(gain);
    });

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