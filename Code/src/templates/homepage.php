<?php
include('header.php');

$db = new Postgresql();

$ad = $db->getAllAdvertisements();

include('footer.php');
