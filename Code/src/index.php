<?php

session_start();
require('src/model.php');

$db = new Postgresql();
if (isset($_GET['search'])) {
   $ads = $db->getAllAds($_GET['search']);
   if ($_GET['search'] == "") {
      header("Location: /");
   }
} else {
   $ads = $db->getAllAds("");
}

require('templates/homepage.php');


// source for the mvc : https://openclassrooms.com/fr/courses/4670706-adoptez-une-architecture-mvc-en-php/7847928-decouvrez-comment-fonctionne-une-architecture-mvc