<?php
include('header.php');

?>
<form method="get" action="/index.php">
   <input type="text" placeholder="Chercher.." name="search">
   <input type="submit" value="🔍">
</form>
<?php
foreach ($ads as $ad) {
?>
   <h3><a href="ad.php?id=<?= urlencode($ad['id']) ?>"><?php echo ($ad['title']) ?></a></h3>
   <h5>Date de création : <?php echo ($ad['creationdate']) ?></h5>
   <h5>Prix : <?php echo ($ad['price']) ?></h5>
   <p><?php echo ($ad['description']) ?></p>
<?php
}


include('footer.php');
