<?php require('header.php') ?>
    <h1><?php echo($rental['title']) ?></h1>
    <h2>Date de création : <?php echo($rental['creationdate']) ?></h2>
    <h2>Prix : <?php echo($rental['price']) ?></h2>
    <h3>Rating : <?php
        if ($rental['avg'] != null)
            echo(round($rental['avg'], 2));
        else
            echo("-")
        ?>
    </h3>
    <p><?php echo($rental['description']) ?></p>
<?php require('footer.php') ?>