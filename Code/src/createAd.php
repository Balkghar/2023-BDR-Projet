<?php

session_start();
require('src/model.php');
if (isset($_SESSION["connected"]) and isset($_SESSION["userId"])) {

    $db = new Postgresql();

    if (isset($_POST['title']) and isset($_POST['description']) and isset($_POST['price']) and isset($_POST['interval']) and isset($_POST['category']) and isset($_POST['zipCity']) and isset($_POST['street']) and isset($_POST['streetNumber'])) {

        $adId = $db->createAd($_POST['title'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['interval'], $_POST['zipCity'], $_POST['street'], $_POST['streetNumber'], $_SESSION["userId"]);
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
                $db->addImagesToAd($adId, $uploadedFiles);
            }
        }
        header("Location: /manageAd.php?id=" . $adId);
    } else {
        $cities = $db->getAllCity();
        $categories = $db->getAllCategory();
        $priceIntervals = $db->getEnum("PriceInterval");
    }

    require("templates/createAd.php");
} else {
    header("Location: /");
}
