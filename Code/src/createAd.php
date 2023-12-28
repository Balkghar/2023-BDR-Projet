<?php

session_start();
require('src/model.php');
if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {

    $db = new Postgresql();
    $categories = $db->getAllCategory();
    $priceIntervals = $db->getEnum("PriceInterval");
    require("templates/createAd.php");
} else if (isset($_SESSION["connected"]) and isset($_SESSION["userId"]) and isset($_POST['title']) and isset($_POST['description']) and isset($_POST['price']) and isset($_POST['priceInterval']) and isset($_POST['category'])) {
    $identifier = $_POST['id'];

    $db = new Postgresql();
    // todo method to create ad
    // todo method to create address
    $db->createAd($_POST['title'], $_POST['description'], $_POST['price'], $_POST['priceInterval'], $_POST['category'], $_SESSION["userId"]);
    header("Location: /ad.php?id=" . $_POST['id']);
} else {
    header("Location: /");
}
