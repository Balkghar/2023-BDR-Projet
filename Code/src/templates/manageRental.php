<?php require('header.php') ?>
<h1><a href="ad.php?id=<?= urlencode($rental['adid']) ?>"> <?php echo ($rental['title']) ?></a></h1>
<?php
if ($rental['statusrental'] == 'RESERVATION_ASKED') {
}
switch ($rental['statusrental']) {
    case 'RESERVATION_ASKED':
?>

        <h4>État : Demande de réservation</h4>
        <div class="input-group">
            <form action="cancelRental.php" method="post">
                <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                <input type="submit" class="btn btn-light" value="Annuler la location" />
            </form>
        </div>
    <?php
        break;

    case 'RESERVATION_CONFIRMED':
    ?>
        <h4>État : Réservation confirmée</h4>
        <h5>Mail du propriétaire : <?php echo ($rental['ownermail']); ?></h5>
    <?php
        break;
    case 'LOCATION_ONGOING':
    ?>

        <h4>État : Location en cours</h4>
        <h5>Mail du propriétaire : <?php echo ($rental['ownermail']); ?></h5>
    <?php
        break;

    case 'ITEM_RETURNED':
    ?>
        <h4>État : Objet rendu</h4>
        <h5>Mail du propriétaire : <?php echo ($rental['ownermail']); ?></h5>
    <?php
        break;

    case 'RESERVATION_CANCELED':
    ?>
        <h4>État : Réservation annulée</h4>
    <?php
        break;

    case 'LOCATION_CANCELED':
    ?>
        <h4>État : Location annulée</h4>
    <?php
        break;

    case 'LOCATION_FINISHED':
    ?>
        <h4>État : Location finie</h4>
        <h5>Mail du propriétaire : <?php echo ($rental['ownermail']); ?></h5>
        <?php if ($rentalIsRated && $objectIsRated) { ?>
            <form action="rateObject.php" method="post">
                <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                <input type="number" max="5" name="rating" step="1">
                <input type="submit" class="btn btn-light" value="Évaluer l'objet" />
            </form>
<?php
        }
        break;
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
    <h5>Paiement pas encore effectué</h5>
<?php
} else {
?>
    <h5>Paiement effectué le : <?php echo ($rental['paymentdate']) ?></h5>
<?php
}
?>
<p>Date de départ : <?php echo ($rental['startdate']) ?> / Date de fin : <?php echo ($rental['enddate']) ?></p>
<h5>Commentaire : </h5>
<p><?php echo ($rental['comment']) ?></p>
<?php require('footer.php');
