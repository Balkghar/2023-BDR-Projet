<?php
session_start();
require('src/model.php');

if (isset($_POST['mail']) and isset($_POST['password'])) {

   $db = new Postgresql();

   if ($db->connectUser($_POST['mail'], $_POST['password'])) {
      $_SESSION["connected"] = true;
      $_SESSION["userId"] = $db->getUserIdByMail($_POST['mail']);

      header("Location: /");
   }
}

require('templates/userConnection.php');
