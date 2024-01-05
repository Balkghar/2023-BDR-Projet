<?php

session_start();
require('src/model.php');
$db = new Postgresql();
if (isset($_GET["id"]) and isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {
    if ($db->userIsAdOwner($_GET['id'], $_SESSION["userId"])) {

        $ad = $db->getAd($_GET['id']);

        $cities = $db->getAllCity();
        $categories = $db->getAllCategory();
        $priceIntervals = $db->getEnum("PriceInterval");
        require("templates/modifyAd.php");
    } else {
        header("Location: /");
    }
} else if (isset($_POST['id']) && $db->userIsAdOwner($_POST['id'], $_SESSION["userId"]) && isset($_POST['title']) and isset($_POST['description']) and isset($_POST['price']) and isset($_POST['interval']) and isset($_POST['category']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber']) and isset($_POST['idaddr'])) {

    $db->modifyAd($_POST['title'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['interval'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'], $_POST['id'], $_POST['idaddr']);

    // Handle picture deletions
    if (isset($_POST['deletePictures']) && !empty($_POST['deletePictures'])) {
        foreach ($_POST['deletePictures'] as $pictureToDelete) {
            // Delete the selected picture
            // Assuming that $ad['pictures'] is a comma-separated list of picture paths
            $db->deleteImageFromAd($_POST['id'], $pictureToDelete);
            // Delete the physical file from the server
            if (file_exists($pictureToDelete)) {
                unlink($pictureToDelete);
            }
        }
    }
    if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
        // Handle multiple image uploads
        $uploadDir = 'images/';
        $uploadedFiles = [];
        // Loop through uploaded images
        foreach ($_FILES['files']['name'] as $key => $name) {
            $tmpName = $_FILES['files']['tmp_name'][$key];
            $uploadFile = $uploadDir . basename($name);

            if (move_uploaded_file($tmpName, $uploadFile)) {
                // Save the file information in the database
                $uploadedFiles[] = $uploadFile;
            } else {
                echo "Error uploading file.";
            }
        }
        // Add the uploaded images to the advertisement
        if (!empty($uploadedFiles)) {
            $db->addImagesToAd($_POST['id'], $uploadedFiles);
        }
    }
    header("Location: /manageAd.php?id=" . $_POST['id']);
} else {
    header("Location: /");
}
