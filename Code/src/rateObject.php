<?php

session_start();
require('src/model.php');

if (isset($_POST['id']) && $_POST['id'] > 0 && isset($_POST['ratingRental']) && isset($_POST['ratingObject']) && isset($_SESSION["connected"]) && isset($_SESSION["userId"])) {
    $identifier = $_POST['id'];

    $db = new Postgresql();
    if ($db->userIsRentalUser($identifier, $_SESSION["userId"])) {
        if ($db->checkIfRentalIsNotRated($identifier, $_SESSION["userId"]))
            $db->rateObject($_POST['id'], $_SESSION["userId"], $_POST['ratingObject'], $_POST['ratingRental']);
        header('Location: /manageRental.php?id=' . $identifier);
    } else {

        header('Location: /');
    }
} else {

    header('Location: /');
}
