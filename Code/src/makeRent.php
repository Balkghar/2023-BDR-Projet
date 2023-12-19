<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) and isset($_SESSION["userId"]) and isset($_POST['startDate']) and isset($_POST['endDate']) and isset($_POST['id'])) {
   $identifier = $_GET['id'];

   $db = new Postgresql();
   if (!$db->userIsAdOwner($identifier, $_SESSION["userId"]) and $_POST['startDate'] < $_POST['endDate']) {
      $db->makeReservation($_POST['startDate'], $_POST['endDate'], $identifier, $_SESSION["userId"]);
   }
}
