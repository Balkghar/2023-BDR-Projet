<?php

session_start();
require('src/model.php');
if (isset($_POST["id"]) and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
   $db = new Postgresql();
   if ($db->userIsAdOwner($_POST['id'], $_SESSION["userId"])) {
      $db->activateAd($_POST['id']);
   }
   header("Location: /manageAd.php?id=" . $_POST['id']);
}

//header("Location: /");
