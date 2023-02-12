<?php

// require_once '../vendor/autoload.php';


require_once("vendor/autoload.php");

use Twilio\Rest\Client;


class Twilio
{

    private $token = '1f43b432e4d7d2ae9a3094bf21842e0a';

    private $sid = 'AC45b8fc00f140d5df3b5ebb12148ee029';

    // public function __construct($token, $sid)
    // {
    //     $this->token = $token;
    //     $this->sid = $sid;
    // }

    public function sendMessage($firstName, $lastName, $phoneNumber)
    {

        $twilio = new Client($this->sid, $this->token);

        $message = $twilio->messages
            ->create(
                "+27813516102", // to
                ["body" => "Salut Dominique," . $firstName . " " . $lastName .  "numero: " . $phoneNumber . " viens de creer un compte sur ujisha.", "from" => "+12313106410"]
            );

        print($message->sid);
    }
}
