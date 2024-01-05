<?php
include('header.php');

foreach ($rentals as $rental) {
    ?>
    <h3><a href="manageRental.php?id=<?= urlencode($rental['rentalid']) ?>"><?php echo($rental['title']) ?></a></h3>
    <h5>Date de location : <?php echo($rental['startdate']) ?> - <?php echo($rental['enddate']) ?></h5>
    <?php
}


include('footer.php');
