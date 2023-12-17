<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {


    $db = new Postgresql();

    $rentals = $db->getAllRentalsFromOwner($_SESSION['userId']);

    require('templates/userRentalOwner.php');
} else {

    header("Location: /");
}
