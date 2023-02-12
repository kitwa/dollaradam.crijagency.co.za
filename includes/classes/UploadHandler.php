
<?php
class UploadHandler
{

  private $con;

  public function __construct($con)
  {
    $this->con = $con;
  }

  public function createUploadForm()
  {

    $destination = $this->destination();
    $taux = $this->taux();

    $decription = $this->createDescription();
    $uploadButton = $this->createUploadButton();
    $montantEnvoyer = $this->montantEnvoyer();
    $montantTotal = $this->montantTotal();
    $code = $this->createCode();
    $gain = $this->gain();

    return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
    <div class='row'>
    <div class='col s12'>
      <div class='card'>
        <div class='card-content'>

        <p>Remplir tous les champs </p>
                $destination
                $taux
                $montantEnvoyer
                $gain
                $montantTotal
                $decription
                $code
                $uploadButton
                </div>
                </div>
              </div>
            </div>
              </div>  
        </form>";
  }

  private function createCode(){
    $code = substr(md5(uniqid(mt_rand(), true)) , 0, 7);
    return "<input name='code' id='code' type='hidden' value='$code'></input>";
  }

  
  private function destination()
  {
    return "                
    <div class='input-field'>
    <select name='destination' id='destination' required>
    <option value='' selected>Destination</option>
      <option value='lubumbashi'>Lubumbashi</option>
      <option value='pweto'>Pweto</option>
      <option value='lukozolo'>Lukozolo</option>
      <option value='kilwa'>Kilwa</option>
      <option value='kolwezi'>Kolwezi</option>
    </select>
    </div>";
  }

  private function taux()
  {
    return "<div class='input-field ' >
          <input id='taux' type='number' data-length='25' value='2.5' name='taux' required>
          <label for='taux'>Taux</label>
        </div>";
  }

  private function montantEnvoyer()
  {
    return "<div class='input-field ' >
          <input id='montantEnvoyer' type='text' data-length='25' name='montantEnvoyer' required>
          <label for='montantEnvoyer'>Montant A Envoyer</label>
        </div>";
  }

  private function montantTotal()
  {
    return "<div class='input-field ' >
          <input id='montantTotal' type='text' data-length='25' name='montantTotal' required>
          <label for='montantTotal'>Montant Total</label>
        </div>";
  }

  private function gain()
  {
    return "<div class='input-field ' >
          <input id='gain' type='text' data-length='25' name='gain' required>
          <label for='gain'>Gain</label>
        </div>";
  }

  private function createDescription()
  {
    $provenance= "Please login as an agent!";
    switch ($_COOKIE["CrijC"]) {
      case '0640490820':
        $provenance = 'lubumbashi';
        break;      
      case '0640490821':
        $provenance = 'pweto';
        break;
      case '0640490822':
        $provenance = 'kilwa';
        break;
      case '0640490823':
        $provenance = 'lukozolo';
        break;
      case '0640490824':
        $provenance = 'kolwezi';
        break;
      default:
        $provenance = 'Please login as an agent!';
        break;
    }
    return " <div class='input-field'>
                  <textarea id='expediteur' name='expediteur' class='materialize-textarea' data-length='120' required></textarea>
                  <label for='expediteur'>Expediteur</label>
                </div>
                <div class='input-field'>
                  <textarea id='recepteur' name='recepteur' class='materialize-textarea' data-length='120' required></textarea>
                  <label for='recepteur'>Recepteur</label>
                </div>

                <div class='input-field' hidden>
                <textarea id='provenance' name='provenance' class='materialize-textarea' data-length='120' required >$provenance</textarea>
                <label for='provenance'>Provenance</label>
              </div>

            ";
  }

  private function createUploadButton()
  {
    return "  <div class='center-align'> <input type='submit' name='uploadButton' id='uploadButton' class='btn teal waves-effect waves-light ' value='AJOUTER'></div>";
  }

}

?>