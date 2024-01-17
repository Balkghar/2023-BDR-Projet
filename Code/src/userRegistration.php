<?php

session_start();
require('src/model.php');
if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['mail']) and isset($_POST['password']) and isset($_POST['phoneNumber']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber'])) {
    $db = new Postgresql();
    $db->registerProfile($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['password'], $_POST['phoneNumber'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber']);
} // else {
    // header("Location: /");
// }

require('templates/userRegistration.php');
