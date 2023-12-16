<?php
require('src/model.php');
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['password'], $_POST['phoneNumber'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'])) {
   $db = new Postgresql();
   $db->registerUser($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['password'], $_POST['phoneNumber'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber']);
} else {
}

require('templates/userRegistration.php');
