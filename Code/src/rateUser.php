<?php

session_start();
require('src/model.php');

if (isset($_POST['id']) && $_POST['id'] > 0 && isset($_POST['rating']) && isset($_SESSION["connected"]) && isset($_SESSION["userId"]) && isset($_POST['comment'])) {
    $identifier = $_POST['id'];

    $db = new Postgresql();
    if ($db->userIsRentalOwner($identifier, $_SESSION["userId"])) {
        if ($db->checkIfRentalIsNotRated($identifier, $_SESSION["userId"]))
            $db->rateRental($_POST['id'], $_SESSION["userId"], $_POST['rating'], $_POST['comment']);
        header('Location: /manageRentalOwner.php?id=' . $identifier);
    } else {

        header('Location: /');
    }
} else {

    header('Location: /');
}
