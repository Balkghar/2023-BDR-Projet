<?php
include('header.php');

foreach ($ads as $ad) {
?>
   <h3><a href="ad.php?id=<?= urlencode($ad->getId()) ?>"><?php echo ($ad->getTitle()) ?></a></h3>
   <h5>Date de création : <?php echo ($ad->getCreationDate()) ?></h5>
   <h5>Prix : <?php echo ($ad->getPriceInfo()) ?></h5>
   <p><?php echo ($ad->getDescription()) ?></p>
<?php
}


include('footer.php');
