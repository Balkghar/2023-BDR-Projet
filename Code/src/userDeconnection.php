<?php
session_start();
if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
    $_SESSION['connected'] = false;
    unset($_SESSION['userId']);
    header("Location: userConnection.php");
}
