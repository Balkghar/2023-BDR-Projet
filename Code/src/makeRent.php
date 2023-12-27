<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) and isset($_SESSION["userId"]) and isset($_POST['startDate']) and isset($_POST['endDate']) and isset($_POST['id']) and isset($_POST['paymentMethod']) and isset($_POST['comment'])) {
   $identifier = $_POST['id'];

   $db = new Postgresql();
   if (!$db->userIsAdOwner($identifier, $_SESSION["userId"]) and $_POST['startDate'] < $_POST['endDate']) {
      $db->makeReservation($_POST['startDate'], $_POST['endDate'], $identifier, $_SESSION["userId"], $_POST['comment'], $_POST['paymentMethod']);
   }
   header("Location: /ad.php?id=" . $_POST['id']);
} else {
   header("Location: /");
}
