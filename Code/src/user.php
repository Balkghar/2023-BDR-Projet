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

$user = $db->getUser($identifier);

require('templates/user.php');
