<?php require('header.php') ?>
<h1><?php echo ($ad['title']) ?></h1>
<?php showCarousel($ad); ?>
<h2>Date de création : <?php echo ($ad['creationdate']) ?></h2>
<h2>Prix : <?php echo ($ad['price']) ?> / <?php echo ($ad['priceinterval']) ?></h2>
<h3>Rating : <?php
                if ($ad['avg'] != null)
                    echo (round($ad['avg'], 2));
                else
                    echo ("-")
                ?>
</h3>
<p><?php echo ($ad['description']) ?></p>

<?php
if (isset($_SESSION["connected"]) and $_SESSION['connected'] == true and isset($_SESSION["userId"]) and $ad['idprofile'] != $_SESSION["userId"]) {
?>
    <form method="post" action="/makeRent.php">

        <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
        <div class="row">
            <div class="col">
                <label for="startDate">Date de départ :</label>
                <input class="form-control" type="datetime-local" id="startDate" name="startDate">
            </div>
            <div class="col">
                <label for="endDate">Date de fin :</label>
                <input class="form-control" type="datetime-local" id="endDate" name="endDate">
            </div>
        </div>

        <div class="form-group">
            <label for="paymentMethod">Méthode de paiement :</label>
            <select class="form-control" name="paymentMethod" id="paymentMethod">
                <?php
                foreach ($paymentMethod as $text) {
                    echo ("<option value=\"" . $text . "\">" . $text . "</option>");
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="comment">Commentaire :</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" cols="50"></textarea>
        </div>
        <input class="btn btn-primary" type="submit" value="Demander Location">
    </form>
<?php
}


require('footer.php')

?>