<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) && isset($_SESSION["userId"])) {
    if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['mail']) and isset($_POST['phoneNumber']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber'])) {
        $db = new Postgresql();
        $db->updateProfile($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['phoneNumber'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'], $_SESSION["userId"]);
        header("Location: /account.php");
    } else {
        $db = new Postgresql();
        $cities = $db->getAllCity();
        $user = $db->getProfile($_SESSION["userId"]);
        require("templates/modifyAccount.php");
    }
} else {
    header("Location: /");
}
