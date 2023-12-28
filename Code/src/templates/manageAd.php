<?php require('header.php') ?>
<h1><?php echo ($ad['title']) ?></h1>
<h6>Date de création : <?php echo ($ad['creationdate']) ?></h6>
<h6>Prix : <?php echo ($ad['price']) ?></h6>
<h6>Rating : <?php
               if ($ad['avg'] != null)
                  echo (round($ad['avg'], 2));
               else
                  echo ("-")
               ?>
</h6>
<p><?php echo ($ad['description']) ?></p>
<?php
if ($ad['status'] == "ACTIVE") {
?> <form action="desactiveAd.php" method="post">
      <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
      <input type="submit" class="btn btn-outline-secondary" value="Désactiver" />
   </form>
<?php
} else {
?>
   <form action="activateAd.php" method="post">
      <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
      <input type="submit" class="btn btn-outline-secondary" value="Activer" />
   </form>
<?php
}
?>
<form action="deleteAd.php" method="post">
   <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
   <input type="submit" class="btn btn-outline-secondary" value="🗑" />
</form>
<?php require('footer.php') ?>