<?php require('header.php') ?>
<h1><a href="ad.php?id=<?= urlencode($rental['adid']) ?>"> <?php echo ($rental['title']) ?></a></h1>
<h4>État : <?php echo ($rental['statusrental']) ?></h4>
<?php
if ($rental['statusrental'] == 'RESERVATION_ASKED') {
}

switch ($rental['statusrental']) {
   case 'RESERVATION_ASKED':
?>
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
      <form action="locationOngoing.php" method="post">
         <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
         <input type="submit" class="btn btn-light" value="Location en cours" />
      </form>
   <?php
      break;
   case 'LOCATION_ONGOING':
   ?>
      <form action="itemReturned.php" method="post">
         <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
         <input type="submit" class="btn btn-light" value="Objet de retour" />
      </form>
   <?php
      break;

   case 'ITEM_RETURNED':
   ?>
      <form action="finishLocation.php" method="post">
         <input type="hidden" name="id" value="<?php echo ($rental['rentalid']) ?>">
         <input type="submit" class="btn btn-light" value="Finir la location" />
      </form>
<?php
      break;
}
?>
<h4>Méthode de paiement : <?php echo ($rental['paymentmethod']) ?></h4>
<?php
if ($rental['paymentdate'] == null) {
?>

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
