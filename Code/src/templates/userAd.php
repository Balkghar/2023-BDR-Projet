<?php
include('header.php');
?>

<button class="btn btn-light" onclick="location.href='createAd.php';">Créer une annonce</button><br><br>
<?php
foreach ($ads as $ad) {
?>
    <h3><a href="manageAd.php?id=<?= urlencode($ad['id']) ?>"><?php echo ($ad['title']) ?></a></h3>
    <h6>Date de création : <?php echo ($ad['creationdate']) ?></h6>
    <h5>Prix : <?php echo ($ad['price']) ?> / <?php echo ($ad['priceinterval']) ?></h5>
    <p><?php echo ($ad['description']) ?></p>
<?php
}


include('footer.php');
