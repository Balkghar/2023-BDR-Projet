<?php
include('header.php');

foreach ($rentals as $rental) {
    ?>
    <h3><a href="manageRentalOwner.php?id=<?= urlencode($rental['idrent']) ?>"><?php echo($rental['adtitle']) ?></a>
    </h3>
    <h5>Date de location : <?php echo($rental['rentstart']) ?> - <?php echo($rental['rentend']) ?></h5>
    <?php
}


include('footer.php');
