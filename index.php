<?php
require_once("includes/header.php");;
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

// if (isset($_SESSION["userLoggedIn"]) || isset($_COOKIE["CrijCookie"])) {
  if (isset($_COOKIE["CrijC"])) {
  header("Location: home.php");
}

$account = new Account($con);

if (isset($_POST["submitButton"])) {

  $phone_number = FormSanitizer::sanitizeFormNumber($_POST["phone_number"]);
  $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

  $result = $account->login($phone_number, $password);
  if ($result) {

    $_SESSION["userLoggedIn"] = $phone_number;
    setcookie("CrijC", $phone_number, time() + 60*60*365, "/");  
    header("Location: home.php");
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
<br>     <br>     <br>
  <div class="valign-wrapper row login-box ">
    <div class="col card hoverable s10 pull-s1 m6 pull-m3 l4 pull-l4">
      <form action="signin.php" method="POST">
        <div class="center-align">
          <!-- <img class="" src="img/pwa/icon-1024.png" alt="Logo" width="100" height="100"> -->
          <h5 class="center-align teal-text">Connectez-vous pour continuer.</h5>
        </div>
        <div class="card-content">

          <div class="row">
            <div class="input-field col s12">
              <?php echo $account->getError(Constants::$loginFailed); ?>
              <label for="phone_number">Numéro de téléphone</label>
              <input type="number" class="validate" id="phone_number" name="phone_number" value="<?php getInputValue('phone_number') ?>" maxlength="10" required>
            </div>
            <div class="input-field col s12">
              <label for="password">Mot de passe</label>
              <input type="password" class="validate" id="password" name="password" autocomplete="off" required>
            </div>
          </div>

          <div class="center-align">
            <input type="submit" name="submitButton" id="submitButton" class="btn teal waves-effect waves-light white-text" value="Connexion"><br><br>
          </div>
          <br>
          <div class="center-align">
            <a class="modal-trigger blue-text text-darken-4" href="#termModal"><i>Termes et conditions.</i></a>
          </div>
        </div>




      </form>
    </div>
  </div>
</div>

<?php require_once("includes/termModal.php"); ?>

<?php require_once("includes/footer.php"); ?>