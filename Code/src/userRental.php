<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {


    $db = new Postgresql();

    $rentals = $db->getAllRentalsFromProfile($_SESSION['userId']);

    require('templates/userRental.php');
} else {

    header("Location: /");
}
