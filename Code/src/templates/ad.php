<?php require('header.php') ?>
<h3><?php echo ($ad->getTitle()) ?></h3>
<h5>Date de création <?php echo ($ad->getCreationDate()) ?></h5>
<h5>Prix : <?php echo ($ad->getPriceInfo()) ?></h5>
<p><?php echo ($ad->getDescription()) ?></p>
<?php require('footer.php') ?>