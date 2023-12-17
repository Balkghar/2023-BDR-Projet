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
<?php require('footer.php') ?>