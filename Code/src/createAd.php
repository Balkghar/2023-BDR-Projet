<?php

session_start();
require('src/model.php');
if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {

   $db = new Postgresql();
   $categories = $db->getAllCategory();
   $priceIntervals = $db->getEnum("PriceInterval");
   require("templates/createAd.php");
} else {
   header("Location: /");
}
