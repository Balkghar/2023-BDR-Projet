<?php

session_start();
require('src/model.php');

if (isset($_POST['id']) && $_POST['id'] > 0 && isset($_SESSION["connected"]) && isset($_SESSION["userId"])) {
    $identifier = $_POST['id'];

    $db = new Postgresql();
    if ($db->userIsRentalOwner($identifier, $_SESSION["userId"])) {
        $db->finishLocation($identifier);
        header('Location: /manageRentalOwner.php?id=' . $identifier);
    } else {

        header('Location: /');
    }
} else {

    header('Location: /');
}
