<?php
require_once("includes/header.php");
require_once("includes/classes/SearchHandler.php");


// if(!isset($_GET["text"]) || $_GET["text"] == ""){
//     echo "tapez le mot clé de votre recherche";
//     exit();
// }

if (isset($_GET["text"])) {

  $text = $_GET["text"];


  // if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views"){
  //     $orderBy = "views";
  // }else{
  //     $orderBy = "searchDate";
  // }

  $orderBy = "uploadDate";

  $searchHandler = new SearchHandler($con, null);
  $properties = $searchHandler->getProperties($text, $orderBy);
}


?>
<div class="container mb-70">
  <br>
  <div class="">
    <form action="" method="GET">
      <div class="row">
        <div class="input-field col s12 m6">
          <input placeholder=" saisissez le mot-clé" id="text" name="text" type="search" class="validate" >
          <!-- <label for="first_name"></label> -->
        </div>
        <div class="input-field col s4 m6">
          <input type='submit' name='searchButton' id='searchButton' class='btn teal waves-effect waves-light ' value='Rechercher'>

        </div>
      </div>

    </form>
  </div>

  <div class="row">
    <div class="col s12 m6">
      <?php

      if (isset($_GET["text"])) {
        $property1 = new Transaction($con, $properties, null);

        if (sizeof($properties) > 0) {

          echo $property1->generateItemsFromproperties($properties);
        } else {
          echo " 
          
            <div class='card grey lighten-3'>
              <div class='card-content black-text'>
                <span class='card-title'>Oh la la!</span>
                <p>Il n'y a aucun resultats pour votre recherche, Reessayez avec d'autres mots.</p>
              </div>
              <div class='card-action'>
                <a href='signin.php' class='blue-text'>Clicquez Ici Pour Publier.</a>
              </div>
           
          
        </div>";
        }
      }
      ?>
    </div>

  </div>

</div>

<?php require_once("includes/appfooter.php"); ?>


<?php require_once("includes/footer.php"); ?>