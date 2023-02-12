<?php
require_once("includes/headerback.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

if (isset($_COOKIE["CrijC"])) {
  header("Location: home.php");
}

$account = new Account($con);

if (isset($_POST["submitButton"])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
  $phone_number = FormSanitizer::sanitizeFormNumber($_POST["phone_number"]);
  $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

  $result = $account->resetPassword($firstName, $phone_number, $password, $password2);
  if ($result) {
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

<style>
  input {
    font-size: 1.3rem !important;
  }
</style>


<div class="container">
  <div class="valign-wrapper row login-box">
    <div class="col card hoverable s10 pull-s1 m6 pull-m3 l4 pull-l4">
      <form action="resetpassword.php" method="POST">
        <div class="center-align">
          <img class="" src="img/pwa/icon-1024.png" alt="Logo" width="100" height="100">
          <h5 class="center-align teal-text">Connectez-vous pour continuer.</h5>
        </div>
        <div class="card-content">

          <div class="row">
          <?php echo $account->getError(Constants::$numberAndFirstNameDoesntMatch); ?>
            <div class="input-field col s12">
              <label for="firstName">Prénom</label>
              <input type="text" class="validate" id="firstName" name="firstName" placeholder="Prenom" value="<?php getInputValue('firstName') ?>" required>
            </div>
            <div class="input-field col s12">
              <?php echo $account->getError(Constants::$numberDoesNotExist); ?>
              <label for="phone_number">Numéro de téléphone</label>
              <input type="number" class="validate" id="phone_number" name="phone_number" value="<?php getInputValue('phone_number') ?>" maxlength="10" required>
            </div>
            <?php echo $account->getError(Constants::$passwordDoNotMatch); ?>
            <?php echo $account->getError(Constants::$passwordNotValid); ?>
            <?php echo $account->getError(Constants::$passwordLength); ?>
            <div class="input-field col s12">
              <label for="password">Nouveau mot de passe </label>
              <input type="password" class="validate" id="password" name="password" aria-describedby="passwordlHelp" autocomplete="off" required>
            </div>

            <div class="input-field col s12">
              <label for="password2">Confirmez le mot de passe </label>
              <input type="password" class="validate" id="password2" name="password2" autocomplete="off" required>
            </div>
          </div>
          <div class="center-align">
            <!-- <input type="reset" id="reset" class="btn-flat grey-text waves-effect"> -->
            <input type="submit" name="submitButton" id="submitButton" class="btn teal waves-effect waves-light white-text" value="Réinitialiser">
          </div>
          <br>
          <div class="center-align">
            <a href="signin.php" class="">ou<br> <br><span class="btn-small waves-effect  black-text  orange lighten-4">Connectez-vous</span></a><br/><br/>
            <a class="modal-trigger blue-text text-darken-4" href="#termModal"><i>Termes et conditions.</i></a>
          </div>
        </div>




      </form>
    </div>
  </div>
</div>

<?php require_once("includes/termModal.php"); ?>

<?php require_once("includes/footer.php"); ?>