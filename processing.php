<?php 
require_once("includes/header.php"); 
require_once("includes/classes/TransactionData.php");
require_once("includes/classes/TransactionProcessor.php"); 



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
 

$TransactionData = new TransactionData(
$_POST["montantEnvoyer"], 
$_POST["montantTotal"], 
$_POST["expediteur"],
$_POST["recepteur"],
$_POST["provenance"],
$_POST["destination"],
$_POST["code"],
 $userLoggedInObj->getUserId(),
 $userLoggedInObj->getFullName()

);
// process image data (upload)

$TransactionProcessor = new TransactionProcessor($con);
$wasSuccessful = $TransactionProcessor->insertTransactionData($TransactionData);

// check if upload was successful

if($wasSuccessful){
    header("Location: home.php");
}
