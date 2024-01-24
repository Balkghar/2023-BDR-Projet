<?php

session_start();
require('src/model.php');
$db = new Postgresql();
if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['mail']) and isset($_POST['password']) and isset($_POST['phoneNumber']) and isset($_POST['city']) and isset($_POST['street']) and isset($_POST['streetNumber'])) {

    $db->registerProfile($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['password'], $_POST['phoneNumber'], $_POST['city'], $_POST['street'], $_POST['streetNumber']);
    if ($db->connectProfile($_POST['mail'], $_POST['password'])) {
        $_SESSION["connected"] = true;
        $_SESSION["userId"] = $db->getProfileIdByMail($_POST['mail']);
        header("Location: /");
    }
}

$cities = $db->getAllCity();
require('templates/userRegistration.php');
