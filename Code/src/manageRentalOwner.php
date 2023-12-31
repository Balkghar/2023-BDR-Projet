<?php

session_start();
require('src/model.php');


if (isset($_GET['id']) && $_GET['id'] > 0 and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
    $identifier = $_GET['id'];

    $db = new Postgresql();

    if ($db->userIsRentalOwner($identifier, $_SESSION["userId"])) {
        $rental = $db->getRental($identifier);
        $rentalIsNotRated = $db->checkIfRentalIsRated($identifier);
        require('templates/manageRentalOwner.php');
    } else {
        header("Location: /");
    }
} else {
    header("Location: /");
}
