<?php
include('header.php');

foreach ($ads as $ad) {
?>
   <h3><a href="manageAd.php?id=<?= urlencode($ad['id']) ?>"><?php echo ($ad['title']) ?></a></h3>
   <h5>Date de création : <?php echo ($ad['creationdate']) ?></h5>
   <h5>Prix : <?php echo ($ad['price']) ?></h5>
   <p><?php echo ($ad['description']) ?></p>
<?php
}


include('footer.php');
