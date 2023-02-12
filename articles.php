<style>

.textover {
  /* display: inline-block; */
          text-overflow: ellipsis;
          word-wrap: break-word;
          overflow: hidden;
          max-height: 1.5em;
          /* line-height: 1.8em; */
          max-width: 5%;
      }
</style>

<?php
require_once("includes/header.php");

require_once("includes/classes/ArticlesHandler.php");


$ArticlesHandler = new ArticlesHandler($con);
$properties = $ArticlesHandler->getProperties();


$property1 = new Transaction($con, $properties, null);

?>
<div class="container mb-70">

  <?php

  if (sizeof($properties) > 0) {

    echo $property1->generateItemsFromproperties($properties);

    echo "  <ul class='pagination center'>
    <li class='disabled'><a href='#!'><i class='material-icons'>chevron_left</i></a></li>
    <li class='active'><a href='articles.php'>1</a></li>
    <li class='waves-effect'><a href='articles_page2.php'>2</a></li>
    <li class='waves-effect'><a href='articles_page3.php'>3</a></li>
    <li class='waves-effect'><a href='articles_page2.php'><i class='material-icons'>chevron_right</i></a></li></ul>";
  } else {
    echo " <div class='row'>
        <div class='col s12'>
          <div class='card grey lighten-3'>
            <div class='card-content black-text'>
              <span class='card-title'>Oh la la!</span>
              <p>Il n'y a aucun articles publiez en ce moment.</p>
            </div>
            <div class='card-action'>
              <a href='signin.php'  class='blue-text'>Clicquez Ici Pour Publier.</a>
            </div>
          </div>
        </div>

        <div class='col s12 '>
        <div class='card blue-grey darken-1'>
          <div class='card-content white-text'>
            <span class='card-title'>Publicité Sponsor ici.</span>
            <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
             pour un surcroît de notoriété en guise de remerciement.</p>
          </div>
          <div class='card-action'>
            <a href='#'>Voir plus de details</a>
          </div>
        </div> 
      </div>
      </div>";
  }

  ?>


</div>
<?php require_once("includes/appfooter.php"); ?>


<?php require_once("includes/footer.php"); ?>