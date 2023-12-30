<?php
include('header.php');

?>
<style>
   .full-width-input {
      width: 100%;
   }
</style>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
   <div class="row">
      <div class="col pr-0">
         <input type="text" class="form-control" id="search" name="search" <?php
                                                                           if (isset($_GET['search'])) {
                                                                              echo ("value=" . $_GET['search']);
                                                                           }
                                                                           ?>>
      </div>
      <div class="col pl-0">
         <button class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
               <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
         </button>
      </div>
   </div>

   <div class="row">

      <div class="col">
         <label for="startDate">Catégorie :</label>
         <select class="form-control" name="category" id="category">
            <option value=""></option>

            <?php
            foreach ($categories as $category) {
               if (isset($_GET['category']) and $_GET['category'] == $category['name']) {
                  $tmp = "selected=\"selected\"";
               } else {
                  $tmp = "";
               }
               echo ("<option " . $tmp . " value=\"" . $category['name'] . "\">" . $category['name'] . "</option>");
            }
            ?>
         </select>
      </div>

      <div class="col">
         <label for="paymentMethod">Canton :</label>
         <select class="form-control" name="canton" id="canton">
            <option value=""></option>
            <?php
            foreach ($cantons as $canton) {
               if (isset($_GET['canton']) and $_GET['canton'] == $canton) {
                  $tmp = "selected=\"selected\"";
               } else {
                  $tmp = "";
               }
               echo ("<option " . $tmp . " value=\"" . $canton . "\">" . $canton . "</option>");
            }
            ?>
         </select>
      </div>

      <div class="col">
         <label for="startDate">Ville :</label>
         <select class="form-control" name="zipCity" id="zipCity">

            <option value=""></option>
            <?php
            foreach ($cities as $city) {
               if (isset($_GET['zipCity']) and $_GET['zipCity'] == $city['zip']) {
                  $tmp = "selected=\"selected\"";
               } else {
                  $tmp = "";
               }
               echo ("<option " . $tmp . " value=\"" . $city['zip'] . "\">" . $city['name'] . " / " . $city['zip'] . "</option>");
            }
            ?>
         </select>
      </div>
   </div>
</form><br>
<?php
foreach ($ads as $ad) {
?>
   <div class="card">
      <div class="card-body">
         <h5 class="card-title"><a href="ad.php?id=<?= urlencode($ad['id']) ?>"><?php echo ($ad['title']) ?></a></h5>
         <h6 class="card-subtitle mb-2 text-muted">Prix : <?php echo ($ad['price']) ?>
            / <?php echo ($ad['priceinterval']) ?></h6>
         <h6 class="card-subtitle mb-2 text-muted">
            Évaluation :
            <?php
            if ($ad['avg'] != null)
               echo (round($ad['avg'], 2));
            else
               echo ("-")
            ?>
         </h6>
         <p class="card-text"><?php echo ($ad['description']) ?></p>
      </div>
   </div>

<?php
}
?>

<?php


include('footer.php');
