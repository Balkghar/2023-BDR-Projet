<?php
require('src/model.php');
require('src/ad.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
   $identifier = $_GET['id'];
} else {
   echo 'Erreur : aucun identifiant de billet envoyé';
   die;
}
$db = new Postgresql();

$ad = $db->getAd($identifier);

require('templates/ad.php');
