<?php

session_start();
require('src/model.php');


if (isset($_GET['id']) && $_GET['id'] > 0 and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
    $identifier = $_GET['id'];

    $db = new Postgresql();

    if ($db->userIsRentalUser($identifier, $_SESSION["userId"])) {
        $rental = $db->getRental($identifier);
        require('templates/manageRental.php');
    }
} else {
    echo 'Erreur : aucun identifiant de billet envoyé';
    die;
}
