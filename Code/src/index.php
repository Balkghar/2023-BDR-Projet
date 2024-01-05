<?php

session_start();
require('src/model.php');

$db = new Postgresql();
$cities = $db->getAllCity();
$cantons = $db->getAllCanton();
$categories = $db->getAllCategory();

if (isset($_GET['search']) and isset($_GET['category']) and isset($_GET['canton']) and isset($_GET['zipCity'])) {
    if ($_GET['search'] == "" and $_GET['category'] == "" and $_GET['canton'] == "" and $_GET['zipCity'] == "") {
        header("Location: /");
    }
    $ads = $db->getAllAds($_GET['search'], $_GET['category'], $_GET['canton'], $_GET['zipCity']);
} else {
    $ads = $db->getAllAds("", "", "", "");
}

require('templates/homepage.php');


// source for the mvc : https://openclassrooms.com/fr/courses/4670706-adoptez-une-architecture-mvc-en-php/7847928-decouvrez-comment-fonctionne-une-architecture-mvc