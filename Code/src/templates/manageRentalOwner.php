<?php require('header.php') ?>
<h1><a href="ad.php?id=<?= urlencode($rental['adid']) ?>"> <?php echo ($rental['title']) ?></a></h1>
<?php
if ($rental['statusrental'] == 'RESERVATION_ASKED') {
}

switch ($rental['statusrental']) {
    case 'RESERVATION_ASKED':
?>

        <h4>État : Demande de réservation</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
        <div class="input-group">
            <form action="confirmateRental.php" method="post">
                <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                <input type="submit" class="btn btn-light" value="Confirmer la location" />
            </form>

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
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
        <div class="input-group">
            <form action="locationOngoing.php" method="post">
                <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                <input type="submit" class="btn btn-light" value="Location en cours" />
            </form>
            <form action="cancelLocation.php" method="post">
                <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                <input type="submit" class="btn btn-light" value="Annuler la location" />
            </form>
        </div>
    <?php
        break;
    case 'LOCATION_ONGOING':
    ?>

        <h4>État : Location en cours</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
        <form action="itemReturned.php" method="post">
            <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
            <input type="submit" class="btn btn-light" value="Objet de retour" />
        </form>
    <?php
        break;

    case 'ITEM_RETURNED':
    ?>
        <h4>État : Objet rendu</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
        <form action="finishLocation.php" method="post">
            <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
            <input type="submit" class="btn btn-light" value="Finir la location" />
        </form>
    <?php
        break;

    case 'RESERVATION_CANCELED':
    ?>
        <h4>État : Réservation annulée</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
    <?php
        break;

    case 'LOCATION_CANCELED':
    ?>
        <h4>État : Location annulée</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
    <?php
        break;

    case 'LOCATION_FINISHED':
    ?>
        <h4>État : Location finie</h4>
        <h5>Mail du loueur : <?php echo ($rental['rentermail']); ?></h5>
        <?php
        if ($rentalIsNotRated) { ?>
            <form action="rateUser.php" method="post">
                <div class="form-group">
                    <label>Note de la location : </label>
                    <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
                    <input class="form-control" type="number" max="5" name="rating" step="1" required>
                </div>
                <div class="form-group">
                    <label>Commentaire : </label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" cols="50" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-light" value="Évaluer la location" />
                </div>
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
    <form action="paymentDone.php" method="post">
        <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
        <input type="submit" class="btn btn-light" value="Paiement effectué" />
    </form>
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
