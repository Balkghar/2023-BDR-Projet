<?php require('header.php') ?>
<h1><?php echo ($ad['title']) ?></h1>
<h2>Date de création : <?php echo ($ad['creationdate']) ?></h2>
<h2>Prix : <?php echo ($ad['price']) ?></h2>
<h3>Rating : <?php
               if ($ad['avg'] != null)
                  echo (round($ad['avg'], 2));
               else
                  echo ("-")
               ?>
</h3>
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