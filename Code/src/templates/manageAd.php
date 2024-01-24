<?php require('header.php') ?>
    <div class="row no-gutters">
        <h1 class="col"><?php echo($ad['title']) ?></h1>

        <button onclick="location.href='modifyAd.php?id=<?php echo($ad['id']) ?>';"
                class="btn btn-outline-secondary col-md-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen"
                 viewBox="0 0 16 16">
                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
            </svg>
        </button>
    </div><br>
<?php showCarousel($ad); ?>
    <h6>Date de création : <?php echo(convertDateToHumanReadable($ad['creationdate'])); ?></h6>

    <h6>Catégorie : <?php echo($ad['namecategory']); ?></h6>
    <h6>Prix : <?php echo($ad['price']) ?> / <?php echo($ad['priceinterval']) ?></h6>
    <h6>Localisation : <?php echo($ad['zipcity']) ?> <?php echo($ad['city']) ?> (<?php echo($ad['canton']) ?>)</h6>
    <h6>Rating : <?php
        if ($ad['ratingavg'] != null)
            echo(round($ad['ratingavg'], 2));
        else
            echo("-")
        ?>
    </h6>
    <p><?php echo($ad['description']) ?></p>
<?php
if ($ad['status'] == "ACTIVE") {
    ?>
    <form action="desactiveAd.php" method="post">
        <input type="hidden" name="id" value="<?php echo($ad['id']) ?>">
        <input type="submit" class="btn btn-outline-secondary" value="Désactiver"/>
    </form>
    <?php
} else {
    ?>
    <form action="activateAd.php" method="post">
        <input type="hidden" name="id" value="<?php echo($ad['id']) ?>">
        <input type="submit" class="btn btn-outline-secondary" value="Activer"/>
    </form>
    <?php
}
?>
    <form action="deleteAd.php" method="post">
        <input type="hidden" name="id" value="<?php echo($ad['id']) ?>">
        <button class="btn btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                 viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg>
        </button>
    </form>
<?php require('footer.php') ?>