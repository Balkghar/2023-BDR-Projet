<?php

session_start();
require('src/model.php');

if (isset($_SESSION["connected"]) && isset($_SESSION["userId"])) {
    $db = new Postgresql();
    $user = $db->getProfile($_SESSION["userId"]);
    require("templates/account.php");
} else {
    header("Location: /");
}
