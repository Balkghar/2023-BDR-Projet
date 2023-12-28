<?php require('header.php') ?>
<h1><a href="ad.php?id=<?= urlencode($rental['adid']) ?>"> <?php echo ($rental['title']) ?></a></h1>
<h4>État : <?php echo ($rental['statusrental']) ?></h4>
<?php


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
