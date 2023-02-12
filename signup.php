<?php
require_once("includes/headerback.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {
  $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
  $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
  $phone_number = FormSanitizer::sanitizeFormNumber($_POST["phone_number"]);
  $phone_number2 = FormSanitizer::sanitizeFormNumber($_POST["phone_number2"]);
  $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
  $reseau_id = $_POST["reseau"];

  $result = $account->register($firstName, $lastName, $phone_number, $phone_number2, $password, $password2, $reseau_id);

  if ($result) {
    $_SESSION["userLoggedIn"] = $phone_number;
    setcookie("CrijC", $phone_number, time() + 60*60*365, "/"); 
    header("Location: signin.php");
  }
};

function getInputValue($name)
{
  if (isset($_POST[$name])) {
    echo $_POST[$name];
  }
}

?>


<div class="container">
  <div class="valign-wrapper row signup-box">
    <div class="col card hoverable s10 pull-s1 m6 pull-m3 l4 pull-l4">
      <form action="signup.php" method="POST">
        <div class="center-align">
          <img class="" src="img/pwa/icon-1024.png" alt="Logo" width="100" height="100">
          <h5 class="center-align teal-text">Inscrivez-vous pour publier, c'est gratuit.</h5>
        </div>
        <div class="card-content">

          <div class="row">
            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <div class="input-field col s6">
              <label for="firstName">Prénom</label>
              <input type="text" class="validate" id="firstName" name="firstName" placeholder="Prenom" value="<?php getInputValue('firstName') ?>" required>
            </div>
            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
            <div class="input-field col s6">
              <label for="lastName">Nom</label>
              <input type="text" class="validate" id="lastName" name="lastName" placeholder="Nom" value="<?php getInputValue('lastName') ?>" required>
            </div>
            <?php echo $account->getError(Constants::$numberDoNotMatch); ?>
            <?php echo $account->getError(Constants::$phonenumberUsed); ?>
            <div class="input-field col s12">

              <label for="phone_number">Numéro de téléphone</label>
        
              <input type="number" class="validate" id="phone_number" name="phone_number" placeholder="0990810404" data-length="10" aria-describedby="phone_numberHelp" value="<?php getInputValue('phone_number') ?>" maxlength="10" required>
              <span class="helper-text" >Le numéro où les personnes intéressées vont te contacter et avec lequel tu vas te connecter.</span>
            </div>
            
            <div class="input-field col s12">
              <label for="phone_number2">Confirmez le numéro de téléphone</label>
              <input type="number" class="validate" id="phone_number2" name="phone_number2" placeholder="0990810404" data-length="10" aria-describedby="phone_numberHelp2" value="<?php getInputValue('phone_number2') ?>" maxlength="10" required>
            </div>
            <div class="col s12">
                <label  for="reseau">Réseau</label>
                <select name="reseau">
                  <option value="1">Vodacom</option>
                  <option value="2">Airtel</option>
                  <option value="3">Orange</option>
                  <option value="4">Africel</option>
                  <option value="5">Tigo</option>
                  <option value="6">Autre</option>
                </select>
                </div>
            <?php echo $account->getError(Constants::$passwordDoNotMatch); ?>
            <?php echo $account->getError(Constants::$passwordNotValid); ?>
            <?php echo $account->getError(Constants::$passwordLength); ?>
            <div class="input-field col s12">
              <label for="password">Mot de passe </label>
              <input type="password" class="validate" id="password" name="password" aria-describedby="passwordlHelp" autocomplete="off" required>
            </div>

            <div class="input-field col s12">
              <label for="password2">Confirmez le mot de passe </label>
              <input type="password" class="validate" id="password2" name="password2" autocomplete="off" required>
            </div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha" data-sitekey="6Lf_ttsUAAAAAGGSUgFwuzsDNoV1HNpIcKHeTqtV"></div>
          </div>
          <div class="center-align">
            <!-- <input type="reset" id="reset" class="btn-flat grey-text waves-effect"> -->
            <input type="submit" name="submitButton" id="submitButton" class="btn teal waves-effect waves-light " value="Enregistrer">
          </div>
          <br>
          <div class="center-align">
            <a href="signin.php" class="">Vous avez déja un compte? <br><br>  <span class="btn-small waves-effect  black-text  orange lighten-4">Connectez-vous ici</span></a><br/><br/>
            <a class="modal-trigger blue-text text-darken-4" href="#termModal"><i>En cliquant sur le button ENREGISTRER vous acceptez nos termes et conditions.</i></a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once("includes/termModal.php"); ?>
<?php require_once("includes/footer.php"); ?>
<div id="loading" class="modal">
    <div class='row'>
      <div class='col s12'>
        <div class="modal-content">
          <h4 class="center-align">Patientez svp.</h4>
          <h5 class="center-align">
            <img src="img/loading-spinner.gif" alt="patientez">
          </h5>

        </div>
      </div>
    </div>
  </div>

<script>
$(document).ready(function(){
  $('select').formSelect();
});

$("form").submit(function() {
      $('.modal').modal('open', {
        dismissible: false
      });
    })

$(document).ready(function() {
    $('input#phone_number, input#phone_number2').characterCounter();
  });

  
</script>