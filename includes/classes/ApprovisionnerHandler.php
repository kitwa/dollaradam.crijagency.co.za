
<?php
class ApprovisionnerHandler
{

  private $con;

  public function __construct($con)
  {
    $this->con = $con;
  }

  public function getApprovisionnementAll(){
    $query = $this->con->prepare("SELECT * FROM approvisionning WHERE deleted = 0 ORDER BY id DESC") ;
    $query->execute();

    $approvisionnings = array();
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $transaction = new Transaction($this->con, $row, null);
        array_push($approvisionnings, $transaction);
    }

    return $approvisionnings;
}

  public function getDesapprovisionnementAll(){
    $query = $this->con->prepare("SELECT * FROM desapprovisionning WHERE deleted = 0 ORDER BY id DESC") ;
    $query->execute();

    $desapprovisionnings = array();
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $transaction = new Transaction($this->con, $row, null);
        array_push($desapprovisionnings, $transaction);
    }

    return $desapprovisionnings;
}


  public function createApprovisionnerForm()
  {

    $destination = $this->destination();

    $provenance = $this->provenance();
    $approvisionnerButton = $this->createApprovisionneButton();
    $montantEnvoyer = $this->montantEnvoyer();

    return "<form action='processingapprovisionning.php' method='POST' enctype='multipart/form-data'>
    <div class='row'>
    <div class='col s12'>
      <div class='card'>
        <div class='card-content'>

        <p>Remplir tous les champs </p>
                $destination
                $montantEnvoyer
                $provenance
                $approvisionnerButton
                </div>
                </div>
              </div>
            </div>
              </div>  
        </form>";
  }

  public function createDesapprovisionnerForm()
  {
    $destination = "";
    if($_COOKIE["CrijC"] == "0813516102") {
      $destination = $this->destination();
    }else{
      $destination = $this->destinationCompte();
    }


    $commentaire = $this->commentaire();
    $provenance = $this->provenance();
    $desapprovisionnerButton = $this->createDesapprovisionneButton();
    $montantRetirer = $this->montantRetirer();

    return "<form action='processingapprovisionning.php' method='POST' enctype='multipart/form-data'>
    <div class='row'>
    <div class='col s12'>
      <div class='card'>
        <div class='card-content'>

        <p>Remplir tous les champs </p>
                $destination
                $montantRetirer
                $provenance
                $commentaire
                $desapprovisionnerButton
                </div>
                </div>
              </div>
            </div>
              </div>  
        </form>";
  }

  
  private function destination()
  {
    return "                
    <div class='input-field'>
    <select name='destination' id='destination' required>
    <option value='' selected>De quelle agence?</option>
      <option value='lubumbashi'>Lubumbashi</option>
      <option value='pweto'>Pweto</option>
      <option value='lukozolo'>Lukozolo</option>
      <option value='kilwa'>Kilwa</option>
      <option value='kolwezi'>Kolwezi</option>
    </select>
    </div>";
  }

  private function montantEnvoyer()
  {
    return "<div class='input-field'>
          <input id='montantEnvoyer' type='text' data-length='25' name='montantEnvoyer' required>
          <label for='montantEnvoyer'>Montant Approvionné</label>
        </div>";
  }

  private function montantRetirer()
  {
    return "<div class='input-field'>
          <input id='montantRetirer' type='text' data-length='25' name='montantRetirer' required>
          <label for='montantRetirer'>Montant Desapprovionné</label>
        </div>";
  }

  private function commentaire()
  {
    return "<div class='input-field'>
          <input id='commentaire' type='text' data-length='25' name='commentaire' required>
          <label for='commentaire'>Commentaire</label>
        </div>";
  }

  private function provenance()
  {
    $provenance= "Administrateur";
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
        $provenance = 'Administrateur';
        break;
    }

    return " 
              <div class='input-field' hidden>
                <textarea id='provenance' name='provenance' class='materialize-textarea' data-length='120' required >$provenance</textarea>
                <label for='provenance'>Provenance</label>
              </div>

            ";
  }

  private function destinationCompte()
  {
    $destinationCompte= "Administrateur";
    switch ($_COOKIE["CrijC"]) {
      case '0640490820':
        $destinationCompte = 'lubumbashi';
        break;      
      case '0640490821':
        $destinationCompte = 'pweto';
        break;
      case '0640490822':
        $destinationCompte = 'kilwa';
        break;
      case '0640490823':
        $destinationCompte = 'lukozolo';
        break;
      case '0640490824':
        $destinationCompte = 'kolwezi';
        break;
      default:
        $destinationCompte = 'Administrateur';
        break;
    }

    return " 
              <div class='input-field' hidden>
                <textarea id='destination' name='destination' class='materialize-textarea' data-length='120' required >$destinationCompte</textarea>
                <label for='destination'>Destination Compte</label>
              </div>

            ";
  }

  private function createApprovisionneButton()
  {
    return "  <div class='center-align'> <input type='submit' name='approvisionnerButton' id='approvisionnerButton' class='btn teal waves-effect waves-light ' value='APPROVISIONNER'></div>";
  }

  private function createdesapprovisionneButton()
  {
    return "  <div class='center-align'> <input type='submit' name='desapprovisionnerButton' id='desapprovisionnerButton' class='btn teal waves-effect waves-light ' value='DESAPPROVISIONNER'></div>";
  }

}

?>