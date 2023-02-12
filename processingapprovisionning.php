<?php
require_once("includes/header.php");
require_once("includes/classes/ApprovisionningData.php");
require_once("includes/classes/ApprovisionningProcessor.php");

if (!isset($_POST["approvisionnerButton"]) && !isset($_POST["desapprovisionnerButton"])) {
  echo "   <div class='card blue-grey darken-1'>
    <div class='card-content white-text'>
      <span class='card-title'>Oh la la, Une erreur se produit!</span>
      <p class='>Ceci apparait lorsque vous avez entré une mauvaise addresse ou le lien vers cette addresse est endommagé.</p>
      <hr>
      <p>Notre équipe est au courant et y travaille. Merci pour avoir choisi Ujisha. </p>
    </div>
    <div class='card-action'>
      <a href='home.php'>Cliquez ici pour aller à la page d'acceuil.</a>
 
    </div>
  </div>";
  exit();
};

if (isset($_POST["approvisionnerButton"])) {
  $ApprovisionningData = new ApprovisionningData(
    $_POST["montantEnvoyer"],
    $_POST["provenance"],
    $_POST["destination"],
    $userLoggedInObj->getUserId(),
    $userLoggedInObj->getFullName()

  );
  // process image data (upload)

  $ApprovisionningProcessor = new ApprovisionningProcessor($con);
  $wasSuccessful = $ApprovisionningProcessor->insertApprovisionningData($ApprovisionningData);

  // check if upload was successful

  if ($wasSuccessful) {
    header("Location: approvisionnement.php");
  }
}

if (isset($_POST["desapprovisionnerButton"])) {
  $desapprovisionningData = new DesapprovisionningData(
    $_POST["montantRetirer"],
    $_POST["provenance"],
    $_POST["destination"],
    $_POST["commentaire"],
    $userLoggedInObj->getUserId(),
    $userLoggedInObj->getFullName()

  );
  // process image data (upload)

  $ApprovisionningProcessor = new ApprovisionningProcessor($con);
  $wasSuccessful = $ApprovisionningProcessor->insertDesapprovisionningData($desapprovisionningData);

  // check if upload was successful

  if ($wasSuccessful) {
    header("Location: desapprovisionnement.php");
  }
}

