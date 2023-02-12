<?php
require_once("includes/config.php");

?>
<html lang="fr">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148384626-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-148384626-1');
  </script>
  <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com/ https://www.gstatic.com/ https://apis.google.com/ https://www.google-analytics.com/; object-src 'self';  default-src 'self'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; media-src *; img-src 'self' https://www.google-analytics.com/ data: content:; font-src 'self' data: https://fonts.gstatic.com; connect-src 'self' https://fcm.googleapis.com  https://www.googleapis.com/ https://apis.google.com/ https://www.google-analytics.com/; frame-src https://www.youtube.com"> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <title>CRIJ - 3EME ADAM</title>

  <link rel="stylesheet" type="text/css" href="plugins/materialize/materialize.min.css" media="screen,projection" />
  <link rel="manifest" href="manifest.json">
  <link href="css/font-icons.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Ujisha">
  <!-- <link rel="apple-touch-icon" href="img/pwa/icon-72.png" sizes="144x108"> -->
  <link rel="icon" href="img/favicon.png">
</head>

<body>
  <div class="navbar-fixed">
    <nav class="teal lighten-1" role="navigation">
      <div class="nav-wrapper container">
        <form id="logo-container" class="brand-logo">
          <div class="input-field">
            <input id="search" type="search" required>
            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
          </div>
        </form>
        <ul class="right hide-on-med-and-down">
          <li><a href="index.php">Acceuil</a></li>
          <!-- <li><a href="#" onclick="javascript:developpement();">A Louer</a></li> -->
          <!-- Modal Trigger -->
          <li><a data-target="connexion" class="modal-trigger" data-modelClicked>Ajouter</a></li>
          <li><a class="waves-effect waves-light btn-small teal" href="signin.php">Connexion</a></li>
        </ul>




        <!-- Modal Structure -->
        <div id="connexion" class="modal">
          <div class="modal-content">
            <h5 class="black-text">Connectez-vous pour publier!</h5>
            <p class="black-text">Avez vous deja un compte?
              Si non, veuillez-vous &nbsp;&nbsp;<a href="signup.php" class=" waves-effect waves-green teal btn-small">Inscrire</a>
            </p>
          </div>
          <div class="modal-footer">
            <a href="signin.php" class=" waves-effect waves-green btn-flat">Connexion</a>
            <a class="modal-close waves-effect waves-green btn-flat">Quitter</a>
            <!-- <a href="#!" class="modal-close waves-effect waves-green btn-flat">Quitter</a> -->


          </div>
        </div>



        <ul id="nav-mobile" class="sidenav">
          <li>
            <div class="user-view">
              <div class="background teal lighten-2">
                <!-- <img  src="img/4.png" alt="Logo" width="100" height="150"> -->
              </div>
              <a href="#user"><img class="circle" src="img/pwa/icon-1024.png"></a>
              <!-- <p>Connectez-vous pour publier.</p> -->
              <span>CRIJ - 3EME ADAM</span>
              <!-- <a class="waves-effect waves-light btn">Connexion</a>
      <a href="#name"><span class="blue-text name">Inscription</span></a> -->
            </div>
          </li>

          <!-- <a class="waves-effect waves-light btn-small right teal " href="signup.php">Inscription</a><br> -->
          <li><a href="index.php"> <i class="material-icons">home</i> Acceuil</a></li>
          <!-- <li><a href="#" onclick="javascript:developpement();"> <i class="material-icons">hotel</i> A Louer</a></li> -->
          <li data-modelClicked2><a data-target="connexion" class="modal-trigger"> <i class="material-icons">screen_share</i> Ajouter</a></li>
          <li><a href="signin.php"> <i class="material-icons">person_pin</i> Se Connecter</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
  </div>