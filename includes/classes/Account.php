<?php

require_once("includes/classes/Twilio.php");
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con){
        $this->con = $con;
    }

    public function login($phone_number, $pw){

        $salt = "b84ebbc83b0f167c467784a5362942b6";
        $pw1 = hash("sha512", $pw); 
        $pw = md5($salt.$pw1);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE phone_number=:phone_number AND password=:pw");
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        }else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    public function register($fn, $ln, $phone_number, $phone_number2, $pw, $pw2, $reseau_id){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        // $this->validateEmails($em, $em2); 
        $this->validateNumbers($phone_number, $phone_number2);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)){      
            // $twilio = new Twilio();
            // $twilio->sendMessage($fn, $ln, $phone_number);
            return $this->insertUserDetails($fn, $ln, $phone_number, $pw, $reseau_id);
        }else{
            return false;
        }
    }

    public function insertUserDetails($fn, $ln, $phone_number, $pw, $reseau_id){
      
        $salt = "b84ebbc83b0f167c467784a5362942b6";
        $pw1 = hash("sha512", $pw); 
        $pw = md5($salt . $pw1); 
        $profilePicture = "img/default.png";

        $query = $this->con->prepare("INSERT INTO users (`firstName`,`lastName`, `phone_number`,`password`,`reseau_id`)
                                    VALUES(:fn, :ln, :phone_number, :pw, :reseau_id)");
        $query->bindParam(":fn", $fn);
        $query->bindParam(":ln", $ln);
        // $query->bindParam(":em", $em);
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":pw", $pw);
        $query->bindParam(":reseau_id", $reseau_id);

        return $query->execute();

    }

    
    public function resetPassword($firstName, $phone_number, $pw, $pw2){

        $this->validatePasswords($pw, $pw2);

        $salt = "b84ebbc83b0f167c467784a5362942b6";
        $pw1 = hash("sha512", $pw); 
        $pw = md5($salt.$pw1);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE phone_number=:phone_number AND firstName=:firstName");
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":firstName", $firstName);

        $query->execute();

        if($query->rowCount() == 1) {
            if(empty($this->errorArray)){      
                $this->updateUserDetails($phone_number, $pw);
                return true;
            }else{
                return false;
            }
    
        }else {
            array_push($this->errorArray, Constants::$numberAndFirstNameDoesntMatch);
            return false;
        }
 
    }

    public function updateUserDetails($phone_number, $pw){

        $query = $this->con->prepare("UPDATE `users` SET `password` =:pw WHERE `phone_number` =:phone_number");
 
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":pw", $pw);

        return $query->execute();

    }

    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
            return;
        }
    }

    private function validateEmails($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailDoNotMatch);
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em", $em);
        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$emailUsed);
        }
    }

    private function validateNumbers($phone_number, $phone_number2) {
        if($phone_number != $phone_number2) {
            array_push($this->errorArray, Constants::$numberDoNotMatch);
        }

        $query = $this->con->prepare("SELECT phone_number FROM users WHERE phone_number=:pn");
        $query->bindParam(":pn", $phone_number);
        $query->execute();
        

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$phonenumberUsed);
        }
    }
    
    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordDoNotMatch);
            return;
        }

        if (preg_match("/[^A-Za-z0-9]/", $pw)) {
            array_push($this->errorArray, Constants::$passwordNotValid);
            return;
        }

        if(strlen($pw) > 25 || strlen($pw) < 2) {
            array_push($this->errorArray, Constants::$passwordLength);
            // return;
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<p class='red-text'>$error</p>";
        }
    }
}

?>