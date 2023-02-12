<?php
require_once("includes/config.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Transaction.php");
require_once("includes/classes/Account.php");

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

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <title>CRIJ - 3EME ADAM</title>

  <link rel="stylesheet" type="text/css" href="plugins/materialize/materialize.min.css" media="screen,projection" />
  <link rel="manifest" href="manifest.json">
  <link href="css/font-icons.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com/ https://www.gstatic.com/ https://apis.google.com/ https://www.google-analytics.com/; object-src 'self';  default-src 'self'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; media-src *; img-src 'self' https://www.google-analytics.com/ data: content:; font-src 'self' data: https://fonts.gstatic.com; connect-src 'self' https://fcm.googleapis.com  https://www.googleapis.com/ https://apis.google.com/ https://www.google-analytics.com/; frame-src https://www.youtube.com"> 
   <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Ujisha">
  <!-- <link rel="apple-touch-icon" href="img/pwa/icon-72.png" sizes="144x108"> -->
  <link rel="icon" href="img/favicon.png">
</head>

<body>
  <div class="navbar-fixed">
    <nav class="teal lighten-1" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="index.php" class="brand-logo center">CRIJ - 3EME ADAM</a>
        <a href="articles.php" data-target="nav-mobile" class="left"><i class="material-icons">home</i></a>
        <!-- <a href="#" data-target="nav-mobile" onclick="goBack()" class="left"><i class="material-icons">arrow_back</i></a> -->
      </div>
    </nav>
  </div>