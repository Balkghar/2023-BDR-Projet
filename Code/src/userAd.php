<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {


    $db = new Postgresql();

    $ads = $db->getAllAdsFromUser($_SESSION['userId']);

    require('templates/userAd.php');
} else {

    header("Location: /");
}
