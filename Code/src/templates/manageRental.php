<?php require('header.php') ?>
<h1><a href="ad.php?id=<?= urlencode($rental['adid']) ?>"> <?php echo ($rental['title']) ?></a></h1>
<?php
if ($rental['statusrental'] == 'RESERVATION_ASKED') {
}
?>
<h4>Méthode de paiement :
    <?php
    switch ($rental['paymentmethod']) {
        case 'TWINT':
            echo ("Twint");
            break;

        case 'CASH':
            echo ("Argent liquide");
            break;
    }
    ?></h4>
<?php
if ($rental['paymentdate'] == null && $rental['statusrental'] != 'LOCATION_CANCELED' && $rental['statusrental'] != 'RESERVATION_CANCELED') {
?>
    <p>Paiement pas encore effectué</p>
<?php
} else {
?>
    <p>Paiement effectué le : <?php echo ($rental['paymentdate']) ?></p>
<?php
}
?>
<p>Date de départ : <?php echo ($rental['startdate']) ?> / Date de fin : <?php echo ($rental['enddate']) ?></p>
<h5>Commentaire : </h5>
<p><?php echo ($rental['comment']) ?></p>
<?php require('footer.php');
