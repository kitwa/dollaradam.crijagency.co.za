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

        $con = new PDO("mysql:dbname=crijagency;host=localhost", "agency", "Agency@1502");
        // $con = new PDO("mysql:dbname=agencytest;host=localhost", "agencytest", "Test@2021");

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (PDOException $e) {
        echo "Connection failed1: " . $e->getMessage() . "no connection oops";
    }
}

// drop user 'agency'@'localhost';

// // mysqldump -h localhost -u root -p agency > backup_db.sql

// mysqldump -h localhost -u agency -p crijagency > backup_db.sql



// CREATE USER 'agency'@'localhost' IDENTIFIED BY 'Agency@1502';

// GRANT ALL PRIVILEGES ON * . * TO 'agency'@'localhost';

// FLUSH PRIVILEGES;

// CREATE USER 'agencytest'@'localhost' IDENTIFIED BY 'Test@2021';

// GRANT ALL PRIVILEGES ON * . * TO 'agencytest'@'localhost';

// FLUSH PRIVILEGES;

// UPDATE `users` SET `password`='9c1a3a68f67af35c0f4ed34c8f87b241' WHERE `id`='1';


/******  Instruction to reset  *****/

// truncate desapprovisionning;
// truncate approvisionning;
// truncate transaction;
