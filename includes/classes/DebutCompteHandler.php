
<?php
class DebutCompteHandler
{

    private $con;
    private $lubumbashi;
    private $pweto;
    private $kilwa;
    private $lukozolo;
    private $kolwezi;
    private $total;

    public function __construct($con)
    {
        $this->con = $con;

        $this->getDebutCompte();
    }

    public function getDebutCompte() {
        $query = $this->con->prepare("SELECT id, city, debutCompte FROM users") ;
        $query->execute();

        $comptes = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            array_push($comptes, $row);
        };

        foreach ($comptes as $compte) {

            switch ($compte["city"]) {
                case 'lubumbashi':
                    $this->lubumbashi = $compte["debutCompte"];
                    break;                
                case 'pweto':
                    $this->pweto = $compte["debutCompte"];
                    break;
                case 'kilwa':
                    $this->kilwa = $compte["debutCompte"];
                    break;
                case 'lukozolo':
                    $this->lukozolo = $compte["debutCompte"];
                    break;
                case 'kolwezi':
                    $this->kolwezi = $compte["debutCompte"];
                    break;                  
                default:
                $this->total = $compte["debutCompte"];
                    break;
            }
        }
    }

    public function createUploadForm()
    {
        $lubumbashi = $this->lubumbashi();
        $pweto = $this->pweto();
        $kilwa = $this->kilwa();
        $lukozolo = $this->lukozolo();
        $kolwezi = $this->kolwezi();
        $total = $this->total();
        $uploadButton = $this->createUploadButton();

        return "<form action='processingdebutcompte.php' method='POST' enctype='multipart/form-data'>
        <div class='row'>
        <div class='col s12'>
        <div class='card'>
            <div class='card-content'>

            <p>Remplir tous les champs </p>
                    $lubumbashi
                    $pweto
                    $kilwa
                    $lukozolo
                    $kolwezi
                    $total
                    $uploadButton
                    </div>
                    </div>
                </div>
                </div>
                </div>  
        </form>";
    }


    private function lubumbashi()
    {
        return "<div class='input-field ' >
          <input id='lubumbashi' type='text' data-length='25' value='$this->lubumbashi' name='lubumbashi' required>
          <label for='lubumbashi'>Lubumbashi</label>
        </div>";
    }

    private function pweto()
    {
        return "<div class='input-field ' >
          <input id='pweto' type='text' data-length='25' value='$this->pweto' name='pweto' required>
          <label for='pweto'>Pweto</label>
        </div>";
    }

    private function kilwa()
    {
        return "<div class='input-field ' >
          <input id='kilwa' type='text' data-length='25' value='$this->kilwa' name='kilwa'  required>
          <label for='kilwa'>Kilwa</label>
        </div>";
    }

    private function lukozolo()
    {
        return "<div class='input-field ' >
          <input id='lukozolo' type='text' data-length='25' value='$this->lukozolo' name='lukozolo' required>
          <label for='lukozolo'>Lukozolo</label>
        </div>";
    }

    private function kolwezi()
    {
        return "<div class='input-field ' >
          <input id='kolwezi' type='text' data-length='25' value='$this->kolwezi' name='kolwezi' required>
          <label for='kolwezi'>Kolwezi</label>
        </div>";
    }

    private function total()
    {
        return "<div class='input-field ' >
          <input id='total' type='text' data-length='25' value='$this->total' name='total' disabled required>
          <label for='total'>Total</label>
        </div>";
    }

    private function createUploadButton()
    {
        return "  <div class='center-align'> <input type='submit' name='uploadButton' id='uploadButton' class='btn teal waves-effect waves-light ' value='SAUVER'></div>";
    }
}

?>