<?php 
require_once("includes/header.php"); 
require_once("includes/classes/DebutCompteData.php");
require_once("includes/classes/DebutCompteProcessor.php"); 

if(!isset($_POST["uploadButton"])){

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
 
$DebutCompteData = new DebutCompteData(
$_POST["lubumbashi"], 
$_POST["pweto"], 
$_POST["kilwa"],
$_POST["lukozolo"],
$_POST["kolwezi"], 
);
// process image data (upload)

$DebutCompteProcessor = new DebutCompteProcessor($con);
$wasSuccessful = $DebutCompteProcessor->insertDebutCompteData($DebutCompteData);

// check if upload was successful

if($wasSuccessful){
    header("Location: debutcompte.php");
}
