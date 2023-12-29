<?php

session_start();
require('src/model.php');
if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {

    $db = new Postgresql();

    if (isset($_POST['title']) and isset($_POST['description']) and isset($_POST['price']) and isset($_POST['interval']) and isset($_POST['category']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber'])) {

        $adId = $db->createAd($_POST['title'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['interval'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'], $_SESSION["userId"]);

        header("Location: /manageAd.php?id=" . $adId);
    } else {
        $cities = $db->getAllCity();
        $categories = $db->getAllCategory();
        $priceIntervals = $db->getEnum("PriceInterval");
    }

    require("templates/createAd.php");
} else {
    header("Location: /");
}
