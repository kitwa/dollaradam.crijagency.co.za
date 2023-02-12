<?php
class PropertyHandler
{
  private $property;

  public function __construct($property)
  {
    $this->property = $property;
  }

  public function view()
  {

    $imgsrc1 = $this->property->getFilePath1();
    $imgsrc2 = $this->property->getFilePath2();
    $imgsrc3 = $this->property->getFilePath3();
    $title = $this->property->getTitle();
    $uploadedBy = "Publier par " . $this->property->getUploadedBy();
    $uploadDate = "Date: " . $this->property->getUploadDate();
    $views = "Nombre de vues: " . $this->property->getViews();
    $description = $this->property->getDescription();
    $type = "Type: " . $this->property->getType();
    $price = "Prix: " . $this->property->getPrice();
    $ville = "Ville: " . $this->property->getVille();
    $deleteUrl = $this->property->getId();
    $num = $this->property->getUserNumber();

    // start this for cath
    if((preg_match('#0817477817#', $num) === 1 || preg_match('#817477817#', $num) === 1 || preg_match('#817477817#', $num) === 1)) {
      $num2 = "+27817477817";
      $num = "+27817477817";
    }
    // end cath

        // start this for gloria
        if((preg_match('#0815546187#', $num) === 1) ){
          $num2 = "+27815546187";
          $num = "+27815546187";
        }
        // end gloria

        // start this for dom
        if(preg_match('#0640490820#', $num) === 1) {
          $num2 = "+27640490820";
          $num = "+27640490820";
        }
        // end dom

    if (preg_match('#^0#', $num) === 1) {
      $num1 = substr($num, 1);
      $num2 = "+243" . $num1;
    };

    if((preg_match('#^0#', $num) !== 1 && preg_match('#243#', $num) === 1)) {
      $num2 = "+243" . $num;
    }

    $contactNumber = "<a href='tel:$num'>" . $num . "<i class='material-icons'>perm_phone_msg</i>" ."</a>" . "<a href='https://wa.me/$num2/?text=Salut, Je suis interressé par votre produit sur ujisha.' class='right'>" . "<img src='img/whatsappicon48.png' alt='whatsapp'></img>" ."</a>";

    if (isset($imgsrc1) && isset($imgsrc2) && isset($imgsrc3)) {


      return "
               <div class='row'>
               <div class='col s12 m6'>
                 <div class='card'>
                   <div class='card-image'>
                   <div class='carousel carousel-slider'>
                   <img class='carousel-item' src='$imgsrc1'>
                   <img class='carousel-item' src='$imgsrc2'>
                   <img class='carousel-item' src='$imgsrc3'>
                 </div>
                       
                   </div>
                   <div class='card-content'>
       
                     <p><span class=''>$title</span></p>
                     
                     <p>$price</p>
                     <p>$type</p>
                     <p>$ville</p>
                     <p>$uploadedBy</p>
                     <p>$views</p>
                     <p>$uploadDate</p>
                     <p>$contactNumber</p>
       
       
                   </div>
                   <div class='card-action'>
                     <a href='#' class='black-text'>$description</a>  
                   </div>
                 </div>
               </div>
       
               <div class='col s12 m6'>
               <div class='card'>
                 <div class='card-image'>
                   <img src='img/Sponsor-Logo.png' class='padding-image-4'>
            
                 </div>
                 <div class='card-content'>
                 <span class='card-title'>Publicité Sponsor ici.</span>
                   <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
                   pour un surcroît de notoriété en guise de remerciement.</p>
                 </div>
                 <div class='>
                   <a href='#'>Visite sponsor website</a>
                 </div>
               </div>
             </div>
             </div>

               ";
    } elseif (isset($imgsrc1) && isset($imgsrc2) && !isset($imgsrc3)) {
      return "
          <div class='row'>
          <div class='col s12 m6'>
            <div class='card'>
              <div class='card-image'>
              <div class='carousel carousel-slider'>
              <img class='carousel-item' src='$imgsrc1'>
              <img class='carousel-item' src='$imgsrc2'>
            </div>
                  
              </div>
              <div class='card-content'>
  
                <p><span class=''>$title</span></p>
                
                <p>$price</p>
                <p>$type</p>
                <p>$ville</p>
                <p>$uploadedBy</p>
                <p>$views</p>
                <p>$uploadDate</p>
                <p>$contactNumber</p>
  
  
              </div>
              <div class='card-action'>
                <a href='#' class='black-text'>$description</a>  
              </div>
            </div>
          </div>
  
          <div class='col s12 m6'>
          <div class='card'>
            <div class='card-image'>
              <img src='img/Sponsor-Logo.png' class='padding-image-4'>
       
            </div>
            <div class='card-content'>
            <span class='card-title'>Publicité Sponsor ici.</span>
              <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
              pour un surcroît de notoriété en guise de remerciement.</p>
            </div>
            <div class='>
              <a href='#'>Visite sponsor website</a>
            </div>
          </div>
        </div>
        </div>
  
          ";
    } elseif (isset($imgsrc1) && !isset($imgsrc2) && isset($imgsrc3)) {
      return "

          <div class='row'>
          <div class='col s12 m6'>
            <div class='card'>
              <div class='card-image'>
              <div class='carousel carousel-slider'>
              <img class='carousel-item' src='$imgsrc1'>
              <img class='carousel-item' src='$imgsrc3'>
            </div>
                  
              </div>
              <div class='card-content'>
  
                <p><span class=''>$title</span></p>
                
                <p>$price</p>
                <p>$type</p>
                <p>$ville</p>
                <p>$uploadedBy</p>
                <p>$views</p>
                <p>$uploadDate</p>
                <p>$contactNumber</p>
  
  
              </div>
              <div class='card-action'>
                <a href='#' class='black-text'>$description</a>  
              </div>
            </div>
          </div>
  
          <div class='col s12 m6'>
          <div class='card'>
            <div class='card-image'>
              <img src='img/Sponsor-Logo.png' class='padding-image-4'>
       
            </div>
            <div class='card-content'>
            <span class='card-title'>Publicité Sponsor ici.</span>
              <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
              pour un surcroît de notoriété en guise de remerciement.</p>
            </div>
            <div class='>
              <a href='#'>Visite sponsor website</a>
            </div>
          </div>
        </div>
        </div>

          ";
    } elseif (isset($imgsrc1) && !isset($imgsrc2) && !isset($imgsrc3)) {
      return "
            <div class='row'>
            <div class='col s12 m6'>
              <div class='card'>
                <div class='card-image'>

                <img class='carousel-item' src='$imgsrc1'>
      
                    
                </div>
                <div class='card-content'>
    
                  <p><span class=''>$title</span></p>
                  
                  <p>$price</p>
                  <p>$type</p>
                  <p>$ville</p>
                  <p>$uploadedBy</p>
                  <p>$views</p>
                  <p>$uploadDate</p>
                  <p>$contactNumber</p>
    
    
                </div>
                <div class='card-action'>
                  <a href='#' class='black-text'>$description</a>  
                </div>
              </div>
            </div>
    
            <div class='col s12 m6'>
            <div class='card'>
              <div class='card-image'>
                <img src='img/Sponsor-Logo.png' class='padding-image-4'>
         
              </div>
              <div class='card-content'>
              <span class='card-title'>Publicité Sponsor ici.</span>
                <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
                pour un surcroît de notoriété en guise de remerciement.</p>
              </div>
              <div class='>
                <a href='#'>Visite sponsor website</a>
              </div>
            </div>
          </div>
          </div>
    
            ";
    } else {
      return "
            <div class='row'>
            <div class='col s12 m6'>
              <div class='card'>
                <div class='card-image'>

                <img src='img/defaultimage.png'>
      
                    
                </div>
                <div class='card-content'>
    
                  <p><span class=''>$title</span></p>
                  
                  <p>$price</p>
                  <p>$type</p>
                  <p>$ville</p>
                  <p>$uploadedBy</p>
                  <p>$views</p>
                  <p>$uploadDate</p>
                  <p>$contactNumber</p>
    
    
                </div>
                <div class='card-action'>
                  <a href='#' class='black-text'>$description</a>  
                </div>
              </div>
            </div>
    
            <div class='col s12 m6'>
            <div class='card'>
              <div class='card-image'>
                <img src='img/Sponsor-Logo.png' class='padding-image-4'>
         
              </div>
              <div class='card-content'>
              <span class='card-title'>Publicité Sponsor ici.</span>
                <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
                pour un surcroît de notoriété en guise de remerciement.</p>
              </div>
              <div class='>
                <a href='#'>Visite sponsor website</a>
              </div>
            </div>
          </div>
          </div>
    
            ";
    }
  }


  public function edit()
  {

    $imgsrc1 = $this->property->getFilePath1();
    $imgsrc2 = $this->property->getFilePath2();
    $imgsrc3 = $this->property->getFilePath3();
    $title = $this->property->getTitle();
    $uploadedBy = "Publier par " . $this->property->getUploadedBy();
    $uploadDate = "Date: " . $this->property->getUploadDate();
    $views = "Nombre de vues: " . $this->property->getViews();
    $description = $this->property->getDescription();
    $type = "Type: " . $this->property->getType();
    $price = "Prix: " . $this->property->getPrice();
    $deleteUrl = $this->property->getId();
    $ville = "Ville: " . $this->property->getVille();
    $contactNumber = "Contact: " . $this->property->getUserNumber();


    return "
      <div class='row'>
      <div class='col s12 m6'>
        <div class='card'>
          <div class='card-image'>
          <div class='carousel carousel-slider'>
          <img src='$imgsrc1' class='carousel-item'>
          <img src='$imgsrc2' class='carousel-item'>
         <img src='$imgsrc3' class='carousel-item'>
        </div>
              
          </div>
          <div class='card-content'>

            <p><span class=''>$title</span><span class='right'> <a class='waves-effect waves-light btn modal-trigger ' href='#modalDelete'>SUPPRIMER</a><span></p>
            
            <p>$price</p>
            <p>$type</p>
            <p>$ville</p>
            <p>$uploadedBy</p>
            <p>$views</p>
            <p>$uploadDate</p>
            <p>$contactNumber</p>


          </div>
          <div class='card-action'>
            <a href='#' class='black-text'>$description</a>  
          </div>
        </div>
      </div>

      <div class='col s12 m6'>
      <div class='card'>
        <div class='card-image'>
          <img src='img/Sponsor-Logo.png' class='padding-image-4'>
   
        </div>
        <div class='card-content'>
        <span class='card-title'>Publicité Sponsor ici.</span>
          <p>Sponsoriser notre projet de developpement et d'amelioration de notre produit.<br>Tout sponsor aparaitra sur notre site internet
          pour un surcroît de notoriété en guise de remerciement.</p>
        </div>
        <div class='right'>
          <a href='#'>Visite sponsor website</a>
        </div>
        <br>
      </div>
    </div>
    </div>


    <div id='modalDelete' class='modal'>
      <div class='modal-content'>
        <p>Voulez-vous vraiment supprimer cet article?</p>
      </div>
      <div class='modal-footer'>
      <a href='#!' class='modal-close waves-effect waves-green btn teal'>Non</a>
        <a href='deletearticle.php?id=$deleteUrl' class='modal-close waves-effect waves-green btn red'>Oui</a>
      </div>
    </div>
      ";
  }
}
