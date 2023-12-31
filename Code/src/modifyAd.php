<?php

session_start();
require('src/model.php');
$db = new Postgresql();
if (isset($_GET["id"]) and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
   if ($db->userIsAdOwner($_GET['id'], $_SESSION["userId"])) {

      $ad = $db->getAd($_GET['id']);

      $cities = $db->getAllCity();
      $categories = $db->getAllCategory();
      $priceIntervals = $db->getEnum("PriceInterval");
      require("templates/modifyAd.php");
   } else {
      header("Location: /");
   }
} else if (isset($_POST['id']) && $db->userIsAdOwner($_POST['id'], $_SESSION["userId"]) && isset($_POST['title']) and isset($_POST['description']) and isset($_POST['price']) and isset($_POST['interval']) and isset($_POST['category']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber']) and isset($_POST['idaddr'])) {

   $db->modifyAd($_POST['title'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['interval'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'], $_POST['id'], $_POST['idaddr']);

   header("Location: /manageAd.php?id=" . $_POST['id']);
} else {
   header("Location: /");
}
