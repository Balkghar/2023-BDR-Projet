<?php

session_start();
require('src/model.php');


if (isset($_GET['id']) && $_GET['id'] > 0 and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
    $identifier = $_GET['id'];

    $db = new Postgresql();

    if ($db->userIsAdOwner($identifier, $_SESSION["userId"])) {
        $ad = $db->getAd($identifier);
        if ($ad['status'] == 'DELETED') {
            header("Location: /userAd.php");
        }
        require('templates/manageAd.php');
    }
} else {
    echo 'Erreur : aucun identifiant de billet envoyé';
    die;
}
