<?php
require_once("includes/config.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Transaction.php");
require_once("includes/classes/Approvisionning.php");
require_once("includes/classes/Desapprovisionning.php");
require_once("includes/classes/Account.php");

if (isset($_COOKIE["CrijC"])) {
  $usernameLoggedIn = $_COOKIE["CrijC"];
  $userLoggedInObj = new User($con, $usernameLoggedIn);
} else {
  // $userLoggedInObj = new User($con, null);
}
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

  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="plugins/materialize/materialize.min.css" media="screen,projection" />
  <link rel="manifest" href="manifest.json">
  <link href="css/font-icons.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Ujisha">
  <!-- <meta name="theme-color" content="none"> -->
 <meta name="apple-mobile-web-app-status-bar-style" content="black">
 <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <!-- <link rel="apple-touch-icon" href="img/pwa/icon-72.png" sizes="144x108"> -->
  <link rel="icon" href="img/favicon.png">

</head>

<body>
  <div class="navbar-fixed" style="z-index:1000;">
    <nav class="teal lighten-1" role="navigation">
      <div class="nav-wrapper pl-20 pr-20"><a id="logo-container" href="#" class="brand-logo">CRIJ - 3EME ADAM</a>
        <ul class="right hide-on-med-and-down">
        <li class="red-text">
          <?php 
          if (isset($_COOKIE["CrijC"]) && $_COOKIE["CrijC"] == "0813516102") 
          {
            echo $userLoggedInObj->getFirstName(); 

              echo "<li><a href='dashboard.php'>Dashboard</a></li>";
              echo "<li><a href='debutcompte.php'>Compte</a></li>";
              echo "<li><a href='approvisionnement.php'>Approvisionnement</a></li>";
              echo "<li><a href='desapprovisionnement.php'>Desapprovisionnement</a></li>";
              echo "<li><a class='waves-effect waves-light btn-small teal' href='signout.php'>Deconnexion</a></li>";

          }else if (isset($_COOKIE["CrijC"]) && $_COOKIE["CrijC"] != "0813516102") {
            echo $userLoggedInObj->getFirstName();
            echo "<li><a href='publier.php'>Ajouter</a></li>";
            echo "<li><a href='approvisionnement.php'>Approvisionnement</a></li>";
            echo "<li><a href='desapprovisionnement.php'>Desapprovisionnement</a></li>";
            echo "<li><a href='home.php'>Transactions</a></li>";
            echo "<li><a class='waves-effect waves-light btn-small teal' href='signout.php'>Deconnexion</a></li>";

          }else{
            echo "<li><a class='waves-effect waves-light btn-small teal' href='index.php'>Connexion</a></li>";
          }
          ?>
          </li>

        </ul>
        <ul id="nav-mobile" class="sidenav">
          <li>
            <div class="user-view">
              <div class="background teal lighten-2">
              </div>
              <a href="#user"><img class="circle" src="img/pwa/icon-1024.png"></a>
              <p>
                <?php
                if (!isset($_COOKIE["CrijC"])) {
                  echo " <span>Agent</span>";
                } else {
                  echo  $userLoggedInObj->getFullName();;
                }
                ?>
            </div>
          </li>
          <?php 
          if (isset($_COOKIE["CrijC"]) && $_COOKIE["CrijC"] == "0813516102") 
          {

              echo "<li><a href='dashboard.php'>Dashboard</a></li>";
              echo "<li><a href='debutcompte.php'>Compte</a></li>";
              echo "<li><a href='approvisionnement.php'>Approvisionnement</a></li>";
              echo "<li><a href='desapprovisionnement.php'>Desapprovisionnement</a></li>";
              echo "<li><a class='waves-effect waves-light btn-small teal' href='signout.php'>Deconnexion</a></li>";

          }else if (isset($_COOKIE["CrijC"]) && $_COOKIE["CrijC"] != "0813516102") {

            echo "<li><a href='publier.php'>Ajouter</a></li>";
            echo "<li><a href='home.php'>Transactions</a></li>";
            echo "<li><a href='approvisionnement.php'>Approvisionnement</a></li>";
            echo "<li><a href='desapprovisionnement.php'>Desapprovisionnement</a></li>";
            echo "<li><a class='waves-effect waves-light btn-small teal' href='signout.php'>Deconnexion</a></li>";

          }else{
            echo "<li><a class='waves-effect waves-light btn-small teal' href='index.php'>Connexion</a></li>";
          }
          ?>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
  </div>