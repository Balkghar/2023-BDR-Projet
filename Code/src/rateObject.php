<?php

session_start();
require('src/model.php');

if (isset($_POST['id']) && $_POST['id'] > 0 && isset($_POST['rating']) && isset($_SESSION["connected"]) && isset($_SESSION["userId"])) {
   $identifier = $_POST['id'];

   $db = new Postgresql();
   if ($db->userIsRentalUser($identifier, $_SESSION["userId"])) {
      if (!$db->checkIfRentalIsRated($identifier) && !$db->checkIfObjectIsRated($identifier))
         $db->rateObject($_POST['id'], $_POST['rating']);
      header('Location: /manageRental.php?id=' . $identifier);
   } else {

      header('Location: /');
   }
} else {

   header('Location: /');
}
