<?php
include('header.php');

foreach ($rentals as $rental) {
?>
    <h3><a href="manageRentalOwner.php?id=<?= urlencode($rental['idrental']) ?>"><?php echo ($rental['title']) ?></a></h3>
    <h5>Date de location : <?php echo (convertDateToHumanReadable($rental['startdate'])); ?> - <?php echo (convertDateToHumanReadable($rental['enddate'])); ?></h5>
<?php
}


include('footer.php');
