<?php

ob_start(); //Turns on output buffering 
session_start();

date_default_timezone_set("Africa/Harare");
define('SITE_ROOT', __DIR__);

if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost:8080") {
    try {

        $con = new PDO("mysql:dbname=agency;host=localhost", "root", "LOv1p3r");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    try {

        $con = new PDO("mysql:dbname=dollaradam;host=localhost", "agency", "Agency@1502");

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (PDOException $e) {
        echo "Connection failed1: " . $e->getMessage() . "no connection oops";
    }
}





// CREATE USER 'dollaradam'@'localhost' IDENTIFIED BY 'Agency@1502';

// GRANT ALL PRIVILEGES ON * . * TO 'agency'@'localhost';

// FLUSH PRIVILEGES;


/******  Instruction to reset  *****/

// truncate desapprovisionning;
// truncate approvisionning;
// truncate transaction;
