<?php

session_start();
require('src/model.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
   $identifier = $_GET['id'];
} else {
   echo 'Erreur : aucun identifiant de billet envoyé';
   die;
}
$db = new Postgresql();

$ad = $db->getAd($identifier);

$paymentMethod = $db->getPaymentMethod();

if ($ad['status'] != 'ACTIVE')
   header('Location : /');

if (isset($_SESSION["userId"]) and $ad['idprofile'] == $_SESSION["userId"]) {
   header("Location: /manageAd.php?id=" . $ad['id'], true);
}

require('templates/ad.php');
