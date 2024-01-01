<?php
include('header.php');

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
   <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
         <div class="card-body row no-gutters align-items-center">
            <div class="col">

               <input type="text" class="form-control" id="search" name="search" <?php
                                                                                 if (isset($_GET['search'])) {
                                                                                    echo ("value=" . $_GET['search']);
                                                                                 }
                                                                                 ?>>
            </div>
            <!--end of col-->
            <div class="col-auto">
               <button class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                     <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                  </svg>
               </button>
            </div>
            <!--end of col-->
         </div>
      </div>
      <!--end of col-->
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
         <select onchange="filterCity()" class="form-control" name="canton" id="canton">
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

            <option id="default" value=""></option>
            <?php
            foreach ($cities as $city) {
               if (isset($_GET['zipCity']) and $_GET['zipCity'] == $city['zip']) {
                  $tmp = "selected=\"selected\"";
               } else {
                  $tmp = "";
               }
               echo ("<option id=\"" . $city['canton'] . "\"" . $tmp . " value=\"" . $city['zip'] . "\">" . $city['zip'] . " / " . $city['name'] . "</option>");
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
         <?php
         if ($ad['pictures'] != null) {
            // Trim each element to remove leading and trailing whitespaces
            $pictures = array_map('trim', explode(',', trim(trim($ad['pictures'], '{}'), "\"\"")));
         ?>
            <div id="carouselPictures<?= $ad['id'] ?>" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">

                  <?php foreach ($pictures as $picIndex => $picture) { ?>
                     <div class="carousel-item <?php echo ($picIndex === 0) ? 'active' : ''; ?>">
                        <img src="<?= $picture ?>" class="d-block mx-auto responsive" alt="Ad Picture">
                     </div>
                  <?php } ?>

               </div>
               <a class="carousel-control-prev" href="#carouselPictures<?= $ad['id'] ?>" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselPictures<?= $ad['id'] ?>" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </a>
            </div><br>
         <?php
         }
         ?>
         <h6 class="card-subtitle mb-2 text-muted">Catégorie : <?php echo ($ad['namecategory']); ?></h6>
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
